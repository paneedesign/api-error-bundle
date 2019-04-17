<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 20/03/19
 * Time: 14.38
 */

namespace PED\ApiErrorBundle\Tests\ExceptionMapper;

use PED\ApiErrorBundle\ExceptionMapper\FqcnMappingStrategy;
use PED\ApiErrorBundle\ExceptionMapper\MappingStrategyInterface;
use PHPUnit\Framework\TestCase;

class FqcnMappingStrategyTest extends TestCase
{

    public function testMap()
    {
        $mappingStrategy = new FqcnMappingStrategy([
            \InvalidArgumentException::class => 'INVALID_ARGUMENT'
        ]);

        self::assertEquals(
            'INVALID_ARGUMENT',
            $mappingStrategy->map(new \InvalidArgumentException('dasdsad'))
        );

        self::assertEquals(
            MappingStrategyInterface::UNKNOWN_ERROR,
            $mappingStrategy->map(new \Exception('dasdsad'))
        );
    }
}
