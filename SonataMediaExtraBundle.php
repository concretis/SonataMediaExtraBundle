<?php
/**
 * @author     Blaise de Carné <blaise@concretis.com>
 */
namespace Concretis\SonataMediaExtraBundle;

use Concretis\SonataMediaExtraBundle\DependencyInjection\Compiler\ReplaceCDNServerServiceClass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SonataMediaExtraBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ReplaceCDNServerServiceClass());
    }
}
