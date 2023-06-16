<?php

/*
 * (c) Dmitri Petmanson <dpetmanson@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Laizerox\Wowemu\SRP;

use Exception;
use phpseclib\Math\BigInteger;
use RuntimeException;

class UserClient extends Client
{
    /**
     * Returns hex of public ephemeral value
     *
     * @return string
     * @throws Exception
     */
    public function getPublicEphemeralValue(): string
    {
        $this->clientPublicEphemeralValue = $this->generateEphemeralValues();

        return $this->clientPublicEphemeralValue->toHex();
    }

    /**
     * @param  string  $value
     */
    public function setHostPublicEphemeralValue(string $value): void
    {
        $this->hostPublicEphemeralValue = new BigInteger($value, 16);
    }

    /**
     * Generate verifier using username, password and existing salt
     *
     * @param  string  $p  User's password in plaintext
     *
     * @return string
     * @throws Exception
     */
    public function generateVerifier(string $p): string
    {
        $privateKey = $this->computePrivateKey($p);
        $verifier = $this->computeVerifier($privateKey);

        return $verifier->toHex();
    }

    /**
     * Computes private key using salt and identity which is derived from username and password
     *
     * @param  string  $p  User's password in plaintext
     *
     * @return BigInteger
     */
    public function computePrivateKey(string $p): BigInteger
    {
        if (empty($this->salt)) {
            throw new RuntimeException('Received empty salt.');
        }

        if (empty($this->username)) {
            throw new RuntimeException('Received empty username.');
        }

        $salt = $this->reverseHex($this->salt);
        $salt = hex2bin($salt);
        $identity = hash('sha1', strtoupper($this->username.':'.$p), true);

        $sha = sha1($salt.$identity);
        $sha = $this->reverseHex($sha);

        return new BigInteger($sha, 16);
    }

    /**
     * Reverses input hex
     *
     * @param  string  $string  Hex string to reverse
     *
     * @return string
     */
    private function reverseHex(string $string): string
    {
        for ($i = 0, $length = strlen($string); $i < $length; $i += 2) {
            $bytes[] = substr($string, $i, 2);
        }

        return implode(array_reverse($bytes ?? []));
    }

    /**
     * Computes verifier using private key
     *
     * @param  BigInteger  $x  Computed private key using identity and salt
     *
     * @return BigInteger
     */
    private function computeVerifier(BigInteger $x): BigInteger
    {
        return $this->g->modPow($x, $this->N);
    }

    /**
     * Generates random salt using 32 random bytes
     *
     * @return string
     * @throws Exception
     */
    public function generateSalt(): string
    {
        return $this->salt = $this->getRandomNumber(32);
    }

    /**
     * @param  BigInteger  $a  User's secret ephemeral value
     *
     * @return BigInteger User's public ephemeral value
     */
    public function computePublicEphemeralValue(BigInteger $a): BigInteger
    {
        return $this->g->powMod($a, $this->N);
    }

    /**
     * @param  BigInteger  $x  Computed private key using identity and salt
     */
    public function calculateSessionKey(BigInteger $x): void
    {
        // Random scrambling parameter
        $u = $this->computeRandomScramblingParameter();
        $v = $this->computeVerifier($x);

        $kv = $this->multiplier->multiply($v);
        $aux = $this->secretEphemeralValue->add($u->multiply($x));

        // Session key
        $this->sessionKey = $this->hostPublicEphemeralValue->subtract($kv)->modPow($aux, $this->N);

        // Strong session key
        $this->strongSessionKey = sha1($this->sessionKey->toHex());
    }

    public function validateHostSessionKeyProof(string $M, $proof): bool
    {
        return $this->computeHostSessionKeyProof($M) === $proof;
    }
}
