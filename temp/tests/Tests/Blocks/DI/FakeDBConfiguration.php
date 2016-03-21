<?php

namespace Tests\Blocks\DI;

class FakeDBConfiguration
{

    private $host;
    private $user;

    public function __construct($host, $user)
    {
        $this->host = $host;
        $this->user = $user;
    }

}
