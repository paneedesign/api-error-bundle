<?php
declare(strict_types=1);

namespace PED\ApiErrorBundle\Tests\Functional;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

final class AppKernel extends Kernel
{
    /** @var string */
    private $testCase;

    public function __construct($environment, $debug, string $testCase = null)
    {
        parent::__construct($environment, $debug);

        $this->testCase = $testCase;
    }

    public function registerBundles()
    {
        return [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \PED\ApiErrorBundle\PedApiErrorBundle()
        ];
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return sys_get_temp_dir().'/PedApiErrorBundle/cache';
    }

    public function getLogDir()
    {
        return sys_get_temp_dir().'/PedApiErrorBundle/logs';
    }

    /**
     * @param LoaderInterface $loader
     *
     * @throws \Exception
     */
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__ . '/config/base_config.yml');

        if ($this->testCase && file_exists($path = __DIR__ . '/config/' . $this->testCase . '/config.yml')) {
            $loader->load($path);
            return;
        }
    }
}
