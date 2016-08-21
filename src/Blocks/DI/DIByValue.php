<?php

namespace Blocks\DI;

class DIByValue extends Argument
{

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        parent::__construct(null);
        $this->value = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function get(DIContainer $container)
    {
        return $this->value;
    }
}
