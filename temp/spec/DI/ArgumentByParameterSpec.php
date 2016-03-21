<?php

namespace spec\Blocks\DI;

use Blocks\DI\Exception\ExceptionContainerNotAssigned;
use PhpSpec\ObjectBehavior;

class ArgumentByParameterSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $name = 'name';
        $this->beConstructedWith($name);
        $this->shouldHaveType('Blocks\DI\ArgumentByParameter');

        $this->shouldThrow(ExceptionContainerNotAssigned::class)->during('get');
    }
}
