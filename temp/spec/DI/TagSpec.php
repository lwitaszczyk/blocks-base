<?php

namespace spec\Blocks\DI;

use Blocks\DI\Exception\ExceptionContainerNotAssigned;
use PhpSpec\ObjectBehavior;

class TagSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $tag = 'name';
        $this->beConstructedWith($tag);
        $this->shouldHaveType('Blocks\DI\Tag');

        $this->shouldThrow(ExceptionContainerNotAssigned::class)->during('get');
    }
}
