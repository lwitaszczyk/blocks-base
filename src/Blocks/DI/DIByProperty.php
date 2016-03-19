<?php

namespace Blocks\DI;

class DIByProperty
{

    /**
     * @var string
     */
    private $propertyName;

    /**
     * @var Argument
     */
    private $argument;

    /**
     * @param string $propertyName
     * @param Argument $argument
     */
    public function __construct($propertyName, Argument $argument)
    {
        $this->propertyName = (string)$propertyName;
        $this->argument = $argument;
    }

    /**
     * @return string
     */
    public function getPropertyName()
    {
        return $this->propertyName;
    }

    /**
     * @return Argument
     */
    public function getArgument()
    {
        return $this->argument;
    }
}
