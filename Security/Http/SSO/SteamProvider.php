<?php

namespace Benji07\SsoBundle\Security\Http\SSO;

/**
 * Steam Provider
 *
 * @author Benjamin Lévêque <benjamin@leveque.me>
 */
class SteamProvider extends OpenidProvider
{
    protected $options = array(
        'loginUrl' => 'http://steamcommunity.com/openid',
        'profileUrl' => 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/',
    );

    /**
     * Prepare the openid request
     */
    public function prepareRequest()
    {
    }

    /**
     * Retrieve user data or null if no user found
     *
     * @return array
     */
    public function getUserData()
    {
        $data = array();

        $identity = $this->openid->identity;

        if ($identity) {
            $steamId = str_replace('http://steamcommunity.com/openid/id/', '', $identity);

            $query = http_build_query(array(
                'key' => $this->getOption('apiKey'),
                'steamids' => $steamids
            ));

            $url = $this->getOption('profileUrl') . '?' . $query;

            $json = json_decode(file_get_contents($url));

            if (count($json->response->players)) {
                $data = (array) $json->response->players[0]->player;
            }
        }

        return $data;
    }
}