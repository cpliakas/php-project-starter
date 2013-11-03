<?php

namespace PhpProject\Console;

use GitWrapper\GitWrapper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;

class StartCommand extends Command
{
    const NAME_PATTERN = '@^([A-Za-z0-9][A-Za-z0-9_.-]*)/([A-Za-z0-9][A-Za-z0-9_.-]+)$@';

    protected function configure()
    {
        $this
            ->setName('start')
            ->setDescription('Start a new PHP project.')
            ->addArgument(
               'project-name',
               InputArgument::REQUIRED,
               'The project\'s name in vendor/project format'
            )
            ->addArgument(
                'directory',
                InputArgument::OPTIONAL,
                'The directory the PHP project is being started in, defaults to a directory named after the project'
            )
            ->addOption(
               'label',
                null,
               InputOption::VALUE_REQUIRED,
               'The project\'s display name, e.g. "My Project", defaults to the project name'
            )
            ->addOption(
               'description',
                null,
               InputOption::VALUE_REQUIRED,
               'The project\'s longer description, defaults to an empty string'
            )
            ->addOption(
               'namespace',
                null,
               InputOption::VALUE_REQUIRED,
               'PSR-0 namespace, e.g. MyProject, SubProject\\MyComponent, defaults to the project name in came case'
            )
            ->addOption(
               'copyright-year',
                null,
               InputOption::VALUE_REQUIRED,
               'Usually the current year or range of years, defaults to the current year'
            )
            ->addOption(
               'copyright-holders',
                null,
               InputOption::VALUE_REQUIRED,
               'Usually the vendor\'s real name, defaults to the Git\'s "user.name" configuration'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $wrapper = new GitWrapper();

        // Use the same pattern as Composer to validate the project name.
        $fullname = $input->getArgument('project-name');
        if (preg_match(self::NAME_PATTERN, $fullname, $matches)) {
            $user = $matches[1];
            $name = $matches[2];
        } else {
            throw new \RuntimeException('Name invalid.');
        }

        $dir   = $input->getArgument('directory') ?: './' . $name;
        $label = $input->getOption('label') ?: $name;
        $desc  = $input->getOption('description') ?: '';
        $year  = $input->getOption('copyright-year') ?: date('Y');

        // Default to Git's "user.name" configuration.
        if (!$copy = $input->getOption('copyright-holders')) {
            $copy = rtrim($wrapper->git('config --get --global user.name'));
        }

        // Default to the project name in camelcase.
        if (!$ns = $input->getOption('namespace')) {
            $parts = preg_split('/[_.-]/', $name);
            array_walk($parts, function (&$value, $key) {
                $value = ucfirst($value);
            });
            $ns = join('', $parts);
        }

        $fs = new Filesystem();

        if (!$fs->exists($dir)) {
            $fs->mkdir($dir, 0755);
        } else {
            throw new \RuntimeException('Directory exists: ' . $dir);
        }

    }
}
