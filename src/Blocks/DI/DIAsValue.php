<?php

namespace Blocks\DI;

class DIAsValue extends Service
{

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param string $id
     * @param mixed $value
     */
    public function __construct($id, $value)
    {
        parent::__construct($id);
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function get(DIContainer $container)
    {
        return $this->value;
    }
}
