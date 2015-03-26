<?php

namespace spec\Jobs;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SequenceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Jobs\Sequence');
    }

    function let()
    {
        $this->beConstructedWith([]);
    }

    function it_appends_a_job()
    {
        $this->append('a');
        $this->toArray()->shouldReturn(['a']);
    }

    function it_prepends_a_job()
    {
        $this->beConstructedWith(['a']);
        $this->prepend('b');
        $this->toArray()->shouldReturn(['b', 'a']);
    }

    function it_returns_true_if_it_contains_exactly_a_b()
    {
        $this->beConstructedWith(['b', 'a']);
        $this->containsExactly(['a', 'b'])->shouldReturn(TRUE);
    }

    function it_returns_false_if_it_contains_more_than_a()
    {
        $this->beConstructedWith(['a', 'b']);
        $this->containsExactly(['a'])->shouldReturn(FALSE);
    }

    function it_returns_false_if_it_contains_less_than_a_b()
    {
        $this->beConstructedWith(['a']);
        $this->containsExactly(['a', 'b'])->shouldReturn(FALSE);
    }

    function it_returns_true_if_a_is_before_b()
    {
        $this->beConstructedWith(['a', 'b']);
        $this->isBefore('a', 'b')->shouldReturn(TRUE);
    }

    function it_returns_false_if_a_is_not_before_b()
    {
        $this->beConstructedWith(['b', 'a']);
        $this->isBefore('a', 'b')->shouldReturn(FALSE);
    }

    function it_throws_exception_if_a_does_not_exist()
    {
        $this->beConstructedWith(['b', 'c']);
        $this->shouldThrow(new \InvalidArgumentException('Job "a" does not exist.'))->during('isBefore', ['a', 'b']);
    }

    function it_returns_true_if_it_contains_a()
    {
        $this->beConstructedWith(['a', 'b']);
        $this->contains('a')->shouldReturn(TRUE);
    }

    function it_returns_false_if_it_does_not_contain_a()
    {
        $this->beConstructedWith(['c', 'b']);
        $this->contains('a')->shouldReturn(FALSE);
    }
}
