<?php

namespace Blocks\DI;

class DIAsProxyPrototype extends ProxyReference
{

    /**
     * {@inheritDoc}
     */
    public function get(DIContainer $container)
    {
        return $this->createInstance();
    }
}
