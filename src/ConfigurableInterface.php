<?php

namespace Cpliakas\PhpProjectStarter;

interface ConfigurableInterface
{
    /**
     * @param string $option
     * @param mixed  $value
     *
     * @return ConfigurableInterface
     */
    public function setConfig($option, $value);

    /**
     * @param string $option
     *
     * @return mixed
     */
    public function getConfig($option);
}
