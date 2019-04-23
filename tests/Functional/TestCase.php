<?php
declare(strict_types=1);

namespace PED\ApiErrorBundle\Tests\Functional;

use PED\ApiErrorBundle\Tests\Functional\App\AppKernel;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Filesystem\Filesystem;

abstract class TestCase extends WebTestCase
{
    protected static function createKernel(array $options = [])
    {
        return new AppKernel(
            'test',
            true,
            isset($options['test_case']) ? $options['test_case'] : null
        );
    }

    protected function setUp(): void
    {
        $filesystem = new Filesystem();
        $filesystem->remove(sys_get_temp_dir() . '/PedApiErrorBundle/');
    }

    protected function tearDown(): void
    {
        static::$kernel = null;
    }
}
