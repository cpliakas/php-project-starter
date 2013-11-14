<?php

namespace PhpProject\Console;

use GitWrapper\GitWrapper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class StartCommand extends Command
{
    const NAME_PATTERN = '@^([A-Za-z0-9][A-Za-z0-9_.-]*)/([A-Za-z0-9][A-Za-z0-9_.-]+)$@';

    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    protected $fs;

    public function __construct(Filesystem $fs, $name = null)
    {
        $this->fs = $fs;
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
            ->addOption(
               'git-binary',
                null,
               InputOption::VALUE_REQUIRED,
               'The path to the Git binary'
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
        $projectName = $input->getArgument('project-name');
        list($vendor, $name) = $this->parseProjectName($projectName);

        $wrapper = new GitWrapper($input->getOption('git-binary'));
        $dir     = $input->getArgument('directory') ?: './' . $name;
        $label   = $input->getOption('label') ?: $name;
        $desc    = $input->getOption('description') ?: '';
        $year    = $input->getOption('copyright-year') ?: date('Y');
        $copy    = $this->getCopyrightHoldersOption($wrapper, $input->getOption('copyright-holders'));
        $ns      = $this->getNamespaceOption($input->getOption('namespace'), $name);

        $replacements = array(
          '{{ project.name }}'        => $projectName,
          '{{ project.label }}'       => $label,
          '{{ project.description }}' => $desc,
          '{{ project.namespace }}'   => $ns,
          '{{ copyright.year }}'      => $year,
          '{{ copyright.holders }}'   => $copy,
        );

        $filenames = array(
            '.coveralls.yml',
            '.editorconfig',
            '.gitignore',
            '.travis.yml',
            'LICENSE',
            'README.md',
            'build.xml',
            'composer.json',
            'phpunit.xml',
            'test/bootstrap.php',
        );

        $git = $wrapper->init($dir);

        $srcDir = $dir . '/src/' . str_replace('\\', '/', $ns);
        $this->fs->mkdir($dir . '/src/' . $srcDir, 0755);
        $this->fs->mkdir($dir . '/test/' . $srcDir . '/Test', 0755);

        foreach ($filenames as $filename) {
            $this->copy($filename, $dir, $replacements);
            $git->add($filename);
        }

        $git->commit('Initial commit.');
        $git->remote('add', 'origin', 'git@github.com:' . $projectName . '.git');
    }

    /**
     * @param string $dir
     *
     * @throws \RuntimeException
     * @throws \Symfony\Component\Filesystem\Exception\IOException
     */
    public function mkdir($dir)
    {
        if (!$this->fs->exists($dir)) {
            $this->fs->mkdir($dir, 0755);
        } else {
            throw new \RuntimeException('Directory exists: ' . $dir);
        }
    }

    /**
     * Copies a file from the template to the destination directory, replacing
     * all of the template variables.
     *
     * @param string $filename
     * @param string $dir
     * @param array $replacements
     *
     * @throws \RuntimeException
     * @throws \Symfony\Component\Filesystem\Exception\IOException
     */
    public function copy($filename, $dir, array $replacements = array())
    {
        if (!$filepath = realpath(__DIR__ . '/../../../template/' . $filename)) {
            throw new \RuntimeException('File not found: ' . $filename);
        }

        // Replace the variables in the template.
        $search = array_keys($replacements);
        $replace = array_values($replacements);
        $subject = file_get_contents($filepath);
        $filedata = str_replace($search, $replace, $subject);

        // Write the file.
        $target = $dir . '/' . $filename;
        $this->fs->touch($target);
        $this->fs->chmod($target, 0644);
        file_put_contents($target, $filedata);
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
     * @param \GitWrapper\GitWrapper $wrapper
     * @param string|null $option
     *
     * @return string
     *
     * @throws \GitWrapper\GitException;
     */
    public function getCopyrightHoldersOption(GitWrapper $wrapper, $option)
    {
        if (!$option) {
            $option = rtrim($wrapper->git('config --get --global user.name'));
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
