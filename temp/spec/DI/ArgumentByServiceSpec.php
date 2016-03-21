<?php

namespace spec\Blocks\DI;

use Blocks\DI\Exception\ExceptionContainerNotAssigned;
use PhpSpec\ObjectBehavior;

class ArgumentByServiceSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $name = 'name';
        $this->beConstructedWith($name);
        $this->shouldHaveType('Blocks\DI\ArgumentByService');

        $this->shouldThrow(ExceptionContainerNotAssigned::class)->during('get');
    }
}
