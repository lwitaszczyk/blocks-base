<?php

namespace Blocks\DI;

class DIByTag extends Argument
{
    /**
     * {@inheritDoc}
     */
    public function get(DIContainer $container)
    {
        return $container->findByTag(
            $this->getArgumentName()
        );
    }
}
