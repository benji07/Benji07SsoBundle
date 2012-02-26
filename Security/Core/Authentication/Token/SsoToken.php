<?php

namespace Benji07\SsoBundle\Security\Core\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Sso Token
 */
class SsoToken extends AbstractToken
{
    /**
     * __construct
     *
     * @param UserInterface $user user
     */
    public function __construct(UserInterface $user)
    {
        parent::__construct($user->getRoles());

        $this->setUser($user);
    }

    /**
     * Get the user credentials
     *
     * @return string
     */
    public function getCredentials()
    {
        return $this->getUser()->getUsername();
    }

    /**
     * Check if the user is authenticated
     *
     * @return boolean
     */
    public function isAuthenticated()
    {
        return count($this->getRoles()) > 0;
    }
}