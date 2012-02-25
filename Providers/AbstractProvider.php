<?php

namespace Benji07\SsoBundle\Providers;

/**
 * Abstract Provider
 *
 * @author Benjamin Lévêque <benjamin@leveque.me>
 */
abstract class AbstractProvider implements ProviderInterface
{

    protected $options = array();

    /**
     * __construct
     *
     * @param array $options options
     */
    public function __construct($options = array())
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * Get Option
     *
     * @param string $name the option name
     *
     * @throw \InvalidArgumentException if the option is not found
     *
     * @return mixed
     */
    public function getOption($name)
    {
        if (!array_key_exists($name, $this->options)) {
            throw new \InvalidArgumentException(sprintf('Unknown option "%s"', $name));
        }

        return $this->options[$name];
    }
}