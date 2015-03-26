<?php

namespace spec\Jobs;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SchedulerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Jobs\Scheduler');
    }

	function it_makes_an_empty_sequence_for_an_empty_jobs_string()
	{
		$this->make_sequence("")->shouldReturn([]);
	}
}