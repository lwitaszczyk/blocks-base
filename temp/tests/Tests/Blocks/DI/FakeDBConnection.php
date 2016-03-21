<?php

namespace Tests\Blocks\DI;

class FakeDBConnection
{

    private $configuration;

    public function __construct(FakeDBConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

}
