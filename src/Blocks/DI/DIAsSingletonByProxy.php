<?php

namespace Blocks\DI;

use ProxyManager\Factory\LazyLoadingValueHolderFactory;

class DIAsSingletonByProxy extends DIAsSingleton
{
    /**
     * @var object
     */
    private $reference;

    /**
     * @param string $id
     * @param $className
     */
    public function __construct($id, $className)
    {
        parent::__construct($id, $className);
        $this->reference = null;
    }

    /**
     * {@inheritDoc}
     */
    public function get(DIContainer $container)
    {
        if (is_null($this->reference)) {
            $factory = $this->getProxyFactory($container);
            $this->reference = $factory->createProxy(
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

        return $this->reference;
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
