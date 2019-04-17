<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 20/03/19
 * Time: 12.56
 */

namespace PED\ApiErrorBundle\Tests\ExceptionMapper;

use PED\ApiErrorBundle\ExceptionMapper\BaseErrorDetailsMapper;
use PED\ApiErrorBundle\ExceptionMapper\MappingStrategyInterface;
use PHPUnit\Framework\TestCase;

class BaseErrorDetailsMapperTest extends TestCase
{
    public function testMapping()
    {
        $mapper = new BaseErrorDetailsMapper([
            'A_BAD_ERROR' => [
                'title' => 'A bad error',
                'statusCode' => 404
            ]
        ]);

        self::assertEquals(404, $mapper->statusCode('A_BAD_ERROR'));
        self::assertEquals('A bad error', $mapper->title('A_BAD_ERROR'));
    }
}
