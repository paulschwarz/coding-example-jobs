<?php

namespace Jobs;

class Scheduler
{
    public function make_sequence($jobs)
    {
        $sequence = new Sequence([]);
        $job_queue = $this->create_job_queue($jobs);
        while(count($job_queue))
        {
            $this->resolve_dependency_path($path, $job_queue, current($job_queue));
            foreach ($path as $job_name)
            {
                unset($job_queue[$job_name]);
                if ( ! $sequence->contains($job_name))
                {
                    $sequence->append($job_name);
                }
            }
        }
        return $sequence;
    }

    private function resolve_dependency_path(&$path = [], $job_queue, Job $job)
    {
        $dependency = $job->getDependency();
        if ($dependency)
        {
            if (isset($job_queue[$job->getDependency()]))
            {
                $this->resolve_dependency_path($path, $job_queue, $job_queue[$job->getDependency()]);
            }
        }
        $path[] = $job->getName();
    }

    private function create_job_queue($jobs)
    {
        $job_queue = [];
        foreach ($jobs as $job_name => $dependency_name)
        {
            $job_queue[$job_name] = new Job($job_name, $dependency_name);
        }
        return $job_queue;
    }
}
