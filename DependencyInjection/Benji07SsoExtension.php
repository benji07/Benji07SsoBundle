<?php

namespace Benji07\SsoBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Benji07 SSO Extension
 */
class Benji07SsoExtension extends Extension
{
    /**
     * Load this extension
     *
     * @param array            $configs   configs
     * @param ContainerBuilder $container container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('security.xml');
        $loader->load('providers.xml');

        $definition = $container->getDefinition('benji07_sso.provider.factory');

        foreach ($config['providers'] as $name => $provider) {
            $providerDefinition = $container->getDefinition($provider['service']);
            $providerDefinition->replaceArgument(0, $provider['options']);
            $definition->addMethodCall('add', array($name, new Reference($provider['service'])));
        }

        $definition->replaceArgument(0, new Reference($config['user_manager']));

        $definition = $container->getDefinition('benji07_sso.authentication.listener');

        $definition->addMethodCall('setProviderFactory', array(new Reference('benji07_sso.provider.factory')));
    }

    /**
     * Get Alias
     *
     * @return string
     */
    public function getAlias()
    {
        return 'benji07_sso';
    }
}
