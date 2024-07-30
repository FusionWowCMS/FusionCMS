<?php

use chillerlan\QRCode\QRCode;

class GoogleAuthenticator
{
    protected int $_codeLength = 6;
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    /**
     * Create new secret.
     * 16 characters, randomly chosen from the allowed base32 characters.
     *
     * @param int $secretLength
     *
     * @return string
     * @throws Exception
     */
    public function createSecret(int $secretLength = 16): string
    {
        $validChars = $this->getBase32LookupTable();

        // Valid secret lengths are 80 to 640 bits
        if ($secretLength < 16 || $secretLength > 128) {
            throw new Exception('Bad secret length');
        }
        $secret = '';
        $rnd = false;
        if (function_exists('random_bytes')) {
            $rnd = random_bytes($secretLength);
        } elseif (function_exists('mcrypt_create_iv')) {
            $rnd = mcrypt_create_iv($secretLength, MCRYPT_DEV_URANDOM);
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $rnd = openssl_random_pseudo_bytes($secretLength, $cryptoStrong);
            if (!$cryptoStrong) {
                $rnd = false;
            }
        }
        if ($rnd !== false) {
            for ($i = 0; $i < $secretLength; ++$i) {
                $secret .= $validChars[ord($rnd[$i]) & 31];
            }
        } else {
            throw new Exception('No source of secure random');
        }

        return $secret;
    }

    /**
     * Create new Totp Aes.
     */
    public function createTotpAes(string $secret): string
    {
        $decoded = $this->Base32Decode($secret);

        $masterKey = $this->CI->config->item('TOTPMasterSecret');

        $IV_SIZE_BYTES = 16;
        $TAG_SIZE_BYTES = 16;
        if (strlen($decoded) + $IV_SIZE_BYTES + $TAG_SIZE_BYTES > 128) {
            die('no');
            //die('The provided two-factor authentication secret is too long.');
        }

        if ($masterKey) {
            $secret = openssl_encrypt($secret, 'aes-256-gcm', $masterKey, OPENSSL_RAW_DATA, random_bytes($IV_SIZE_BYTES), $tag);
        }

        return $secret;
    }

    /**
     * Calculate the code, with given secret and point in time.
     *
     * @param string $secret
     * @param int|null $timeSlice
     *
     * @return string
     */
    public function getCode(string $secret, int $timeSlice = null): string
    {
        if ($timeSlice === null) {
            $timeSlice = floor(time() / 30);
        }

        $secretKey = $this->Base32Decode($secret);

        // Pack time into binary string
        $time = chr(0).chr(0).chr(0).chr(0).pack('N*', $timeSlice);
        // Hash it with users secret key
        $hm = hash_hmac('SHA1', $time, $secretKey, true);
        // Use last nipple of result as index/offset
        $offset = ord(substr($hm, -1)) & 0x0F;
        // grab 4 bytes of the result
        $hashPart = substr($hm, $offset, 4);

        // Unpack binary value
        $value = unpack('N', $hashPart);
        $value = $value[1];
        // Only 32 bits
        $value = $value & 0x7FFFFFFF;

        $modulo = pow(10, $this->_codeLength);

        return str_pad($value % $modulo, $this->_codeLength, '0', STR_PAD_LEFT);
    }

