<?php

namespace PhpProject\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Filesystem\Filesystem;

class PhpProjectApplication extends Application
{
    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    protected $fs;

    public function __construct(Filesystem $fs, $name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        $this->fs = $fs;
        parent::__construct($name, $version);
    }

    protected function getCommandName(InputInterface $input)
    {
        return 'start';
    }

    protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();
        $defaultCommands[] = new StartCommand($this->fs);
        return $defaultCommands;
    }

    public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();
        $inputDefinition->setArguments();
        return $inputDefinition;
    }
}
