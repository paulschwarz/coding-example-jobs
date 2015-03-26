<?php

namespace Jobs;

class Job
{
    private
        $name,
        $depends,
        $used = FALSE;

    public function __construct($name, $depends)
    {
        if ($name === $depends)
        {
            throw new \InvalidArgumentException(sprintf('"%s" cannot depend on itself.', $name));
        }
        $this->name = $name;
        $this->depends = $depends;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDependency()
    {
        return $this->depends;
    }

    public function isUsed()
    {
        return $this->used;
    }

    public function setUsed()
    {
        $this->used = TRUE;
    }
}
