<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 20/03/19
 * Time: 12.06
 */

namespace PaneeDesign\ApiErrorBundle\Tests\ResponseBuilder;

use PaneeDesign\ApiErrorBundle\ExceptionMapper\ErrorDetailsMapperInterface;
use PaneeDesign\ApiErrorBundle\ResponseBuilder\BaseResponseBuilder;
use PHPUnit\Framework\TestCase;

class BaseResponseBuilderTest extends TestCase
{
    public function testBuild()
    {
        $exceptionMapper = self::createConfiguredMock(ErrorDetailsMapperInterface::class, [
            'type' => $type = 'UNKNOWN_TYPE',
            'title' => $title = 'Unknown type',
            'statusCode' => $statusCode = 500,
        ]);

        $builder = new BaseResponseBuilder($exceptionMapper, false);

        $response = $builder->build(new \InvalidArgumentException('A message'));

        self::assertEquals($statusCode, $response->getStatusCode());
        self::assertTrue(
            $response->headers->contains('Content-type', 'application/problem+json'),
            'Header type : ' . $response->headers->get('Content-type')
        );
        self::assertJson($response->getContent());

        $decodedContent = json_decode($response->getContent(), true);

        self::assertArrayHasKey('title', $decodedContent, 'Keys: ' . implode(', ', array_keys($decodedContent)));
        self::assertArrayHasKey('type', $decodedContent);
        self::assertArrayNotHasKey('exception', $decodedContent);
        self::assertArrayNotHasKey('params', $decodedContent);
        self::assertEquals($type, $decodedContent['type']);
        self::assertEquals($title, $decodedContent['title']);
    }

    public function testBuildParametric()
    {
        $exceptionMapper = self::createConfiguredMock(ErrorDetailsMapperInterface::class, [
            'type' => 'SOME_PARAMETRIC_TYPE',
            'title' => 'Some parametric type',
            'statusCode' => 404,
            'parameters' => [
                'ONE' => 'Parameter #1',
                'TWO' => 'Parameter #2',
            ]
        ]);

        $builder = new BaseResponseBuilder($exceptionMapper, true);

        $response = $builder->build(new \InvalidArgumentException('A message'));

        $decodedContent = json_decode($response->getContent(), true);

        self::assertArrayHasKey('params', $decodedContent);
        self::assertCount(2, $decodedContent['params']);
        self::assertArrayHasKey('ONE', $decodedContent['params']);
        self::assertArrayHasKey('TWO', $decodedContent['params']);

    }
}
