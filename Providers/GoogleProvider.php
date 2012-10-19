<?php

namespace Benji07\SsoBundle\Providers;

use Symfony\Component\HttpFoundation\Request;

/**
 * Google Provider
 *
 * @author Benjamin Lévêque <benjamin@leveque.me>
 */
class GoogleProvider extends OAuth2Provider
{
    protected $options = array(
        'authorizeUrl'   => 'https://accounts.google.com/o/oauth2/auth',
        'accessTokenUrl' => 'https://accounts.google.com/o/oauth2/token',
        'profileUrl'     => 'https://www.googleapis.com/oauth2/v1/userinfo',
        'scope'          => ''
    );

    protected $browser;

    /**
    * Constructeur
    */
    public function __construct(array $options = array(), $browser)
    {
        parent::__construct($options);

        $this->browser = $browser;

        if ($this->browser) {
            $this->browser->getClient()->setVerifyPeer(false);
        }
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
            'code' => $code,
            'grant_type' => 'authorization_code'
        );

        $response = $this->browser->post($url , array(), $parameters);
        $data = json_decode($response->getContent(), true);

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
        $data = parent::getUserData();

        if (isset($data['access_token'])) {
            $parameters = array(
                'access_token' => $data['access_token']
            );

            $url = $this->getOption('profileUrl') . '?' . http_build_query($parameters);

            $response = json_decode(file_get_contents($url));

            return array_merge($data, (array) $response);
        }

        return $data;
    }
}
