<?php

namespace Benji07\SsoBundle\Providers;

use Symfony\Component\HttpFoundation\Request;

/**
 * OAuth 1.0a Provider
 *
 * @author Benjamin Lévêque <benjamin@leveque.me>
 */
class OAuth1aProvider extends AbstractProvider
{

    protected $response = array();

    protected $browser;

    public function __construct(array $options = array(), $browser)
    {
        parent::__construct($options);

        $this->browser = $browser;
    }

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
        $token = $this->getRequestToken($redirectUrl);

        $request->getSession()->set('oauth.' . get_class($this), $token);

        $url = $this->getOption('authorizeUrl');

        return $url . '?' . http_build_query(array(
            'oauth_token' => $token['oauth_token']
        ));
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
        if ($request->query->has('oauth_problem')) {
            $this->response = $request->query->all();

            return false;
        }

        $token = $request->getSession()->get('oauth.'.$this->getName().'.token', array());
        $verifier = $request->query->get('oauth_verifier');

        $result = $this->post($this->getOption('accessTokenUrl'), array('oauth_verifier' => $verifier), $token);

        parse_str($result, $data);

        $this->response = $data;

        return true;
    }

    protected function getRequestToken($redirectUrl)
    {
        $result = $this->post($this->getOption('requestTokenUrl'), array('oauth_callback' => $redirectUrl));

        parse_str($result, $data);

        return $data;
    }

    /**
     * Get data from OAuth provider
     *
     * @param string $url    url
     * @param array  $params the query string
     * @param array  $token  the usr token
     *
     * @return string
     */
    public function get($url, array $params = array(), $token = null)
    {
        $request = $this->prepareRequest($url, 'GET', $params, $token);

        $response = $this->browser->get($request->getUrl());

        return $response->getContent();
    }

    /**
     * Post data to OAuth provider
     *
     * @param string $url    url
     * @param array  $params the query string
     * @param array  $token  the usr token
     *
     * @return string
     */
    public function post($url, array $params = array(), $token = null)
    {
        $request = $this->prepareRequest($url, 'POST', $params, $token);

        $response = $this->browser->post($request->getNormalizedHttpUrl(), array(), $request->toPostdata());

        return $response->getContent();
    }

    /**
     * Prepare request
     *
     * @param string $url    url
     * @param string $method method
     * @param array  $params params
     * @param array  $token  token
     *
     * @return OAuthRequest
     */
    protected function prepareRequest($url, $method, array $params = array(), $token = null)
    {
        $consumer = new \OAuthConsumer($this->getOption('clientId'), $this->getOption('secretId'));

        if ($token) {
            $token = new \OAuthToken($token['oauth_token'], $token['oauth_token_secret']);
        }

        $request = \OAuthRequest::fromConsumerAndToken($consumer, $token, $method, $url, $params);

        $request->signRequest(new \OAuthSignatureMethod_HMAC_SHA1(), $consumer, $token);

        return $request;
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
