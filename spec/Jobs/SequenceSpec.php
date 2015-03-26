<?php

namespace spec\Jobs;

use Jobs\Job;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SequenceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Jobs\Sequence');
    }

    function it_appends_a_job()
    {
        $this->append(new Job('a'));
        $this->toArray()->shouldReturn(['a']);
    }

    function it_prepends_a_job()
    {
        $this->append(new Job('a'));
        $this->prepend(new Job('b'));
        $this->toArray()->shouldReturn(['b', 'a']);
    }

}
