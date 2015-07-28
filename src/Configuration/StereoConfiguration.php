<?php

/**
 * This file is part of the GuzzleStereo package.
 *
 * (c) Christophe Willemsen <willemsen.christophe@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ikwattro\GuzzleStereo\Configuration;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class StereoConfiguration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('guzzle_stereo');

        $rootNode
          ->children()
            ->scalarNode('cache_directory')->end()
            ->arrayNode('tapes')
                ->normalizeKeys(false)
                ->prototype('array')
                    ->children()
                        ->arrayNode('filters')
                        ->normalizeKeys(false)
                            ->prototype('scalar')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('core_filters')
                ->prototype('scalar')
                ->end()
            ->end()
            ->arrayNode('custom_filters')
                ->prototype('scalar')->end()
            ->end()
          ->end();

        return $treeBuilder;
    }
}