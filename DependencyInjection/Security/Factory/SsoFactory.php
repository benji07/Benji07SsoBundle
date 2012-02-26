<?php

namespace Benji07\SsoBundle\DependencyInjection\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory,
    Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\DefinitionDecorator;

/**
 * Sso Factory
 *
 * @author Benjamin Lévêque <benjamin@leveque.me>
 */
class SsoFactory extends AbstractFactory
{
    /**
     * Create the auth provider
     *
     * @param ContainerBuilder $container      container
     * @param string           $id             The unique id of the firewall
     * @param array            $config         The options array for this listener
     * @param string           $userProviderId The id of the user provider
     *
     * @return string never null, the id of the authentication provider
     */
    protected function createAuthProvider(ContainerBuilder $container, $id, $config, $userProviderId)
    {
        return 'benji07_sso.authentication.provider';
    }

    /**
     * Create an entry point
     *
     * @param ContainerBuilder $container           container
     * @param string           $id                  id
     * @param array            $config              config
     * @param string           $defaultEntryPointId defaultEntryPointId
     *
     * @return string the entry point id
     */
    protected function createEntryPoint($container, $id, $config, $defaultEntryPointId)
    {
        $entryPointId = 'benji07_sso.authentication.entry_point.concrete';

        $container
            ->setDefinition($entryPointId, new DefinitionDecorator('benji07_sso.authentication.entry_point'))
            ->replaceArgument(2, $config['check_path'])
            ->replaceArgument(3, $config['login_path']);

        return $entryPointId;
    }

    /**
     * Get Listener id
     *
     * @return string
     */
    protected function getListenerId()
    {
        return 'benji07_sso.authentication.listener';
    }

    /**
     * Get Position
     *
     * @return string
     */
    public function getPosition()
    {
        return 'http';
    }

    /**
     * Get Key
     *
     * @return string
     */
    public function getKey()
    {
        return 'sso';
    }
}