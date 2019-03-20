<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 20/03/19
 * Time: 12.56
 */

namespace PaneeDesign\ApiErrorBundle\Tests\ExceptionMapper;

use PaneeDesign\ApiErrorBundle\ExceptionMapper\BaseErrorDetailsMapper;
use PaneeDesign\ApiErrorBundle\ExceptionMapper\MappingStrategyInterface;
use PHPUnit\Framework\TestCase;

class BaseExceptionMapperTest extends TestCase
{
    /**
     * @throws \ReflectionException
     */
    public function testMapping()
    {
        $mappingStrategy = self::createConfiguredMock(MappingStrategyInterface::class, [
            'map' => 'A_BAD_ERROR'
        ]);

        $mapper = new BaseErrorDetailsMapper([
            'A_BAD_ERROR' => [
                'title' => 'A bad error',
                'statusCode' => 404
            ]
        ], $mappingStrategy);

        self::assertEquals('type', $mapper->type());
    }
}
