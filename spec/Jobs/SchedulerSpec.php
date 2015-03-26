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
        $this->make_sequence([])
            ->toArray()->shouldReturn([]);
    }

    function it_makes_a_job_sequence_with_a_single_job()
    {
        $sequence = $this->make_sequence([
            'a' => NULL,
        ]);
        $sequence->containsExactly(['a'])->shouldReturn(TRUE);
    }

    function it_makes_a_job_sequence_with_three_independent_jobs()
    {
        $sequence = $this->make_sequence([
            'a' => NULL,
            'b' => NULL,
            'c' => NULL,
        ]);
        $sequence->containsExactly(['a', 'b', 'c'])->shouldReturn(TRUE);
    }

    function it_makes_a_job_sequence_where_b_depends_on_c()
    {
        $sequence = $this->make_sequence([
            'a' => NULL,
            'b' => 'c',
            'c' => NULL,
        ]);
        $sequence->containsExactly(['a', 'b', 'c'])->shouldReturn(TRUE);
        $sequence->isBefore('c', 'b')->shouldReturn(TRUE);
    }
}
