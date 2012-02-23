<?php

namespace Benji07\SsoBundle\DependencyInjection\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory;

class SsoFactory extends AbstractFactory
{
    /**
     * Return the listener id
     *
     * @return string
     */
    abstract protected function getListenerId()
    {
        return 'benji07.sso.listener'
    }

    public function getPosition()
    {
        return 'http';
    }

    public function getKey()
    {
        return 'sso';
    }
}