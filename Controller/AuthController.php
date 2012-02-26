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
     * @return RedirectResponse
     */
    public function loginAction($name)
    {
        $provider = $this->get('benji07_sso.provider.factory')->get($name)

        $this->getRequest()->getSession()->set('sso_provider', $name);

        $redirectUrl = $this->generateUrl('_sso_check_path', array(), true);

        $url = $provider->handleRequest($this->getRequest(), $redirectUrl);

        return $this->redirect($url);
    }

    /**
     * Login check
     */
    public function loginCheckAction()
    {

    }
}