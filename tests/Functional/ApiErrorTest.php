<?php
declare(strict_types=1);

namespace PaneeDesign\ApiErrorBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Client;

final class ApiErrorTest extends TestCase
{
    public function testUnexpectedApiRoute()
    {
        /** @var Client $client */
        $client = static::createClient();

        $client->request('GET', '/api/inexistent');
        $response = $client->getResponse();

        self::assertJson($response->getContent());
    }
}
