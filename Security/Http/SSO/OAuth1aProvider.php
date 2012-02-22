<?php

namespace Benji07\SsoBundle\Security\Http\SSO;

use Symfony\Component\HttpFoundation\Request;

/**
 * OAuth 1.0a Provider
 *
 * @author Benjamin Lévêque <benjamin@leveque.me>
 */
class OAuth1aProvider extends AbstractProvider
{

    protected $response = array();

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
    }

    /**
     * Retrieve user data or null if no user found
     *
     * @return array
     */
    public function getUserData()
    {
        return $this->response;
    }
}