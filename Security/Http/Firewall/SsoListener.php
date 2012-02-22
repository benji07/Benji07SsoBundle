<?php

namespace Benji07\SsoBundle\Security\Http\Firewal;

use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Security\Core\Exception\AuthenticationException,
    Symfony\Component\Security\Core\User\UserInterface;

use Benji07\SsoBundle\Security\Core\Token\SsoToken;

/**
 * SSO Listener
 *
 * @author Benjamin Lévêque <benjamin@leveque.me>
 */
class SsoListener extends AbstractAuthenticationListener
{

    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * Set user manager
     *
     * @param UserManagerInterface $userManager the user manager
     */
    public function setUserManager(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * Performs authentication.
     *
     * @param Request $request A Request instance
     *
     * @throws AuthenticationException if the authentication fails
     *
     * @return TokenInterface|Response|null The authenticated token, or null if full authentication is not possible
     */
    protected function attemptAuthentication(Request $request)
    {
        $result = $provider->handleResponse($request);

        $providerName = $provider->getName();

        if (false === $result) {
            // something went wrong
            throw new AuthenticationException('SSO Authentication failed.');
        }

        $userData = $provider->getUserData();

        $user = $this->userManager->findUser($providerName, $userData);

        if (null === $user) {
            $user = $this->userManager->createUser($providerName, $userData);

            if ($user instanceof Response || null === $user) {
                return $user;
            }
        }

        $token = new SsoToken($user);

        return $this->authenticationManager->authenticate($token);
    }
}