<?php

namespace Benji07\SsoBundle\Security\Http\Firewall;

use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\Security\Core\Exception\AuthenticationException,
    Symfony\Component\Security\Core\User\UserInterface;

use Benji07\SsoBundle\Security\Core\User\UserManagerInterface,
    Benji07\SsoBundle\Security\Core\Authentication\Token\SsoToken,
    Benji07\SsoBundle\Providers\Factory;

/**
 * SSO Listener
 *
 * @author Benjamin Lévêque <benjamin@leveque.me>
 */
class SsoListener extends AbstractAuthenticationListener
{
    /**
     * @var Factory
     */
    private $providerFactory;

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
        $name = $request->getSession()->get('sso_provider');

        if (null === $name) {
            throw new AuthenticationException('sso.login.unknown.fail');
        }

        $provider = $this->providerFactory->get($name);

        $url = $this->httpUtils->createRequest($request, $this->options['check_path'])->getUri();

        $result = $provider->handleResponse($request, $url);

        if (false === $result) {
            // something went wrong
            throw new AuthenticationException('sso.login.'.$name.'.fail');
        }

        $userData = $provider->getUserData();

        $request->getSession()->set('sso_user', $userData);

        $user = $this->providerFactory->getUserManager()->findUser($name, $userData);

        if (null === $user) {
            $user = $this->providerFactory->getUserManager()->createUser($name, $userData);

            if ($user instanceof Response || null === $user) {
                return $user;
            }
        }

        $token = new SsoToken($user);

        return $this->authenticationManager->authenticate($token);
    }
}
