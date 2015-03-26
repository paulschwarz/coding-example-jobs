<?php

namespace Jobs;

class Sequence
{
    private $jobs = [];

    public function append(Job $job)
    {
        array_push($this->jobs, $job);
    }

    public function prepend(Job $job)
    {
        array_unshift($this->jobs, $job);
    }

    public function toArray()
    {
        return array_map(function(Job $job){
            return $job->getName();
        }, $this->jobs);
    }
}
