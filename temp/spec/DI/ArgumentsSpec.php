<?php

namespace spec\Blocks\DI;

use Blocks\DI\Container;
use Blocks\DI\Exception\ExceptionContainerNotAssigned;
use Blocks\DI\ArgumentByParameter;
use Blocks\DI\ArgumentByService;
use PhpSpec\ObjectBehavior;

class ArgumentsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith();
        $this->shouldHaveType('Blocks\DI\Arguments');
    }

    public function it_should_get_items()
    {
        $this->add([
            (new ArgumentByParameter('par1', 'val1')),
            (new ArgumentByParameter('par2', 'val2')),
            (new ArgumentByService('ref1')),
            (new ArgumentByService('ref2')),
        ])->shouldBe($this);

        $this->shouldThrow(ExceptionContainerNotAssigned::class)->during('getItems');

        $container = new Container();
        $this->setContainer($container)->shouldBe($this);

        $this->getItems()->shouldBeArray();
    }
}
