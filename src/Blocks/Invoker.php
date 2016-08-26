<?php

namespace Blocks;

use Blocks\DI\DIContainer;
use Blocks\Exception\CanNotResolverParameter;
use Blocks\Exception\CanNotResolverParameterBasedOnClass;

class Invoker
{
    /**
     * DIContainer
     */
    private $container;

    /**
     * MethodInvoker constructor.
     * @param DIContainer $container
     */
    public function __construct(DIContainer $container)
    {
        $this->container = $container;
    }

    /**
     * @param object $object
     * @param string $method
     * @param array $requestParameters
     * @return mixed
     * @throws \Exception
     */
    public function invokeMethod($object, $method, array $requestParameters = [])
    {
        $reflectionMethod = new \ReflectionMethod($object, $method);

        $parameters = [];
        foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
            $paramClass = $reflectionParameter->getClass();
            $paramName = $reflectionParameter->getName();

            if (isset($paramClass)) {
                $serviceId = $paramClass->getName();
                if ($this->container->has($serviceId)) {
                    $parameters[$paramName] = $this->container->get($serviceId);
                } else {
                    throw new CanNotResolverParameterBasedOnClass(
                        $method,
                        get_class($object),
                        $paramName,
                        $serviceId
                    );
                }
            } elseif (isset($requestParameters[$paramName])) {
                $parameters[$paramName] = $requestParameters[$paramName];
            } elseif ($reflectionParameter->isDefaultValueAvailable()) {
                $parameters[$paramName] = $reflectionParameter->getDefaultValue();
            } else {
                throw new CanNotResolverParameter(
                        $method,
                        get_class($object),
                        $paramName
                );
            }
        }
        return $reflectionMethod->invokeArgs($object, $parameters);
    }
}
