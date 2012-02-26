<?php

namespace Benji07\SsoBundle\Security\Core\Authentication\Provider;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface,
    Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

use Benji07\SsoBundle\Security\Core\Authentication\Token\SsoToken;

/**
 * Sso Provider
 *
 * @author Benjamin Lévêque <benjamin@leveque.me>
 */
class SsoProvider implements AuthenticationProviderInterface
{
    /**
     * Supports
     *
     * @param TokenInterface $token a token
     *
     * @return boolean
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof SsoToken;
    }

    /**
     * Authenticate the user
     *
     * @param TokenInterface $token token
     *
     * @return TokenInterface
     */
    public function authenticate(TokenInterface $token)
    {
        return $token;
    }
}