<?php

namespace Concretis\SonataMediaExtraBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SonataExtraMediaExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $this->configurePdfProvider($container, $config);
    }

    /**
     * @param \Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @param array                                                   $config
     */
    public function configurePdfProvider(ContainerBuilder $container, $config)
    {
        $definition = $container->getDefinition('veilhan.media.provider.pdf');
        $config = $config['providers']['pdf'];

        $definition
          ->replaceArgument(1, new Reference($config['filesystem']))
          ->replaceArgument(2, new Reference($config['cdn']))
          ->replaceArgument(3, new Reference($config['generator']))
          ->replaceArgument(4, new Reference($config['thumbnail']))
          ->replaceArgument(5, array_map('strtolower', $config['allowed_extensions']))
          ->replaceArgument(6, $config['allowed_mime_types'])
          ->replaceArgument(7, new Reference($config['adapter']))
        ;

        if ($config['resizer']) {
            $definition->addMethodCall('setResizer', array(new Reference($config['resizer'])));
        }
    }
}
