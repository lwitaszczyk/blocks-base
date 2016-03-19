<?php

namespace Blocks\DI;

class DIAsProxySingleton extends ProxyReference
{

    /**
     * @var mixed
     */
    private $instance;

    /**
     * @param string $id
     * @param $className
     */
    public function __construct($id, $className)
    {
        parent::__construct($id, $className);
        $this->instance = null;
    }

    /**
     * {@inheritDoc}
     */
    public function get(DIContainer $container)
    {
        if (is_null($this->instance)) {
            $this->instance = $this->createInstance();
        }
        return $this->instance;
    }
}
