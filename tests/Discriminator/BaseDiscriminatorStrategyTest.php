<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 13/03/19
 * Time: 13.18
 */

namespace PED\ApiErrorBundle\Tests\Discriminator;

use PED\ApiErrorBundle\Discrimination\BaseDiscriminationStrategy;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class BaseDiscriminatorStrategyTest extends TestCase
{
    public function testInApiContext()
    {
        $discriminator = new BaseDiscriminationStrategy('/api');

        $request = self::createConfiguredMock(Request::class, [
            'getPathInfo' => '/api/an-api-andpoint'
        ]);

        self::assertTrue($discriminator->inApiContext($request));
    }

    public function testNotInApiContext()
    {
        $discriminator = new BaseDiscriminationStrategy('/api');

        $request = self::createConfiguredMock(Request::class, [
            'getPathInfo' => '/user/not-an-api-andpoint'
        ]);

        self::assertFalse($discriminator->inApiContext($request));
    }
}
