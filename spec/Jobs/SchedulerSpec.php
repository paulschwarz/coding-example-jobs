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

    function it_makes_a_job_sequence_where__c_before_b()
    {
        $sequence = $this->make_sequence([
            'a' => NULL,
            'b' => 'c',
            'c' => NULL,
        ]);
        $sequence->containsExactly(['a', 'b', 'c'])->shouldReturn(TRUE);
        $sequence->isBefore('c', 'b')->shouldReturn(TRUE);
    }

    function it_makes_a_job_sequence_where__f_before_c__c_before_b__b_before_e__a_before_d()
    {
        $sequence = $this->make_sequence([
            'a' => NULL,
            'b' => 'c',
            'c' => 'f',
            'd' => 'a',
            'e' => 'b',
            'f' => NULL,
        ]);
        $sequence->containsExactly(['a', 'b', 'c', 'd', 'e', 'f'])->shouldReturn(TRUE);
        $sequence->isBefore('f', 'c')->shouldReturn(TRUE);
        $sequence->isBefore('c', 'b')->shouldReturn(TRUE);
        $sequence->isBefore('b', 'e')->shouldReturn(TRUE);
        $sequence->isBefore('a', 'd')->shouldReturn(TRUE);
    }

    function it_throws_exception_when_c_depends_on_c()
    {
        $this->shouldThrow(new \InvalidArgumentException('"c" cannot depend on itself.'))->during('make_sequence', [[
            'a' => NULL,
            'b' => NULL,
            'c' => 'c',
        ]]);
    }

    function it_throws_exception_when_there_is_a_circular_dependency()
    {
        $this->shouldThrow(new \InvalidArgumentException('You have a circular dependency.'))->during('make_sequence', [[
            'a' => NULL,
            'b' => 'c',
            'c' => 'f',
            'd' => 'a',
            'e' => NULL,
            'f' => 'b',
        ]]);
    }
}
