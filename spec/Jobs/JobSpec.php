<?php

namespace spec\Jobs;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JobSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Jobs\Job');
    }

    function let()
    {
        $this->beConstructedWith('a', 'b');
    }

    function it_has_name()
    {
        $this->getName()->shouldReturn('a');
    }

    function it_has_dependency()
    {
        $this->getDependency()->shouldReturn('b');
    }
}
