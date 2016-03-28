<?php

namespace Blocks\DI;

class DIAsPrototype extends DirectReference
{

    /**
     * {@inheritDoc}
     */
    public function get(DIContainer $container)
    {
        return $this->createInstance($container);
    }
}
