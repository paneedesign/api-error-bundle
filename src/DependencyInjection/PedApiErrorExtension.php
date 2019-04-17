<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 13/03/19
 * Time: 12.42
 */

namespace PED\ApiErrorBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

final class PedApiErrorExtension extends ConfigurableExtension
{
    /**
     * @param array $mergedConfig
     * @param ContainerBuilder $container
     *
     * @throws \Exception
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config/'));
        $loader->load('services.yml');

        $definition = $container->getDefinition('ped_api_error.exception_mapper.mapping_strategy');
        $definition->setArgument(0, $mergedConfig['mapping']['fqcn']);

        $definition = $container->getDefinition('ped_api_error.exception_mapper.error_details_mapper');
        $definition->setArgument(0, $mergedConfig['mapping']['errors']);
    }
}
