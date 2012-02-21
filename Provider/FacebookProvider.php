<?php

class FacebookProvider extends OAuth2Provider
{
    protected $options = array(
        'authorizeUrl' => 'https://www.facebook.com/dialog/oauth',
        'accessTokenUrl' => 'https://graph.facebook.com/oauth/access_token',
        'profileUrl' => 'https://graph.facebook.com/me'
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