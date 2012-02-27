<?php

namespace Benji07\SsoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * SSO Auth Controller
 */
class AuthController extends Controller
{
    /**
     * Login with SSO
     *
     * @param string $name the provider name
     *
     * @return RedirectResponse
     */
    public function loginAction($name)
    {
        $provider = $this->get('benji07_sso.provider.factory')->get($name);

        $this->getRequest()->getSession()->set('sso_provider', $name);

        $redirectUrl = $this->generateUrl('_sso_login_check', array(), true);

        $url = $provider->handleRequest($this->getRequest(), $redirectUrl);

        return $this->redirect($url);
    }

    /**
     * Login check
     */
    public function loginCheckAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall.');
    }
}