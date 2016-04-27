<?php

namespace Blocks;

trait AttributesTrait
{

    /**
     * @var mixed[]
     */
    private $attributes = [];

    /**
     * @param string $name
     * @param mixed $value
     * @return $this
     */
    public function setAttribute($name, $value)
    {
        $name = (string)$name;
        $this->attributes[$name] = $value;
        return $this;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes = []) {
        foreach ($attributes as $attributeName => $attributeValue) {
            $this->setAttribute($attributeName, $attributeValue);
        }
    }

    /**
     * @param string $name
     * @param mixed $default
     * @return mixed|null
     */
    public function getAttribute($name, $default = null)
    {
        $name = (string)$name;
        return isset($this->attributes[$name]) ? $this->attributes[$name] : $default;
    }
}
