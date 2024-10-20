<?php

use MX\CI;

class Crypto
{
    public function __construct()
    {
        if (!extension_loaded('gmp')) { // make sure it's loaded
            show_error('GMP extension is not enabled.', 501);
        }
    }

    /**
     * Creates a hash of the password we enter
     *
     * @param String $username
     * @param String $password in plain text
     * @param null $salt
     * @return string|array hashed password
     */
    public function SRP6(string $username = "", string $password = "", $salt = null): string|array
    {
        is_string($username) || $username = '';
        is_string($password) || $password = '';
        is_string($salt) || $salt = $this->salt($username);

        // algorithm constants
        $g = gmp_init(7);
        $N = gmp_init('894B645E89E1535BBDAD5B8B290650530801B18EBFBF5E8FAB3C82872A3E9BB7', 16);

        // calculate first then calculate the second hash; at last convert to integer (little-endian)
        $h = gmp_import(sha1($salt . sha1(strtoupper($username . ':' . $password), true), true), 1, GMP_LSW_FIRST);

        // convert back to byte array, within a 32 pad; remember zeros go on the end in little-endian
        $verifier = str_pad(gmp_export(gmp_powm($g, $h, $N), 1, GMP_LSW_FIRST), 32, chr(0), STR_PAD_RIGHT);

        return [
            'salt' => $salt,
            'verifier' => $verifier
        ];
    }

    /**
     * Creates a hash of the password we enter
     *
     * @param String $username
     * @param String $password in plain text
     * @param null $salt
     * @return string|array hashed password
     */
    public function BnetSRP6_V1(string $username = "", string $password = "", $salt = null): string|array
    {
        is_string($username) || $username = '';
        is_string($password) || $password = '';
        is_string($salt) || $salt = $this->salt($username);

        // algorithm constants
        $g = gmp_init(2);
        $N = gmp_init('86A7F6DEEB306CE519770FE37D556F29944132554DED0BD68205E27F3231FEF5A10108238A3150C59CAF7B0B6478691C13A6ACF5E1B5ADAFD4A943D4A21A142B800E8A55F8BFBAC700EB77A7235EE5A609E350EA9FC19F10D921C2FA832E4461B7125D38D254A0BE873DFC27858ACB3F8B9F258461E4373BC3A6C2A9634324AB', 16);

        // calculate first then calculate the second hash; at last convert to integer (little-endian)
        $h = gmp_import(hash('sha256', $salt . hash('sha256', strtoupper(hash('sha256', strtoupper($username), false) . ':' . substr($password, 0, 16)), true), true), 1, GMP_LSW_FIRST);

        // convert back to byte array, within a 128 pad; remember zeros go on the end in little-endian
        $verifier = str_pad(gmp_export(gmp_powm($g, $h, $N), 1, GMP_LSW_FIRST), 128, chr(0), STR_PAD_RIGHT);

        return [
            'salt' => $salt,
            'verifier' => $verifier
        ];
    }

    /**
     * Creates a hash of the password we enter
     *
     * @param String $username
     * @param String $password in plain text
     * @param null $salt
     * @return string|array hashed password
     */
    public function BnetSRP6_V2(string $username = "", string $password = "", $salt = null): string|array
    {
        is_string($username) || $username = '';
        is_string($password) || $password = '';
        is_string($salt) || $salt = $this->salt($username);

        // algorithm constants
        $g = gmp_init(2);
        $N = gmp_init('AC6BDB41324A9A9BF166DE5E1389582FAF72B6651987EE07FC3192943DB56050A37329CBB4A099ED8193E0757767A13DD52312AB4B03310DCD7F48A9DA04FD50E8083969EDB767B0CF6095179A163AB3661A05FBD5FAAAE82918A9962F0B93B855F97993EC975EEAA80D740ADBF4FF747359D041D5C33EA71D281E446B14773BCA97B43A23FB801676BD207A436C6481F1D2B9078717461A5B9D32E688F87748544523B524B0D57D5EA77A2775D2ECFA032CFBDBF52FB3786160279004E57AE6AF874E7303CE53299CCC041C7BC308D82A5698F3A8D0C38271AE35F8E9DBFBB694B5C803D89F7AE435DE236D525F54759B65E372FCD68EF20FA7111F9E4AFF73', 16);

        $tmp = strtoupper(hash('sha256', strtoupper($username), false)) . ":" . $password;

        $iterations = 15000;
        $xBytes = hash_pbkdf2("sha512", $tmp, $salt, $iterations, 64, true);

        $x = gmp_import($xBytes, 1, GMP_MSW_FIRST);

        if (ord($xBytes[0]) & 0x80)
        {
            $fix = gmp_init('100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000', 16);
            $x = gmp_sub($x, $fix);
        }
        $x = gmp_mod($x, gmp_sub($N, 1));

        // convert back to byte array, within a 128 pad; remember zeros go on the end in little-endian
        $verifier =  str_pad(gmp_export(gmp_powm($g, $x, $N), 1, GMP_LSW_FIRST), 256, chr(0), STR_PAD_RIGHT);

        return [
            'salt' => $salt,
            'verifier' => $verifier
        ];
    }


