<?php

namespace Gibass\UseCaseMakerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('use_case_maker');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('parameters')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('root_namespace')->defaultValue('App')->end()
                        ->arrayNode('dir')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('domain')->defaultValue('%kernel.project_dir%/src/Domain')->end()
                                ->scalarNode('test')->defaultValue('%kernel.project_dir%/tests/Unit')->end()
                            ->end()
                        ->end()
                        ->arrayNode('namespace_prefix')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('domain')->defaultValue('App\Domain')->end()
                                ->scalarNode('test')->defaultValue('App\Tests\Unit')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
