<?php

namespace Benji07\SsoBundle\Security\Core\Token;

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
}