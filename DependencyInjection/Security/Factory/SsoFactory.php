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