<?php

namespace Blocks\DI\Exception;

use Blocks\DI\DIByClosure;

class ArgumentClosureMustBeCallableException extends ContainerException
{
    /**
     * ArgumentClosureMustBeCallableException constructor.
     * @param DIByClosure $closure
     */
    public function __construct(DIByClosure $closure)
    {
        parent::__construct('Closure must be callable');
    }
}
