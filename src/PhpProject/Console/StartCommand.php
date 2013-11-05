<?php

namespace PhpProject\Console;

use GitWrapper\GitWrapper;
use GitWrapper\GitException;
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

    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    protected $fs;

    /**
     * @var \GitWrapper\GitWrapper
     */
    protected $wrapper;

    public function __construct(Filesystem $fs, GitWrapper $wrapper, $name = null)
    {
        $this->fs = $fs;
        $this->wrapper = $wrapper;
        parent::__construct($name);
    }

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
        $projectName = $input->getArgument('project-name');
        list($vendor, $name) = $this->parseProjectName($projectName);

        $dir   = $input->getArgument('directory') ?: './' . $name;
        $label = $input->getOption('label') ?: $name;
        $desc  = $input->getOption('description') ?: '';
        $year  = $input->getOption('copyright-year') ?: date('Y');
        $copy  = $this->getCopyrightHoldersOption($input->getOption('copyright-holders'));
        $ns    = $this->getNamespaceOption($input->getOption('namespace'), $name);

        if (!$this->fs->exists($dir)) {
            $this->fs->mkdir($dir, 0755);
        } else {
            throw new \RuntimeException('Directory exists: ' . $dir);
        }

    }

    /**
     * @param \Symfony\Component\Filesystem\Filesystem $fs
     * @param string $dir
     */
    public function mkdir(Filesystem $fs, $dir)
    {

    }

    /**
     * Parses the full project name into the vendor and name.
     *
     * @param string $projectName
     *
     * @return array
     *
     * @throws \RuntimeException
     */
    public function parseProjectName($projectName)
    {
        if (preg_match(self::NAME_PATTERN, $projectName, $matches)) {
          return array($matches[1], $matches[2]);
        } else {
            throw new \RuntimeException('Name invalid.');
        }
    }

    /**
     * Default to Git's "user.name" configuration if the "copyright-holders"
     * option wasn't passed.
     *
     * @param string|null $option
     *
     * @return string
     *
     * @throws \GitWrapper\GitException;
     */
    public function getCopyrightHoldersOption($option)
    {
        if (!$option) {
            $option = rtrim($this->wrapper->git('config --get --global user.name'));
        }
        return $option;
    }

    /**
     * Default to the project name in CamelCase if the "namespace" option wasn't
     * passed.
     *
     * @param string|null $option
     * @param string $name
     *
     * @return string
     */
    public function getNamespaceOption($option, $name)
    {
        if (!$option) {
            $parts = preg_split('/[_.-]/', $name);
            array_walk($parts, function (&$value, $key) {
                $value = ucfirst($value);
            });
            $option = join('', $parts);
        }
        return $option;
    }
}
