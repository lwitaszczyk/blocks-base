<?php

namespace Blocks\DI;

class DIAsPrototypeByClosure extends Service
{
    /**
     * @var callable
     */
    private $closure;

    /**
     * @param string $id
     * @param callable $closure
     */
    public function __construct($id, $closure)
    {
        parent::__construct($id);
        $this->closure = $closure;
    }

    /**
     * @inheritdoc
     */
    public function get(DIContainer $container)
    {
        $closure = $this->closure;
        return $closure($container);
    }
}
