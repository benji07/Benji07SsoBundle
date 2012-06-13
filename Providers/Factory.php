<?php

namespace Benji07\SsoBundle\Providers;

/**
 * SSO Provider factory
 */
class Factory
{
    private $providers = array();

    private $userManager;

    /**
     * __construct
     *
     * @param UserManagerInterface $userManager
     */
    public function __construct($userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * Get Usermanager
     *
     * @return UserManagerInterface
     */
    public function getUserManager()
    {
        return $this->userManager;
    }

    /**
     * Add a provider
     *
     * @param string            $name     the provider name
     * @param ProviderInterface $provider a provider
     */
    public function add($name, ProviderInterface $provider)
    {
        $this->providers[$name] = $provider;
    }

    /**
     * Get a provider
     *
     * @param string $name the provider name
     *
     * @throw \InvalidArgumentException if the provider does not exist
     *
     * @return ProviderInterface
     */
    public function get($name)
    {
        if (!array_key_exists($name, $this->providers)) {
            throw new \InvalidArgumentException(sprintf('Unknown provider "%s"', $name));
        }

        return $this->providers[$name];
    }
}
