<?php

namespace Benji07\SsoBundle\Security\Http\SSO;

/**
 * SSO Provider factory
 */
class Factory
{
    private $providers = array();

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
        if (!array_key_exists($this->providers, $name)) {
            throw new \InvalidArgumentException(sprintf('Unknown provider "%s"', $name));
        }

        return $this->providers[$name];
    }
}