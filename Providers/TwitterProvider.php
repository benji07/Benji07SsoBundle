<?php

namespace Benji07\SsoBundle\Providers;

/**
 * Twitter Provider
 *
 * @author Benjamin Lévêque <benjamin@leveque.me>
 */
class TwitterProvider extends OAuth1aProvider
{
    protected $options = array(
        'requestTokenUrl' => 'https://api.twitter.com/oauth/request_token',
        'authorizeUrl'    => 'https://api.twitter.com/oauth/authenticate',
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

        if (isset($data['oauth_token'])) {

            $response = $this->get($this->getOption('profileUrl'), array(), array('oauth_token' => $data['oauth_token'], 'oauth_token_secret' => $data['oauth_token_secret']));

            return array_merge($data, (array) json_decode($response));
        }

        return $data;
    }
}
