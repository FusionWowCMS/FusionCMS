<?php
/*
 * (c) Dmitri Petmanson <dpetmanson@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests;

use Exception;
use Laizerox\Wowemu\SRP\HostClient;
use Laizerox\Wowemu\SRP\UserClient;
use PHPUnit\Framework\TestCase;

class SRPClientIntegrationTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            [
                // Client known values
                [
                    'username' => 'admin',
                    'password' => 'admin',
                ],
                // Host known values
                [
                    'salt'     => '12ee32e201835ebc6a00c7056f08e18651633ab9cec6cfd5a1bdda413747c74c',
                    'verifier' => '2b25415d6fd90435b9506f64c15e0670bef49a9905d62f21eb573dc4ff2bbaf0',
                ],
            ],
            [
                // Client known values
                [
                    'username' => 'player',
                    'password' => 'player',
                ],
                // Host known values
                [
                    'salt'     => '50b39832882cc3174f4b566d377775ecc33af5f21fa71bcac58290595101d4e9',
                    'verifier' => '59f9d68f247ff723c46677847e042923184307f652c297726da2868670c607bf',
                ],
            ],
        ];
    }

    /**
     * @param  array  $client
     * @param  array  $host
     *
     * @dataProvider dataProvider
     * @throws Exception
     */
    public function testClientHostIntegration(array $client, array $host): void
    {
        $srpUserClient = new UserClient($client['username']);

        // 1. Client should generate public ephemeral value A and send username I to host
        $A = $srpUserClient->getPublicEphemeralValue();

        // 2. Host receives username I and public ephemeral value A.
        $srpHostClient = new HostClient($client['username'], $host['salt'], $host['verifier'], $A);
        $B = $srpHostClient->getPublicEphemeralValue();

        // 3. Client calculates its own session key
        $srpUserClient->setSalt($host['salt']);
        $srpUserClient->setHostPublicEphemeralValue($B);
        $srpUserClient->calculateSessionKey($srpUserClient->computePrivateKey($client['password']));

        // 4. Client sends proof of its session key to host
        $userSessionProof = $srpUserClient->computeClientSessionKeyProof();

        // 5. Host calculates its own session key
        $srpHostClient->calculateSessionKey();

        // 6. Host compares clients proof against its own equivalent client calculated proof
        $this->assertTrue($srpHostClient->validateClientSessionKeyProof($userSessionProof));

        // 7. Host computes & sends proof of its session key to client
        $hostSessionProof = $srpHostClient->computeHostSessionKeyProof(
            $srpHostClient->computeClientSessionKeyProof()
        );

        // 8. Client compares hosts proof against its own equivalent host calculated proof
        $this->assertTrue($srpUserClient->validateHostSessionKeyProof($userSessionProof, $hostSessionProof));

        // 9. In theory if both proofs match session keys should be same
        $this->assertEquals($srpHostClient->getSessionKey(), $srpUserClient->getSessionKey());
        $this->assertEquals($srpHostClient->getStrongSessionKey(), $srpUserClient->getStrongSessionKey());
    }
}
