<?php

namespace PhpProject\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;

class PhpProjectApplication extends Application
{
    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    protected $fs;

    /**
     * @var \GitWrapper\GitWrapper
     */
    protected $wrapper;

    public function __construct(Filesystem $fs, GitWrapper $wrapper, $name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        $this->fs = $fs;
        $this->wrapper = $wrapper;
        parent::__construct($name, $version);
    }

    protected function getCommandName(InputInterface $input)
    {
        return 'start';
    }

    protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();
        $defaultCommands[] = new StartCommand($this->fs, $this->wrapper);
        return $defaultCommands;
    }

    public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();
        $inputDefinition->setArguments();
        return $inputDefinition;
    }
}
