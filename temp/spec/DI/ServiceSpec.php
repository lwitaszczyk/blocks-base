<?php

namespace spec\Blocks\DI;

use Blocks\DI\Arguments;
use Blocks\DI\Container;
use Blocks\DI\Exception\ExceptionArgumentsAlreadyAdded;
use Blocks\DI\Exception\ExceptionClassNotAccepted;
use Blocks\DI\Exception\ExceptionContainerNotAssigned;
use PhpSpec\ObjectBehavior;
use stdClass;

class ServiceSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $name = 'serivce-name';
        $this->beConstructedWith($name);
        $this->shouldHaveType('Blocks\DI\Service');
        $this->getName()->shouldBe($name);

        $this->shouldThrow(ExceptionContainerNotAssigned::class)->during('get', [$name]);

        $this->addTags([
            'tag-1',
            'tag-2',
        ]);
        $this->hasTag('tag-1')->shouldEqual(true);

        $this->addTag('tag-3')->shouldBe($this);
        $this->hasTag('tag-3')->shouldEqual(true);

        $this->hasTag('tag-4')->shouldEqual(false);
    }

    public function it_should_add_not_accepted_class()
    {
        $this->beConstructedWith('test');
        $this->shouldThrow(ExceptionClassNotAccepted::class)->during('add', [
            [
                new stdClass(),
            ],
        ]);
    }

    public function it_should_not_set_two_times_arguments()
    {
        $this->beConstructedWith('SERVICE-NAME');
        $this->setArguments(new Arguments())->shouldBe($this);
        $this->shouldThrow(ExceptionArgumentsAlreadyAdded::class)->during('setArguments', [
            new Arguments(),
        ]);
    }

    public function it_should_get_previously_set_container()
    {
        $this->beConstructedWith('SERVICE-NAME');
        $container = new Container();
        $this->setContainer($container)->shouldBe($this);
    }
}
