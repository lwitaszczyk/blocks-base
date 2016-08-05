<?php

namespace Blocks\DI;

use ProxyManager\Factory\LazyLoadingValueHolderFactory;

class DIAsPrototypeByProxy extends DIAsPrototype
{
    /**
     * {@inheritDoc}
     */
    public function get(DIContainer $container)
    {
        $factory = $this->getProxyFactory($container);
        return $factory->createProxy(
            $this->getClassName(),
            function (
                &$wrappedObject,
                $proxy,
                $method,
                $parameters,
                &$initializer
            ) use (
                $container
            ) {
                $wrappedObject = parent::get($container);
                return true;
            }
        );
    }

    /**
     * @param DIContainer $container
     * @return LazyLoadingValueHolderFactory
     */
    private function getProxyFactory(DIContainer $container)
    {
        return $container->get(DIContainer::PROXY_FACTORY);
    }
}
