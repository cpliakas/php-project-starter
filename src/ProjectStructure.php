<?php

namespace Cpliakas\PhpProjectStarter;

use GitWrapper\GitWrapper;
use Symfony\Component\Filesystem\Filesystem;

class ProjectStructure
{
    /**
     * @var array
     */
    protected $config = array();

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
    protected $filenames = array(
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
    );

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
            ->setConfig('directory',         './' . $projectName->getName())
            ->setConfig('label',             $projectName->getName())
            ->setConfig('description',       '')
            ->setConfig('copyright.year',    date('Y'))
            ->setConfig('copyright.holders', $this->getGitUsername($gitWrapper))
            ->setConfig('namespace',         $projectName->getNameCamelCased())
            ->setConfig('class',             $projectName->getNameCamelCased())
        ;
    }

    /**
     * @param string $option
     * @param mixed $value
     *
     * @return ProjectStructure
     */
    public function setConfig($option, $value)
    {
        if ($value !== null) {
            $this->config[$option] = $value;
        }
        return $this;
    }

    /**
     * @param string $option
     *
     * @return mixed
     */
    public function getConfig($option)
    {
        return isset($this->config[$option]) ? $this->config[$option] : null;
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
     * @return array
     */
    public function getReplacements()
    {
        if (!isset($this->replacements)) {
            $this->replacements = array(
              '{{ project.name }}'          => $this->projectName->get(),
              '{{ project.label }}'         => $this->getConfig('label'),
              '{{ project.description }}'   => $this->getConfig('description'),
              '{{ project.namespace }}'     => $this->getConfig('namespace'),
              '{{ project.namespace.esc }}' => str_replace('\\', '\\\\', $this->getConfig('namespace')),
              '{{ project.class }}'         => $this->getConfig('class'),
              '{{ copyright.year }}'        => $this->getConfig('copyright.year'),
              '{{ copyright.holders }}'     => $this->getConfig('copyright.holders'),
            );
        }

        return $this->replacements;
    }

    /**
     * @param string $filename
     *
     * @return ProjectStructure
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
     * @return boolean
     */
    public function create()
    {
        $dir = $this->getConfig('directory');
        $git = $this->gitWrapper->init($dir);

        $this->fs->mkdir($dir . '/src', 0755);
        $this->fs->mkdir($dir . '/test', 0755);

        // Move all files, add everything except dummy files
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
     *
     * @throws \RuntimeException
     * @throws \Symfony\Component\Filesystem\Exception\IOException
     */
    public function copy($filename, $dir)
    {
        $filepath = __DIR__ . '/../../../template/' . $filename;
        if (!is_file($filepath)) {
            throw new \RuntimeException('File not found: ' . $filename);
        }

        $replacements = $this->getReplacements();

        // Replace the variables in the template
        $search = array_keys($replacements);
        $replace = array_values($replacements);
        $subject = file_get_contents($filepath);
        $filedata = str_replace($search, $replace, $subject);

        // Write the file
        $target = $dir . '/' . $filename;
        $this->fs->touch($target);
        $this->fs->chmod($target, 0644);
        file_put_contents($target, $filedata);
    }
}
