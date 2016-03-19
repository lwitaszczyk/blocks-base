<?php

namespace Blocks\DI;

use Blocks\Configuration;

class DIByConfiguration extends Argument
{

    /**
     * @var mixed
     */
    private $defaultValue;

    /**
     * @var string
     */
    private $key;

    /**
     * DIByConfiguration constructor.
     * @param string $key
     * @param mixed $defaultValue
     */
    public function __construct($key, $defaultValue = null)
    {
        parent::__construct(null);
        $this->defaultValue = $defaultValue;
        $this->key = $key;
    }

    /**
     * {@inheritDoc}
     */
    public function get(DIContainer $container)
    {
        return $container->getConfiguration()->get($this->key, $this->defaultValue);
    }
}