    /**
     * Creates a hash of the password we enter
     * @param String $username
     * @param String $password in plain text
     * @return array hashed password
     */
    public function SHA_PASS_HASH(string $username = "", string $password = ""): array
    {
        if (!is_string($username)) {
            $username = "";
        }
        if (!is_string($password)) {
            $password = "";
        }

        return [
            'verifier' => sha1(strtoupper($username) . ':' . strtoupper($password))
        ];
    }

    /**
     * Creates a hash of the password we enter
     * @param String $email
     * @param String $password in plain text
     * @return array hashed password
     */
    public function SHA_PASS_HASH_V2(string $email = "", string $password = ""): array
    {
        if (!is_string($email)) {
            $email = "";
        }
        if (!is_string($password)) {
            $password = "";
        }

        return [
            'verifier' => strtoupper(bin2hex(strrev(hex2bin(strtoupper(hash("sha256", strtoupper(hash("sha256", strtoupper($email)) . ":" . strtoupper($password))))))))
        ];
    }

    /**
     * Creates a hash of the password we enter
     * @param String $username
     * @param String $password in plain text
     * @param null $salt
     * @return string|array hashed password
     */
    public function SRP(string $username = "", string $password = "", $salt = null): string|array
    {
        is_string($username) || $username = '';
        is_string($password) || $password = '';
        is_string($salt) || $salt = $this->salt($username, true);

        // algorithm constants
        $g = gmp_init(7);
        $N = gmp_init('894B645E89E1535BBDAD5B8B290650530801B18EBFBF5E8FAB3C82872A3E9BB7', 16);

        $h = gmp_init($this->reverseHex(sha1(hex2bin($this->reverseHex($salt)) . hash('sha1', strtoupper($username . ':' . $password), true))), 16);

        $verifier = strtoupper(gmp_strval(gmp_powm($g, $h, $N), 16));

        return [
            'salt' => $salt,
            'verifier' => $verifier
        ];
    }

    /**
     * Fetches salt for the user or generates a new salt one and
     * set it for them automatically if there is none.
     *
     * @param string $username
     * @return string
     */
    public function salt(string $username, bool $hex = false): string
    {
        // Retrieve salt for the user if it exists
        $saltUser = CI::$APP->external_account_model->getConnection()
            ->table(table('account'))
            ->select('TRIM("\0" FROM ' . column('account', 'salt') . ') as salt')
            ->where('username', $username)
            ->get()->getRowArray();

        if ($saltUser && isset($saltUser['salt']) && $saltUser['salt']) {
            return $saltUser['salt']; // Return the existing salt
        }

        if ($hex) {
            $salt = bin2hex(random_bytes(32));
        } else {
            $salt = random_bytes(32);
        }
        return $salt;
    }

    /**
     * Reverse a hexadecimal string.
     *
     * @param string $string The input hexadecimal string to be reversed.
     * @return string The reversed hexadecimal string.
     */
    private function reverseHex(string $string): string
    {
        for ($i = 0, $length = strlen($string); $i < $length; $i += 2) {
            $bytes[] = substr($string, $i, 2);
        }

        return implode(array_reverse($bytes ?? []));
    }
}