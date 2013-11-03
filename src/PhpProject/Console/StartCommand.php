<?php

namespace PhpProject\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class StartCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('start')
            ->setDescription('Start a new PHP project.')
            ->addArgument(
                'directory',
                InputArgument::REQUIRED,
                'The directory the PHP project is being started in'
            )
            ->addOption(
               'name',
               null,
               InputOption::VALUE_REQUIRED,
               'The project\'s name in vendor/project format'
            )
            ->addOption(
               'label',
               null,
               InputOption::VALUE_REQUIRED,
               'The project\'s display name, e.g. "My Project"'
            )
            ->addOption(
               'description',
               null,
               InputOption::VALUE_REQUIRED,
               'The project\'s longer description'
            )
            ->addOption(
               'namespace',
               null,
               InputOption::VALUE_REQUIRED,
               'PSR-0 namespace, e.g. MyProject, SubProject\\MyComponent'
            )
            ->addOption(
               'copyright-year',
               null,
               InputOption::VALUE_REQUIRED,
               'Usually the current year or range of years'
            )
            ->addOption(
               'copyright-holders',
               null,
               InputOption::VALUE_REQUIRED,
               'Usually the vendor\'s real name'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }
}
