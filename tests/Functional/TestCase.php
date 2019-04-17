<?php
declare(strict_types=1);

namespace PED\ApiErrorBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Filesystem\Filesystem;

abstract class TestCase extends WebTestCase
{
    protected static function createKernel(array $options = [])
    {
        require_once __DIR__.'/app/AppKernel.php';

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
