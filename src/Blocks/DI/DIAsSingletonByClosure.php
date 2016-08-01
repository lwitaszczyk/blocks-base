<?php

namespace Blocks\DI;

class DIAsSingletonByClosure extends Service
{
    /**
     * @var callable
     */
    private $closure;

    /**
     * @var mixed
     */
    private $reference;

    /**
     * @param string $id
     * @param callable $closure
     */
    public function __construct($id, $closure)
    {
        parent::__construct($id);
        $this->closure = $closure;
        $this->reference = null;
    }

    /**
     * @inheritdoc
     */
    public function get(DIContainer $container)
    {
        if (is_null($this->reference)) {
            $closure = $this->closure;
            $this->reference = $closure($container);
        }
        return $this->reference;
    }
}
