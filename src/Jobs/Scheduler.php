<?php

namespace Jobs;

class Scheduler
{
    /**
     * @param array $queue
     * @return Sequence
     */
    public function makeSequence($queue)
    {
        $sequence = new Sequence([]);
        $jobs = $this->createJobsFromQueue($queue);
        while(count($jobs))
        {
            $this->resolveDependencyPath($path, $jobs, current($jobs));
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
    private function resolveDependencyPath(&$path = [], $jobs, Job $job)
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
                $this->resolveDependencyPath($path, $jobs, $jobs[$dependency]);
            }
        }
        $path[] = $job->getName();
    }

    /**
     * @param array $queue
     * @return Job[]
     */
    private function createJobsFromQueue($queue)
    {
        $jobs = [];
        foreach ($queue as $name => $dependency)
        {
            $jobs[$name] = new Job($name, $dependency);
        }
        return $jobs;
    }
}
