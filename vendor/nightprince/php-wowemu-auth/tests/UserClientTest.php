<?php
/*
 * (c) Dmitri Petmanson <dpetmanson@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests;

use Exception;
use Laizerox\Wowemu\SRP\UserClient;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class UserClientTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            [
                'admin',
                'admin',
                '12ee32e201835ebc6a00c7056f08e18651633ab9cec6cfd5a1bdda413747c74c',
                '2b25415d6fd90435b9506f64c15e0670bef49a9905d62f21eb573dc4ff2bbaf0',
            ],
            [
                'player',
                'player',
                '50b39832882cc3174f4b566d377775ecc33af5f21fa71bcac58290595101d4e9',
                '59f9d68f247ff723c46677847e042923184307f652c297726da2868670c607bf',
            ],
        ];
    }

    /**
     * @param $username
     * @param $password
     * @param $expectedSalt
     * @param $expectedVerifier
     *
     * @throws Exception
     * @dataProvider dataProvider
     */
    public function testNewAccountGeneration($username, $password, $expectedSalt, $expectedVerifier): void
    {
        // Create a client mock for this test case (equivalent of new UserClient($username)
        $client = $this->getMockBuilder(UserClient::class)
            ->setConstructorArgs([$username])
            ->setMethods(['getRandomNumber'])
            ->getMock();

        $client->method('getRandomNumber')->willReturn($expectedSalt);

        $salt = $client->generateSalt();
        $verifier = $client->generateVerifier($password);

        $this->assertEquals($expectedSalt, $salt);
        $this->assertEquals($expectedVerifier, $verifier);
    }

    /**
     * @param $username
     * @param $password
     * @param $salt
     * @param $expectedVerifier
     *
     * @throws Exception
     * @dataProvider dataProvider
     */
    public function testGenerateVerifierAgainstExistingData($username, $password, $salt, $expectedVerifier): void
    {
        $client = new UserClient($username, $salt);

        $this->assertEquals($expectedVerifier, $client->generateVerifier($password));
    }

    /**
     * @throws Exception
     */
    public function testGenerateVerifierWithEmptyUsername(): void
    {
        $this->expectException(RuntimeException::class);

        $client = new UserClient('');
        $client->generateVerifier('');
    }

    /**
     * @throws Exception
     */
    public function testGenerateVerifierWithEmptySalt(): void
    {
        $this->expectException(RuntimeException::class);

        $client = new UserClient('admin');
        $client->generateVerifier('admin');
    }
}
