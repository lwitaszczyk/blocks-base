<?php

namespace Blocks;

abstract class Package
{

    /**
     * @var string
     */
    private $name;

    /**
     * @param string|null $name
     */
    public function __construct($name = null)
    {
        $this->name = is_null($name) ? static::class : $name;
    }
}
