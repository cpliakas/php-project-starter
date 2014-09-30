<?php

namespace Cpliakas\PhpProjectStarter;

trait Configuration
{
    /**
     * @var array
     */
    protected $config = array();

    /**
     * @param string $option
     * @param mixed $value
     *
     * @return self
     */
    public function setConfig($option, $value)
    {
        if ($value !== null) {
            $this->config[$option] = $value;
        }
        return $this;
    }

    /**
     * @param string $option
     *
     * @return mixed
     */
    public function getConfig($option)
    {
        return isset($this->config[$option]) ? $this->config[$option] : null;
    }
}
