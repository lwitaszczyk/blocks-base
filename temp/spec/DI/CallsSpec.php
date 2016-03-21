<?php

namespace spec\Blocks\DI;

use PhpSpec\ObjectBehavior;

class CallsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith();
        $this->shouldHaveType('Blocks\DI\Calls');
    }
}
