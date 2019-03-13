<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 13/03/19
 * Time: 13.18
 */

namespace PaneeDesign\ApiErrorBundle\Tests\Discriminator;

use PaneeDesign\ApiErrorBundle\Discriminator\DefaultDiscriminatorStrategy;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class DefaultDiscriminatorStrategyTest extends TestCase
{
    public function testInApiContext()
    {
        $discriminator = new DefaultDiscriminatorStrategy();

        $request = self::createConfiguredMock(Request::class, [
            'getPathInfo' => '/api/an-api-andpoint'
        ]);

        self::assertTrue($discriminator->inApiContext($request));
    }

    public function testNotInApiContext()
    {
        $discriminator = new DefaultDiscriminatorStrategy();

        $request = self::createConfiguredMock(Request::class, [
            'getPathInfo' => '/user/not-an-api-andpoint'
        ]);

        self::assertFalse($discriminator->inApiContext($request));
    }
}
