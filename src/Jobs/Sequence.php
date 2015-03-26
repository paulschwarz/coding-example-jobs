<?php

namespace Jobs;

class Sequence
{
    private $jobs = [];

    public function __construct($jobs)
    {
        $this->jobs = $jobs;
    }

    public function append($job)
    {
        array_push($this->jobs, $job);
    }

    public function prepend($job)
    {
        array_unshift($this->jobs, $job);
    }

    public function toArray()
    {
        return $this->jobs;
    }

    public function contains($job)
    {
        return in_array($job, $this->jobs);
    }

    public function containsExactly($jobs)
    {
        return count(array_diff($this->jobs, $jobs)) === 0 && count(array_diff($jobs, $this->jobs)) === 0;
    }

    public function isBefore($jobBefore, $jobAfter)
    {
        return $this->getJobPosition($jobBefore) < $this->getJobPosition($jobAfter);
    }

    private function getJobPosition($job)
    {
        $position = array_search($job, $this->jobs);
        if ($position === FALSE)
        {
            throw new \InvalidArgumentException(sprintf('Job "%s" does not exist.', $job));
        }
        else
        {
            return $position;
        }
    }
}
