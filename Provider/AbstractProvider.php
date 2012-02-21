<?php

abstract class AbstractProvider implements ProviderInterface
{

    protected $options;

    public function __construct($options = array())
    {
        $this->options = array_merge($this->options, $options);
    }

    public function getOption($name)
    {
        if (!array_key_exists($name, $this->options)) {
            throw new \InvalidArgumentException(sprintf('Unknown option "%s"', $name));
        }

        return $this->options[$name];
    }
}