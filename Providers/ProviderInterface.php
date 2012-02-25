<?php

namespace Benji07\SsoBundle\Providers;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface for SSO Provider
 *
 * @author Benjamin Lévêque <benjamin@leveque.me>
 */
interface ProviderInterface
{
    /**
     * Handle Request
     *
     * @param Request $request     the current request
     * @param string  $redirectUrl the url to redirect to
     *
     * @return string the url to redirect to
     */
    function handleRequest(Request $request, $redirectUrl);

    /**
     * Handle Response
     *
     * @param Request $request     the current request
     * @param string  $redirectUrl the current url
     *
     * @return boolean the response is correctly handle
     */
    function handleResponse(Request $request, $redirectUrl);

    /**
     * Retrieve user data or null if no user found
     *
     * @return array
     */
    function getUserData();
}