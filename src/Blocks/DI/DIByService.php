<?php

namespace Blocks\DI;

class DIByService extends Argument
{

    /**
     * {@inheritDoc}
     */
    public function get(DIContainer $container)
    {
        return $container->get(
            $this->getArgumentName()
        );
    }
}
