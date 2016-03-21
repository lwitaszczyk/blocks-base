<?php

namespace spec\Blocks\DI;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DIContainerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Blocks\DI\DIContainer');
    }
}
