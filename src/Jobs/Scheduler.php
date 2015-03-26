<?php

namespace Jobs;

class Scheduler
{
    public function make_sequence($jobs)
    {
		if ($jobs)
		{
			return array_keys($jobs);
		}
		else
		{
			return [];
		}
    }
}
