<?php

namespace Benji07\SsoBundle\Providers;

use Symfony\Component\HttpFoundation\Request;

/**
 * OpenId Provider
 *
 * @author Benjamin Lévêque <benjamin@leveque.me>
 */
abstract class OpenidProvider extends AbstractProvider
{
    protected $openid;

    /**
     * Prepare the openid request
     */
    abstract protected function prepareRequest();

    /**
     * Handle Request
     *
     * @param Request $request     the current request
     * @param string  $redirectUrl the url to redirect to
     *
     * @return string the url to redirect to
     */
    public function handleRequest(Request $request, $redirectUrl)
    {
        $this->openid = new \LightOpenID($request->getHost());
        $this->openid->identity = $this->getOption('loginUrl');
        $this->openid->returnUrl = $redirectUrl;

        $this->prepareRequest();

        return $this->openid->authUrl();
    }

    /**
     * Handle Response
     *
     * @param Request $request     the current request
     * @param string  $redirectUrl the current url
     *
     * @return boolean the response is correctly handle
     */
    public function handleResponse(Request $request, $redirectUrl)
    {
        $this->openid = new \LightOpenID($request->getHost());

        if ($this->openid->mode == 'cancel') {
            // the user cancel the authentication
            return false;
        }

        // echec de la connexion
        if (false === $this->openid->validate()) {
            return false;
        }

        return true;
    }
}
