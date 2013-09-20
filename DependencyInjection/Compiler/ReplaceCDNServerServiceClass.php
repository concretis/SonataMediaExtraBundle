<?php
/**
 * Auteur: Blaise de Carné - blaise@concretis.com
 */


namespace Concretis\SonataMediaExtraBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ReplaceCDNServerServiceClass implements CompilerPassInterface {
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('sonata.media.cdn.server')) {
            return;
        }
        $definition = $container->getDefinition('sonata.media.cdn.server');
        $definition->setClass('Concretis\\SonataMediaExtraBundle\CDN\Server');
    }
}
