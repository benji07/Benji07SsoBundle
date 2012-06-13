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

    /**
     * Link a user
     *
     * @param string $name the provider name
     *
     * @return RedirectResponse
     */
    public function linkAction($name)
    {
        $referer = $this->getRequest()->headers->get('Referer');

        $this->getRequest()->getSession()->set('oauth_referer', $referer);

        $provider = $this->get('benji07_sso.provider.factory')->get($name);

        $redirectUrl = $this->generateUrl('_sso_link_callback', array('name' => $name), true);

        $url = $provider->handleRequest($this->getRequest(), $redirectUrl);

        return $this->redirect($url);
    }

    /**
     * Link response
     *
     * @param string $name the provider name
     *
     * @return RedirectResponse
     */
    public function linkCallbackAction($name)
    {
        $provider = $this->get('benji07_sso.provider.factory')->get($name);

        $manager = $this->get('benji07_sso.provider.factory')->getUserManager();

        $redirectUrl = $this->generateUrl('_sso_link_callback', array('name' => $name), true);

        if ($provider->handleResponse($this->getRequest(), $redirectUrl)) {
            if ($manager->link($this->getUser(), $name, $provider->getUserData())) {
                // @todo l'utilisateur est bien lié
            } else {
                // @todo erreur l'utilisateur est déjà lié
            }
        } else {
            // @todo l'utilisateur a refusé / ou erreur
        }

        $referer = $this->getRequest()->getSession()->get('oauth_referer', '/');

        return $this->redirect($referer);
    }

    /**
     * Unlink a user
     *
     * @param string $name
     *
     * @return [type]       [description]
     */
    public function unlinkAction($name)
    {
        $manager = $this->get('benji07_sso.provider.factory')->getUserManager();

        if ($manager->unlink($this->getUser(), $name)) {
            // @todo set flash success
        } else {
            // @todo set flash error
        }

        $referer = $this->getRequest()->headers->get('Referer', '/');

        return $this->redirect($referer);
    }
}
