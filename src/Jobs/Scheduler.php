<?php

namespace Jobs;

class Scheduler
{
    /**
     * @param array $queue
     * @return Sequence
     */
    public function make_sequence($queue)
    {
        $sequence = new Sequence([]);
        $jobs = $this->create_job_queue($queue);
        while(count($jobs))
        {
            $this->resolve_dependency_path($path, $jobs, current($jobs));
            foreach ($path as $name)
            {
                unset($jobs[$name]);
                if ( ! $sequence->contains($name))
                {
                    $sequence->append($name);
                }
            }
        }
        return $sequence;
    }

    /**
     * @param array $path
     * @param Job[] $jobs
     * @param Job $job
     */
    private function resolve_dependency_path(&$path = [], $jobs, Job $job)
    {
        $dependency = $job->getDependency();
        if ($dependency)
        {
            if (isset($jobs[$dependency]))
            {
                if ($jobs[$dependency]->isUsed())
                {
                    throw new \InvalidArgumentException('You have a circular dependency.');
                }
                $jobs[$dependency]->setUsed();
                $this->resolve_dependency_path($path, $jobs, $jobs[$dependency]);
            }
        }
        $path[] = $job->getName();
    }

    /**
     * @param array $queue
     * @return Job[]
     */
    private function create_job_queue($queue)
    {
        $jobs = [];
        foreach ($queue as $name => $dependency)
        {
            $jobs[$name] = new Job($name, $dependency);
        }
        return $jobs;
    }
}
