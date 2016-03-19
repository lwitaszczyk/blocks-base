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
     * @return mixed
     */
    public function get()
    {
        return $this->closure();
    }
}
