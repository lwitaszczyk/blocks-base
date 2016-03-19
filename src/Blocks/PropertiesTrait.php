<?php

namespace Blocks;

trait PropertiesTrait
{

    /**
     * @var mixed[]
     */
    private $properties = [];

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function setProperty($name, $value)
    {
        $name = (string)$name;

        $this->properties[$name] = $value;
        return $this;
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed|null
     */
    public function getProperty($name, $default = null)
    {
        $name = (string)$name;

        return isset($this->properties[$name]) ? $this->properties[$name] : $default;
    }
}
