<?php

namespace Blocks\DI;

use ReflectionClass;

abstract class DirectReference extends Reference
{

    /**
     * @return object
     */
    protected function factoryInstance(DIContainer $container)
    {
        $reflection = new ReflectionClass($this->getClassName());
        $instance = $reflection->newInstanceArgs(
            $this->buildArguments($container)
        );
        $this->injectCalls($container, $reflection, $instance);
        $this->injectProperties($container, $reflection, $instance);
        return $instance;
    }
}
