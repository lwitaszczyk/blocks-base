<?php

namespace Blocks\DI;

use Blocks\DI\Exception\CallInjectionAlreadyDefinedException;
use Blocks\DI\Exception\CircularReferenceDetectedException;
use Blocks\DI\Exception\ClassNoMethodException;
use Blocks\DI\Exception\ClassNoPropertyException;
use Blocks\DI\Exception\PropertyInjectionAlreadyDefinedException;

abstract class Reference extends Service
{

    /**
     * @var bool
     */
    private $circularDetectSemaphore;

    /**
     * @var string
     */
    private $className;

    /**
     * @var Argument[]
     */
    private $arguments;

    /**
     * @var DIByCall[]
     */
    private $calls;

    /**
     * @var DIByProperty[]
     */
    private $properties;

    /**
     * @param string $id
     * @param $className
     */
    public function __construct($id, $className)
    {
        parent::__construct($id);
        $this->className = $className;
        $this->circularDetectSemaphore = false;
        $this->arguments = [];
        $this->calls = [];
        $this->properties = [];
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
     * @param DIByCall[] $calls
     * @return $this
     */
    public function addCalls(array $calls = [])
    {
        foreach ($calls as $call) {
            $this->addCall($call);
        }
        return $this;
    }

    /**
     * @param DIByCall $call
     * @return $this
     * @throws CallInjectionAlreadyDefinedException
     */
    public function addCall(DIByCall $call)
    {
        $methodName = $call->getMethodName();
        if (isset($this->calls[$methodName])) {
            throw new CallInjectionAlreadyDefinedException($methodName, $this);
        }

        $this->calls[$methodName] = $call;
        return $this;
    }

    /**
     * @param DIByProperty[] $properties
     * @return $this
     */
    public function addProperties(array $properties = [])
    {
        foreach ($properties as $call) {
            $this->addProperty($call);
        }
        return $this;
    }

    /**
     * @param DIByProperty $property
     * @return $this
     * @throws PropertyInjectionAlreadyDefinedException
     */
    public function addProperty(DIByProperty $property)
    {
        $propertyName = $property->getPropertyName();
        if (isset($this->properties[$propertyName])) {
            throw new PropertyInjectionAlreadyDefinedException($property, $this);
        }

        $this->properties[$propertyName] = $property;
        return $this;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param DIContainer $container
     * @return mixed[]
     */
    protected function buildArguments(DIContainer $container)
    {
        $arguments = [];
        foreach ($this->arguments as $argument) {
            $arguments[] = $argument->get($container);
        }
        return $arguments;
    }

    /**
     * @param DIContainer $container
     * @param \ReflectionClass $reflection
     * @param object $instance
     * @throws ClassNoPropertyException
     */
    protected function injectProperties(DIContainer $container, \ReflectionClass $reflection, $instance)
    {
        foreach ($this->properties as $property) {
            $propertyName = $property->getPropertyName();
            if ($reflection->hasProperty($propertyName)) {
                $instance->{$propertyName} = $property->getArgument()->get($container);
            } else {
                throw new ClassNoPropertyException($property, $this);
            }
        }
    }

    /**
     * @param DIContainer $container
     * @param \ReflectionClass $reflection
     * @param object $instance
     * @throws ClassNoMethodException
     */
    protected function injectCalls(DIContainer $container, \ReflectionClass $reflection, $instance)
    {
        foreach ($this->calls as $call) {
            $methodName = $call->getMethodName();
            if ($reflection->hasMethod($methodName)) {
                $arguments = [];
                foreach ($call->getArguments() as $argument) {
                    $arguments[] = $argument->get($container);
                }
                call_user_func_array([$instance, $methodName], $arguments);
            } else {
                throw new ClassNoMethodException($call, $reflection, $this);
            }
        }
    }

    /**
     * @param DIContainer $container
     * @return object
     * @throws CircularReferenceDetectedException
     */
    protected function createInstance(DIContainer $container)
    {
        if ($this->circularDetectSemaphore) {
            throw new CircularReferenceDetectedException($this);
        }

        $this->circularDetectSemaphore = true;
        $instance = $this->factoryInstance($container);
        $this->circularDetectSemaphore = false;

        return $instance;
    }

    /**
     * @param DIContainer $container
     * @return object
     */
    /**
     * @param DIContainer $container
     * @return mixed
     */
    protected function factoryInstance(DIContainer $container)
    {
        $reflection = new \ReflectionClass($this->getClassName());
        $instance = $reflection->newInstanceArgs(
            $this->buildArguments($container)
        );
        $this->injectCalls($container, $reflection, $instance);
        $this->injectProperties($container, $reflection, $instance);
        return $instance;
    }
}
