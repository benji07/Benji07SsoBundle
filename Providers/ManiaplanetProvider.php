<?php

namespace Users\Sites\Sso\Providers;

use Benji07\SsoBundle\Providers\OAuth2Provider;

use Guzzle\Http\Client;
use Guzzle\Http\Exception\CurlException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Maniaplanet Provider
 */
class ManiaplanetProvider extends OAuth2Provider
{
    protected $options = array(
        'authorizeUrl'   => 'https://ws.maniaplanet.com/oauth2/authorize/',
        'accessTokenUrl' => '/oauth2/token/',
        'profileUrl'     => 'https://ws.maniaplanet.com',
        'scope'          => 'basic email teams titles'
    );

    /**
     * Retrieve user data or null if no user found
     *
     * @return array
     */
    public function getUserData()
    {
        $data = parent::getUserData();

        $parameters = array(
            'access_token' => $data['access_token']
        );

        $this->client  = new Client("https://ws.maniaplanet.com", array(
            'curl.options' => array(
                CURLOPT_USERAGENT      => 'maniaplanet-ws-sdk/3.5',
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => 0,
            )
        ));

        $request = $this->client->get('/player/email/');
        $request->setHeader('Authorization', 'Bearer '.$data['access_token']);
        $request->setHeader('Accept', 'application/json');
        $request->setHeader('Content-type', 'application/json');

        $response = $request->send()->json();

        $parameters['email'] = $response;

        $request = $this->client->get('/player/');
        $request->setHeader('Authorization', 'Bearer '.$data['access_token']);
        $request->setHeader('Accept', 'application/json');
        $request->setHeader('Content-type', 'application/json');
        $response = $request->send()->json();

        $parameters['username']            = $response['login'];
        $parameters['maniaplanet_user_id'] = $response['id'];

        return $parameters;
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
            'client_id'     => $this->getOption('clientId'),
            'redirect_uri'  => $redirectUrl,
            'client_secret' => $this->getOption('secretId'),
            'code'          => $code,
            'grant_type'    => 'authorization_code',
        );

        $this->client  = new Client("https://ws.maniaplanet.com");

        $request = $this->client->post($url, null, $parameters);
        $data    = $request->send();

        $this->response = $data->json();

        if (!isset($this->response['access_token'])) {
            return false;
        }

        return true;
    }
}
