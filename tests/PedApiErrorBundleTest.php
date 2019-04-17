<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 13/03/19
 * Time: 12.31
 */

namespace PED\ApiErrorBundle\Tests;

use PED\ApiErrorBundle\PedApiErrorBundle;
use PHPUnit\Framework\TestCase;

class PedApiErrorBundleTest extends TestCase
{
    public function testCreation(): void
    {
        $bundle = new PedApiErrorBundle();

        self::assertNotNull($bundle);
    }
}
