<?php

namespace Blocks\DI;

class DIByTags extends Argument
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
