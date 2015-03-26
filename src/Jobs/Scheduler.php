<?php

namespace Jobs;

class Scheduler
{
    public function make_sequence($jobs)
    {
        $sequence = new Sequence([]);

        foreach ($jobs as $job_name => $dependency_name)
        {
            if ($dependency_name)
            {
                $sequence->append($job_name);
            }
            else
            {
                $sequence->prepend($job_name);
            }
        }

        return $sequence;
    }
}
