<?php

namespace Benji07\SsoBundle\Security\Http\Firewal;

use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\Security\Core\Exception\AuthenticationException,
    Symfony\Component\Security\Core\User\UserInterface;

use Benji07\SsoBundle\Security\Core\Token\SsoToken;

use Benji07\SsoBundle\Security\Http\SSO\Factory;

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
    private $userManager;

    /**
     * @var Factory
     */
    private $providerFactory;

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
     * Set provider factory
     *
     * @param Factory $factory the provider factory
     */
    public function setProviderFactory(Factory $factory)
    {
        $this->providerFactory = $factory;
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
        $provider = $this->factory->get($name);

        $url = $this->httpUtils->createRequest($request, $this->options['check_path'])->getUri();

        $result = $provider->handleResponse($request, $url);

        if (false === $result) {
            // something went wrong
            throw new AuthenticationException('SSO Authentication failed.');
        }

        $userData = $provider->getUserData();

        $user = $this->userManager->findUser($name, $userData);

        if (null === $user) {
            $user = $this->userManager->createUser($name, $userData);

            if ($user instanceof Response || null === $user) {
                return $user;
            }
        }

        $token = new SsoToken($user);

        return $this->authenticationManager->authenticate($token);
    }
}