<?php

namespace Blocks\DI;

class DIAsAlias extends Service
{
    /**
     * @var string
     */
    private $toService;

    /**
     * @param string $id
     * @param string $toService
     */
    public function __construct($id, $toService)
    {
        parent::__construct($id);
        $this->toService = $toService;
    }

    /**
     * {@inheritDoc}
     */
    public function get(DIContainer $container)
    {
        return $container->get($this->toService);
    }
}
