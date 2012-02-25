<?php

namespace Benji07\SsoBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle,
    Symfony\Component\DependencyInjection\ContainerBuilder;

use Benji07\SsoBundle\DependencyInjection\Security\Factory\SsoFactory;

/**
 * Benji07 SsoBundle
 */
class Benji07SsoBundle extends Bundle
{

    /**
     * Build
     *
     * @param ContainerBuilder $container container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new SsoFactory);
    }
}