    function generateTOTPCode($key)
    {
        // Assuming $key is the encrypted data
        $timestamp = floor(time() / 30);
        $binaryTimestamp = pack('N*', 0) . pack('N*', $timestamp);

        // Generate HMAC-SHA1 hash of the timestamp using the key
        $hash = hash_hmac('sha1', $binaryTimestamp, $key, true);

        // Extract a 4-byte dynamic binary code from the hash
        $offset = ord($hash[19]) & 0xf;
        $code = (
                ((ord($hash[$offset + 0]) & 0x7f) << 24) |
                ((ord($hash[$offset + 1]) & 0xff) << 16) |
                ((ord($hash[$offset + 2]) & 0xff) << 8) |
                (ord($hash[$offset + 3]) & 0xff)
            ) % 1000000;

        return str_pad($code, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Get QR-Code URL for image, from Google charts.
     *
     * @param string $name
     * @param string $secret
     * @return string
     */
    public function getQRCode(string $name, string $secret): string
    {
        $otp = 'otpauth://totp/'.$name.'?secret='.$secret;

        return (new QRCode)->render($otp);
    }

    /**
     * Check if the code is correct. This will accept codes starting from $discrepancy*30sec ago to $discrepancy*30sec from now.
     *
     * @param string $secret
     * @param string $code
     * @param int $discrepancy      This is the allowed time drift in 30 second units (8 means 4 minutes before or after)
     * @param int|null $currentTimeSlice time slice if we want to use other that time()
     *
     * @return bool
     */
    public function verifyCode(string $secret, string $code, int $discrepancy = 1, int $currentTimeSlice = null): bool
    {
        if ($this->CI->config->item('totp_secret_name') == 'totp_secret') {
            $expectedCode = $this->generateTOTPCode($secret);
            return hash_equals($expectedCode, $code);
        } else {
            if ($currentTimeSlice === null) {
                $currentTimeSlice = floor(time() / 30);
            }

            if (strlen($code) != 6) {
                return false;
            }

            for ($i = -$discrepancy; $i <= $discrepancy; ++$i) {
                $calculatedCode = $this->getCode($secret, $currentTimeSlice + $i);
                if ($this->timingSafeEquals($calculatedCode, $code)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Set the code length, should be >=6.
     *
     * @param int $length
     *
     * @return GoogleAuthenticator
     */
    public function setCodeLength($length): static
    {
        $this->_codeLength = $length;

        return $this;
    }

    /**
     * Helper class to decode base32.
     *
     * @param $secret
     *
     * @return bool|string
     */
    public function Base32Decode($secret): bool|string
    {
        if (empty($secret)) {
            return '';
        }

        $base32chars = $this->getBase32LookupTable();
        $base32charsFlipped = array_flip($base32chars);

        $paddingCharCount = substr_count($secret, $base32chars[32]);
        $allowedValues = [6, 4, 3, 1, 0];
        if (!in_array($paddingCharCount, $allowedValues)) {
            return false;
        }
        for ($i = 0; $i < 4; ++$i) {
            if ($paddingCharCount == $allowedValues[$i] &&
                substr($secret, -($allowedValues[$i])) != str_repeat($base32chars[32], $allowedValues[$i])) {
                return false;
            }
        }
        $secret = str_replace('=', '', $secret);
        $secret = str_split($secret);
        $binaryString = '';
        for ($i = 0; $i < count($secret); $i = $i + 8) {
            $x = '';
            if (!in_array($secret[$i], $base32chars)) {
                return false;
            }
            for ($j = 0; $j < 8; ++$j) {
                $x .= str_pad(base_convert(@$base32charsFlipped[@$secret[$i + $j]], 10, 2), 5, '0', STR_PAD_LEFT);
            }
            $eightBits = str_split($x, 8);
            for ($z = 0; $z < count($eightBits); ++$z) {
                $binaryString .= (($y = chr(base_convert($eightBits[$z], 2, 10))) || ord($y) == 48) ? $y : '';
            }
        }

        return $binaryString;
    }

    /**
     * Get array with all 32 characters for decoding from/encoding to base32.
     *
     * @return array
     */
    protected function getBase32LookupTable(): array
    {
        return array(
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', //  7
            'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', // 15
            'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', // 23
            'Y', 'Z', '2', '3', '4', '5', '6', '7', // 31
            '=',  // padding char
        );
    }

    /**
     * A timing safe equals comparison
     * more info here: http://blog.ircmaxell.com/2014/11/its-all-about-time.html.
     *
     * @param string $safeString The internal (safe) value to be checked
     * @param string $userString The user submitted (unsafe) value
     *
     * @return bool True if the two strings are identical
     */
    private function timingSafeEquals(string $safeString, string $userString): bool
    {
        if (function_exists('hash_equals')) {
            return hash_equals($safeString, $userString);
        }
        $safeLen = strlen($safeString);
        $userLen = strlen($userString);

        if ($userLen != $safeLen) {
            return false;
        }

        $result = 0;

        for ($i = 0; $i < $userLen; ++$i) {
            $result |= (ord($safeString[$i]) ^ ord($userString[$i]));
        }

        // They are only identical strings if $result is exactly 0...
        return $result === 0;
    }
}