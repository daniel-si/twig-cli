<?php
/**
 * This file is part of the twig-cli project.
 *
 * Copyright (c) 2018 Daniel Sigg (code[at]daniel-sigg[dot]de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DaSi\TwigCli\Configuration;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class TaskConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('task');

        $rootNode
            ->children()
                ->arrayNode('default')
                    ->isRequired()
                    ->children()
                        ->scalarNode('source')
                        ->end()
                        ->scalarNode('destination')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('tasks')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('template')
                            ->end()
                            ->scalarNode('source')
                            ->end()
                            ->scalarNode('destination')
                            ->end()
                            ->scalarNode('deploy')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
