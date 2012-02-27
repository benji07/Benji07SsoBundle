<?php

namespace Benji07\SsoBundle\Providers;

/**
 * OAuth 2 Provider
 *
 * @author Benjamin Lévêque <benjamin@leveque.me>
 */
class GithubProvider extends OAuth2Provider
{
    protected $options = array(
        'authorizeUrl'   => 'https://github.com/login/oauth/authorize',
        'accessTokenUrl' => 'https://github.com/login/oauth/access_token',
        'profileUrl'     => 'https://github.com/api/v2/json/user/show',
        'scope'          => ''
    );

    /**
     * Retrieve user data or null if no user found
     *
     * @return array
     */
    public function getUserData()
    {
        $response = parent::getUserData();

        $query = array(
            'access_token' => $response['access_token']
        );

        $url = $this->getOption('profileUrl') . '?' . http_build_query($query);

        $data = json_decode(file_get_contents($url));

        return array_merge($response, (array) $data->user);
    }
}