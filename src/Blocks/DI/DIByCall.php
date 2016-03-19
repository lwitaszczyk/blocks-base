<?php

namespace Blocks\DI;

class DIByCall
{

    /**
     * @var string
     */
    private $methodName;

    /**
     * @var Argument[]
     */
    private $arguments;

    /**
     * @param string $methodName
     */
    public function __construct($methodName)
    {
        $this->methodName = (string)$methodName;
        $this->arguments = [];
    }

    /**
     * @return string
     */
    public function getMethodName()
    {
        return $this->methodName;
    }

    /**
     * @param Argument[] $arguments
     * @return $this
     */
    public function addArguments(array $arguments = [])
    {
        foreach ($arguments as $argument) {
            $this->addArgument($argument);
        }
        return $this;
    }

    /**
     * @param Argument $argument
     * @return $this
     */
    public function addArgument(Argument $argument)
    {
        $this->arguments[] = $argument;
        return $this;
    }

    /**
     * @return Argument[]
     */
    public function getArguments()
    {
        return $this->arguments;
    }
}
