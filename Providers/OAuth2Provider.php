<?php

namespace Benji07\SsoBundle\Providers;

use Symfony\Component\HttpFoundation\Request;

/**
 * OAuth 2 Provider
 *
 * @author Benjamin Lévêque <benjamin@leveque.me>
 */
class OAuth2Provider extends AbstractProvider
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
        $url = $this->getOption('authorizeUrl');

        $parameters = array(
            'response_type' => 'code',
            'client_id'     => $this->getOption('clientId'),
            'scope'         => $this->getOption('scope'),
            'redirect_uri'  => $redirectUrl
        );

        return $url . '?' . http_build_query($parameters);
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
        $url = $this->getOption('accessTokenUrl');

        $code = $request->query->get('code');

        if (null == $code) {
            $this->response = $request->query->all();

            return false;
        }

        $parameters = array(
            'client_id' => $this->getOption('clientId'),
            'redirect_uri' => $redirectUrl,
            'client_secret' => $this->getOption('secretId'),
            'code' => $code
        );

        $response = file_get_contents($url . '?' .  http_build_query($parameters));

        parse_str($response, $data);

        $this->response = $data;

        if (isset($data['error'])) {
            return false;
        }

        return true;
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