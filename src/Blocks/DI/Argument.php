<?php

namespace Blocks\DI;

abstract class Argument
{

    /**
     * @var string
     */
    private $argumentName;

    /**
     * @param string $argumentName
     */
    public function __construct($argumentName)
    {
        $this->argumentName = (string)$argumentName;
    }

    /**
     * @return string
     */
    public function getArgumentName()
    {
        return $this->argumentName;
    }

    /**
     * @param DIContainer $container
     * @return mixed
     */
    abstract public function get(DIContainer $container);
}
