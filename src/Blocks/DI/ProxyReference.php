<?php

namespace Blocks\DI;

use ProxyManager\Proxy\VirtualProxyInterface;
use ReflectionClass;

abstract class ProxyReference extends Reference
{

    /**
     * @param DIContainer $container
     * @return VirtualProxyInterface
     */
    protected function factoryInstance(DIContainer $container)
    {
        $className = $this->getClassName();
        $factory = $container->get(DIContainer::PROXY_FACTORY);

        $instance = $factory->createProxy(
            $className,
            function (
                &$wrappedObject,
                $proxy,
                $method,
                $parameters,
                &$initializer
            ) use (
                $className,
                $container
            ) {
                $initializer = null;

                $reflection = new ReflectionClass($className);
                $wrappedObject = $reflection->newInstanceArgs(
                    $this->buildArguments($container)
                );
                $this->injectCalls($container, $reflection, $wrappedObject);
                $this->injectProperties($container, $reflection, $wrappedObject);

                return true;
            }
        );

        return $instance;
    }
}
