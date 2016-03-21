<?php

namespace spec\Blocks\DI;

use PhpSpec\ObjectBehavior;

class ParameterSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $name = 'name';
        $value = 'value';

        $this->beConstructedWith($name, $value);
        $this->shouldHaveType('Blocks\DI\Parameter');
        $this->getOverride()->shouldEqual(false);
        $this->getName()->shouldEqual($name);
        $this->getValue()->shouldEqual($value);

        $this->addTags([
            'tag1',
            'tag2',
        ]);
        $this->hasTag('tag1')->shouldEqual(true);
    }
}
