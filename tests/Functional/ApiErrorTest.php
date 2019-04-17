<?php
declare(strict_types=1);

namespace PED\ApiErrorBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Client;

final class ApiErrorTest extends TestCase
{
    public function testUnexpectedApiRoute()
    {
        /** @var Client $client */
        $client = static::createClient();

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
    }
}
