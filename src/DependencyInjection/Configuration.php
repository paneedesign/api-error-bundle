<?php
declare(strict_types=1);

/**
 * User: Patrick Luca Fazzi
 * Date: 20/03/19
 * Time: 13.05
 */

namespace PED\ApiErrorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder($name = 'ped_api_error');

        if (\method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root($name);
        }


        $rootNode
            ->children()
                ->arrayNode('mapping')
                    ->children()
                        ->arrayNode('fqcn')
                            ->useAttributeAsKey('class')
                            ->arrayPrototype()
                                ->beforeNormalization()
                                ->ifString()->then(function ($v) {
                                    return [
                                        'type' => $v
                                    ];
                                })
                                ->end()
                                ->children()
                                    ->scalarNode('type')->isRequired()->cannotBeEmpty()->end()
                                    ->booleanNode('forwardMessage')->defaultValue(false)->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('errors')
                            ->useAttributeAsKey('name')
                            ->arrayPrototype()
                                ->children()
                                    ->scalarNode('title')->isRequired()->cannotBeEmpty()->end()
                                    ->scalarNode('statusCode')->defaultValue(500)->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end() // mapping
            ->end()
        ;

        return $treeBuilder;
    }
}
