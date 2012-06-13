<?php

namespace Benji07\SsoBundle\Providers;

/**
 * Twitter Provider
 *
 * @author Benjamin Lévêque <benjamin@leveque.me>
 */
class TwitterProvider extends OAuth1Provider
{
    protected $options = array(
        'requestTokenUrl' => 'https://api.twitter.com/oauth/request_token',
        'authorizeUrl'    => 'https://api.twitter.com/oauth/authorize',
        'accessTokenUrl'  => 'https://api.twitter.com/oauth/access_token',
        'profileUrl'      => 'http://api.twitter.com/1/account/verify_credentials.json',
    );

    /**
     * Retrieve user data or null if no user found
     *
     * @return array
     */
    public function getUserData()
    {
        $data = parent::getUserData();

        if (isset($data['access_token'])) {

            return array_merge($data, (array) $response);
        }

        return $data;
    }
}
