<?php

namespace Cpliakas\PhpProjectStarter;

use GitWrapper\GitWrapper;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

class Repository implements ConfigurableInterface, CreatableInterface
{
    use Configuration;

    /**
     * @var ProjectName
     */
    protected $projectName;

    /**
     * @var GitWrapper
     */
    protected $gitWrapper;

    /**
     * @var Filesystem
     */
    protected $fs;

    /**
     * @var array
     */
    protected $filenames = [
        '.editorconfig',
        '.gitignore',
        '.scrutinizer.yml',
        '.travis.yml',
        'LICENSE',
        'README.md',
        'build.xml',
        'composer.json',
        'phpmd.xml',
        'phpunit.xml',
        'src/DummyClass.php',
        'test/bootstrap.php',
        'test/DummyTest.php',
    ];

    /**
     * @var array
     */
    private $replacements;

    /**
     * @param ProjectName $projectName
     * @param GitWrapper $gitWrapper
     */
    public function __construct(ProjectName $projectName, GitWrapper $gitWrapper)
    {
        $this->projectName = $projectName;
        $this->gitWrapper  = $gitWrapper;
        $this->fs          = new Filesystem();

        // Set the default config values
        $this
            ->setConfig('directory',      './' . $this->projectName->getName())
            ->setConfig('label',          $projectName->getName())
            ->setConfig('description',    '')
            ->setConfig('copyright.year', date('Y'))
            ->setConfig('namespace',      $projectName->getNameCamelCased())
            ->setConfig('class',          $projectName->getNameCamelCased())
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $dir = $this->getConfig('directory');
        $git = $this->initRepository($dir);

        $this->fs->mkdir($dir . '/src', 0755);
        $this->fs->mkdir($dir . '/test', 0755);

        // Move all files, add everything to repo except dummy class file
        foreach ($this->getFilenames() as $filename) {
            $this->copy($filename, $dir);
            if ($filename != 'src/DummyClass.php') {
                $git->add($filename);
            }
        }

        // Rename the dummy class file and add it to the repo
        $classFilepath = 'src/' . $this->getConfig('class') . '.php';
        $this->fs->rename($dir . '/src/DummyClass.php', $dir . '/' . $classFilepath);
        $git->add($classFilepath);

        $git->commit('Initial commit.');
        $git->remote('add', 'origin', 'git@github.com:' . $this->projectName->get() . '.git');

        return true;
    }

    /**
     * @param string
     *
     * @return \GitWrapper\GitWorkingCopy
     */
    protected function initRepository($dir)
    {
        return $this->gitWrapper->init($dir);
    }

    /**
     * @return array
     */
    public function getReplacements()
    {
        if (!isset($this->replacements)) {

            $this->replacements = [
              '{{ project.name }}'          => $this->projectName->get(),
              '{{ project.label }}'         => $this->getConfig('label'),
              '{{ project.description }}'   => $this->getConfig('description'),
              '{{ project.namespace }}'     => $this->getConfig('namespace'),
              '{{ project.namespace.esc }}' => str_replace('\\', '\\\\', $this->getConfig('namespace')),
              '{{ project.class }}'         => $this->getConfig('class'),
              '{{ copyright.year }}'        => $this->getConfig('copyright.year'),
              '{{ copyright.holders }}'     => $this->getConfig('copyright.holders') ?: $this->getGitUsername(),
            ];
        }

        return $this->replacements;
    }

    /**
     * @param string $filename
     *
     * @return Repository
     */
    public function addFilename($filename)
    {
        $this->filenames[] = $filename;
        return $this;
    }

    /**
     * @return array
     */
    public function getFilenames()
    {
        return $this->filenames;
    }

    /**
     * Returns Git's "user.name" configuration.
     *
     * @return string
     *
     * @throws \GitWrapper\GitException;
     */
    public function getGitUsername()
    {
        return rtrim($this->gitWrapper->git('config --get --global user.name'));
    }

    /**
     * Copies a file from the template to the destination directory, replacing
     * all of the template variables.
     *
     * @param string $filename
     * @param string $dir
     *
     * @throws IOException
     * @throws FileNotFoundException
     */
    public function copy($filename, $dir)
    {
        $filepath = __DIR__ . '/../template/' . $filename;
        if (!is_file($filepath)) {
            $message = sprintf('Failed to copy "%s" because file does not exist.', $filepath);
            throw new FileNotFoundException($message, 0, null, $filepath);
        }

        $subject = file_get_contents($filepath);
        $filedata = $this->replace($subject);

        $this->fs->dumpFile($dir . '/' . $filename, $filedata, 0644);
    }

    /**
     * @param string $subject
     *
     * @return string
     */
    public function replace($subject)
    {
        $replacements = $this->getReplacements();

        $search  = array_keys($replacements);
        $replace = array_values($replacements);

        return str_replace($search, $replace, $subject);
    }
}
