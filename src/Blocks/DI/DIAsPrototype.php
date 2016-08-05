<?php

namespace Blocks\DI;

class DIAsPrototype extends Reference
{
    /**
     * {@inheritDoc}
     */
    public function get(DIContainer $container)
    {
        return $this->createInstance($container);
    }
}
