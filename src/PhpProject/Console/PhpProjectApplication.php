<?php

namespace PhpProject\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;

class PhpProjectApplication extends Application
{
    protected function getCommandName(InputInterface $input)
    {
        return 'start';
    }

    protected function getDefaultCommands()
    {
        $defaultCommands = parent::getDefaultCommands();
        $defaultCommands[] = new StartCommand();
        return $defaultCommands;
    }

    public function getDefinition()
    {
        $inputDefinition = parent::getDefinition();
        $inputDefinition->setArguments();
        return $inputDefinition;
    }
}
