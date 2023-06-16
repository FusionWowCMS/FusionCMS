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

class HostClient extends Client
{
    /**
     * @var BigInteger User's verifier
     */
    private $verifier;

    /**
     * HostClient constructor.
     *
     * @param  string  $identity
     * @param  string  $salt
     * @param  string  $verifier
     * @param  string  $clientPublicEphemeralValue
     * @param  array|null  $options
     */
    public function __construct(
        string $identity,
        string $salt,
        string $verifier,
        string $clientPublicEphemeralValue,
        array $options = null
    ) {
        $this->clientPublicEphemeralValue = new BigInteger($clientPublicEphemeralValue, 16);
        $this->verifier = new BigInteger($verifier, 16);

        parent::__construct($identity, $salt, $options);
    }

    /**
     * Returns hex of public ephemeral value
     *
     * @return string
     * @throws Exception
     */
    public function getPublicEphemeralValue(): string
    {
        $this->hostPublicEphemeralValue = $this->generateEphemeralValues();

        return $this->hostPublicEphemeralValue->toHex();
    }

    /**
     *
     */
    public function calculateSessionKey(): void
    {
        // Random scrambling parameter
        $u = $this->computeRandomScramblingParameter();
        $avu = $this->clientPublicEphemeralValue->multiply($this->verifier->powMod($u, $this->N));

        // Session key
        $this->sessionKey = $avu->powMod($this->secretEphemeralValue, $this->N);

        // Strong session key
        $this->strongSessionKey = sha1($this->sessionKey->toHex());
    }

    /**
     * @param  BigInteger  $b  Host's secret ephemeral value
     *
     * @return BigInteger Host's public ephemeral value
     */
    public function computePublicEphemeralValue(BigInteger $b): BigInteger
    {
        return $this->multiplier->multiply($this->verifier)->add($this->g->powMod($b, $this->N))->modPow(
            new BigInteger(1),
            $this->N
        );
    }

    public function validateClientSessionKeyProof(string $proof): bool
    {
        return $this->computeClientSessionKeyProof() === $proof;
    }
}
