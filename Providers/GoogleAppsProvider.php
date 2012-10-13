<?php

namespace Benji07\SsoBundle\Providers;

/**
 * Google Apps Provider
 *
 * @author Benjamin Lévêque <benjamin@leveque.me>
 */
class GoogleAppsProvider extends OpenidProvider
{
    protected $options = array(
        'loginUrl' => 'https://www.google.com/accounts/o8/site-xrds',
        'domain'   => '',
    );

    /**
     * Prepare the openid request
     */
    public function prepareRequest()
    {
        $this->openid->identity = $this->getOption('loginUrl') . '?hd=' . $this->options['domain'];

        $this->openid->required = array(
            "namePerson/first",
            "namePerson/last",
            "contact/email"
        );
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
            return array_merge(array('identity' => $identity), $this->openid->getAttributes());
        }

        return $data;
    }
}
