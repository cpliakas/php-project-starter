<?php

namespace Cpliakas\PhpProjectStarter\Console;

use Cpliakas\PhpProjectStarter\JenkinsJob;
use Cpliakas\PhpProjectStarter\ProjectName;
use Cpliakas\PhpProjectStarter\Repository;
use GitWrapper\GitWrapper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class NewCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('new')
            ->setDescription('Start a new PHP project')
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
               'PSR-4 namespace, e.g. MyProject, SubProject\\MyComponent, defaults to the project name in came case'
            )
            ->addOption(
               'class',
                null,
               InputOption::VALUE_REQUIRED,
               'The class in the namespace used to create the initial class file, defaults to the project name in came case'
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
               'Usually the vendor\'s real name, defaults to Git\'s "user.name" configuration'
            )
            ->addOption(
               'git-binary',
                null,
               InputOption::VALUE_REQUIRED,
               'The path to the Git binary'
            )
            ->addOption(
               'jenkins-url',
                null,
               InputOption::VALUE_REQUIRED,
               'The URL of the Jenkins server that the job will be created on'
            )
            ->addOption(
               'no-ssl-verification',
                null,
               InputOption::VALUE_NONE,
               'If set, SSL verification will be skipped'
            )
            ->addOption(
               'no-repo',
                null,
               InputOption::VALUE_NONE,
               'Don\'t create the Git repository'
            )
        ;
    }

    /**
     * @{inheritdoc}
     *
     * @throws \RuntimeException
     * @throws \GitWrapper\GitException
     * @throws \Symfony\Component\Filesystem\Exception\IOException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectName = new ProjectName($input->getArgument('project-name'));
        $gitWrapper  = new GitWrapper($input->getOption('git-binary'));

        $repository = $this->newRepository($projectName, $gitWrapper)
            ->setConfig('directory'        , $input->getArgument('directory'))
            ->setConfig('label'            , $input->getOption('label'))
            ->setConfig('description'      , $input->getOption('description'))
            ->setConfig('copyright.year'   , $input->getOption('copyright-year'))
            ->setConfig('copyright.holders', $input->getOption('copyright-holders'))
            ->setConfig('namespace',         $input->getOption('namespace'))
            ->setConfig('class',             $input->getOption('class'))
        ;

        if (!$input->getOption('no-repo')) {
            $repository->create();
        }

        if ($jenkinsUrl = $input->getOption('jenkins-url')) {
            $jenkinsJob = new JenkinsJob($projectName, $repository, $jenkinsUrl);
            $jenkinsJob->sslVerification(!($input->getOption('no-ssl-verification')));
            $jenkinsJob->create();
        }
    }

    /**
     * @param ProjectName $projectName
     * @param GitWrapper $gitWrapper
     *
     * @return Repository
     */
    protected function newRepository(ProjectName $projectName, GitWrapper $gitWrapper)
    {
        return new Repository($projectName, $gitWrapper);
    }
}
