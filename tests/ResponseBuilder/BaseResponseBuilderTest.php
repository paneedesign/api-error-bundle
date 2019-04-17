<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 20/03/19
 * Time: 12.06
 */

namespace PED\ApiErrorBundle\Tests\ResponseBuilder;

use PED\ApiErrorBundle\ExceptionMapper\AbstractParametersExtractor;
use PED\ApiErrorBundle\ExceptionMapper\ErrorDetailsMapperInterface;
use PED\ApiErrorBundle\ExceptionMapper\MappingStrategyInterface;
use PED\ApiErrorBundle\ResponseBuilder\BaseResponseBuilder;
use PHPUnit\Framework\TestCase;

class BaseResponseBuilderTest extends TestCase
{
    /**
     * @var MappingStrategyInterface
     */
    private $mappingStrategy;

    /**
     * @var AbstractParametersExtractor
     */
    private $parametersExtractor;

    /**
     * @var ErrorDetailsMapperInterface
     */
    private $exceptionMapper;

    protected function setUp(): void
    {
        $this->mappingStrategy = self::createConfiguredMock(MappingStrategyInterface::class, [
            'map' => 'A_BAD_ERROR'
        ]);

        $this->parametersExtractor = self::createConfiguredMock(AbstractParametersExtractor::class, [
            'processException' => null
        ]);

        $this->exceptionMapper = self::createConfiguredMock(ErrorDetailsMapperInterface::class, array(
            'title' => 'A bad error',
            'statusCode' => 500,
        ));
    }

    public function testBuild()
    {
        $builder = new BaseResponseBuilder(
            false,
            $this->mappingStrategy,
            $this->parametersExtractor,
            $this->exceptionMapper
        );

        $response = $builder->build(new \InvalidArgumentException('A message'));

        self::assertEquals(500, $response->getStatusCode());
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
        self::assertEquals('A_BAD_ERROR', $decodedContent['type']);
        self::assertEquals('A bad error', $decodedContent['title']);
    }

    public function testBuildParametric()
    {
        $builder = new BaseResponseBuilder(
            true,
            $this->mappingStrategy,
            self::createConfiguredMock(AbstractParametersExtractor::class, [
                'processException' =>[
                    'ONE' => 'Parameter #1',
                    'TWO' => 'Parameter #2',
                ]
            ]),
            $this->exceptionMapper
        );

        $response = $builder->build(new \InvalidArgumentException('A message'));

        $decodedContent = json_decode($response->getContent(), true);

        self::assertArrayHasKey('params', $decodedContent);
        self::assertArrayHasKey('exception', $decodedContent);
        self::assertCount(2, $decodedContent['params']);
        self::assertArrayHasKey('ONE', $decodedContent['params']);
        self::assertArrayHasKey('TWO', $decodedContent['params']);

    }
}
