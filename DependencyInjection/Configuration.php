<?php

namespace Concretis\SonataMediaExtraBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('sonata_media_extra');

        $node
            ->children()
                ->arrayNode('providers')
                    ->addDefaultsIfNotSet()
                    ->children()

                        ->arrayNode('pdf')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('service')->defaultValue('veilhan.media.provider.pdf')->end()
                                ->scalarNode('resizer')->defaultValue('sonata.media.resizer.simple')->end()
                                ->scalarNode('filesystem')->defaultValue('sonata.media.filesystem.local')->end()
                                ->scalarNode('cdn')->defaultValue('sonata.media.cdn.server')->end()
                                ->scalarNode('generator')->defaultValue('sonata.media.generator.default')->end()
                                ->scalarNode('thumbnail')->defaultValue('sonata.media.thumbnail.format')->end()
                                ->scalarNode('adapter')->defaultValue('sonata.media.adapter.image.gd')->end()
                                ->arrayNode('allowed_extensions')
                                    ->prototype('scalar')->end()
                                    ->defaultValue(array('pdf'))
                                ->end()
                                ->arrayNode('allowed_mime_types')
                                    ->prototype('scalar')->end()
                                    ->defaultValue(array(
                                        'application/pdf'
                                    ))
                                ->end()
                            ->end()
                        ->end()

                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
