<?php

namespace Blocks\DI;

use Blocks\DI\Exception\ArgumentClosureMustBeCallableException;

class DIByClosure extends Argument
{

    /**
     * @var callable
     */
    private $closure;

    /**
     * @param callable $closure
     */
    public function __construct($closure)
    {
        parent::__construct(null);

        if (!is_callable($closure)) {
            new ArgumentClosureMustBeCallableException($this);
        }
        $this->closure = $closure;
    }

    /**
     * {@inheritDoc}
     */
    public function get()
    {
        return $this->closure();
    }
}
