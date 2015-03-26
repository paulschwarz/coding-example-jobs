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

	function it_makes_a_job_sequence_with_a_single_job()
	{
		$this->make_sequence([
			'a' => NULL,
		])->shouldReturn([
			'a',
		]);
	}

	function it_makes_a_job_sequence_with_three_independent_jobs()
	{
		$this->make_sequence([
			'a' => NULL,
			'b' => NULL,
			'c' => NULL,
		])->shouldReturn([
			'a',
			'b',
			'c',
		]);
	}
}
