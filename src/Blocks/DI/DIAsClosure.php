<?php

namespace Blocks\DI;

class DIAsClosure extends Service
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
        $c = $this->closure;
        return $c();
    }
}
