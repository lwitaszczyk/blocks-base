<?php

namespace Blocks\DI;

class DIAsPrototype extends DirectReference
{

    /**
     * {@inheritDoc}
     */
    public function get()
    {
        return $this->createInstance();
    }
}
