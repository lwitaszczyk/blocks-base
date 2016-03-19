<?php

namespace Blocks\DI;

class DIAsSingleton extends DirectReference
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
            $this->instance = $this->createInstance($container);
        }
        return $this->instance;
    }
}
