<?php

namespace Jobs;

class Scheduler
{
    public function make_sequence($jobs = [])
    {
		$jobs = $this->sanitize($jobs);

		$sequence = [];
		foreach ($jobs as $job => $dependant)
		{
			if ($dependant)
			{
				array_push($sequence, $job);
			}
			else
			{
				array_unshift($sequence, $job);
			}
		}

		return $sequence;
    }

	/**
	 * @param $jobs
	 *
	 * @return array
	 */
	private function sanitize($jobs)
	{
		if ($jobs === "")
		{
			$jobs = [];
		}
		return $jobs;
	}
}
