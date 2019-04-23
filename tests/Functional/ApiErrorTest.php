<?php
declare(strict_types=1);

namespace PED\ApiErrorBundle\Tests\Functional;

use PED\ApiErrorBundle\Tests\Functional\App\TestBundle\Controller\InvalidArgumentController;
use Symfony\Bundle\FrameworkBundle\Client;

final class ApiErrorTest extends TestCase
{
    public function testUnexpectedApiRoute()
    {
        /** @var Client $client */
        $client = static::createClient([
            'debug' => true
        ]);

        $client->request('GET', '/api/inexistent');

        $response = $client->getResponse();

        self::assertFalse($response->isSuccessful());
        self::assertJson($response->getContent());

        $decoded = json_decode($response->getContent(), true);

        self::assertArrayHasKey('type', $decoded);
        self::assertEquals('NOT_FOUND', $decoded['type']);
        self::assertArrayHasKey('title', $decoded);
        self::assertEquals('Not found', $decoded['title']);
        self::assertEquals(404, $response->getStatusCode());
        self::assertArrayNotHasKey('detail', $decoded);
    }

    public function testInvalidArgumentException()
    {
        /** @var Client $client */
        $client = static::createClient();

        $client->request('GET', '/api/invalid-argument-exception');

        $response = $client->getResponse();

        self::assertFalse($response->isSuccessful());
        self::assertJson($response->getContent());

        $decoded = json_decode($response->getContent(), true);

        self::assertArrayHasKey('type', $decoded);
        self::assertEquals('BAD_REQUEST', $decoded['type']);
        self::assertArrayHasKey('title', $decoded);
        self::assertEquals('Bad request', $decoded['title']);
        self::assertEquals(400, $response->getStatusCode());
        self::assertArrayHasKey('detail', $decoded);
        self::assertEquals(InvalidArgumentController::MESSAGE, $decoded['detail']);
    }
}
