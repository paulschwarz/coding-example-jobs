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
        $this->beConstructedWith('a');
    }

    function it_gets_the_job_name()
    {
        $this->getName()->shouldReturn('a');
    }
}
