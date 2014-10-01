<?php

namespace Cpliakas\PhpProjectStarter\Test;

use Cpliakas\PhpProjectStarter\ProjectName;
use Cpliakas\PhpProjectStarter\Repository;
use GitWrapper\GitWrapper;
use Symfony\Component\Filesystem\Filesystem;

class RepositoryTest extends \PHPUnit_Framework_TestCase
{

    public function tearDown()
    {
        parent::tearDown();
        $fs = new Filesystem();
        if ($fs->exists('./build/tmp')) {
            $fs->remove('./build/tmp');
        }
    }

    /**
     * Returns a stub JenkinsJob method
     *
     * @return DummyRepository
     */
    public function newRepository()
    {
        $projectName = new ProjectName('cpliakas/my-project');
        $repository  = new DummyRepository($projectName, new GitWrapper());

        $repository->setConfig('directory', './build/tmp/my-project');
        $repository->setConfig('copyright.holders', 'Chris Pliakas');

        return $repository;
    }

    public function testGetConfigDefaults()
    {
        $projectName = new ProjectName('cpliakas/my-project');
        $repository  = new Repository($projectName, new GitWrapper());

        $this->assertEquals('./my-project', $repository->getConfig('directory'));
        $this->assertEquals('my-project',   $repository->getConfig('label'));
        $this->assertEquals('',             $repository->getConfig('description'));
        $this->assertEquals(date('Y'),      $repository->getConfig('copyright.year'));
        $this->assertEquals('MyProject',    $repository->getConfig('namespace'));
        $this->assertEquals('MyProject',    $repository->getConfig('class'));
    }

    public function testGetReplacements()
    {
        $projectName = new ProjectName('cpliakas/my-project');
        $repository = new Repository($projectName, new GitWrapper());

        $repository
            ->setConfig('label', 'My Project')
            ->setConfig('description', 'Test description.')
            ->setConfig('copyright.year', '1982')
            ->setConfig('copyright.holders', 'Chris Pliakas')
            ->setConfig('namespace', 'Test\Namespace')
        ;

        $replacements = $repository->getReplacements();

        $this->assertEquals('cpliakas/my-project', $replacements['{{ project.name }}']);
        $this->assertEquals('My Project', $replacements['{{ project.label }}']);
        $this->assertEquals('Test description.', $replacements['{{ project.description }}']);
        $this->assertEquals('Test\Namespace', $replacements['{{ project.namespace }}']);
        $this->assertEquals('Test\\\\Namespace', $replacements['{{ project.namespace.esc }}']);
        $this->assertEquals('MyProject', $replacements['{{ project.class }}']);
        $this->assertEquals('1982', $replacements['{{ copyright.year }}']);
        $this->assertEquals('Chris Pliakas', $replacements['{{ copyright.holders }}']);
    }

    public function testAddFilename()
    {
        $repository = $this->newRepository();
        $repository->addFilename('testfile');
        $filenames = $repository->getFilenames();

        $this->assertEquals('testfile', array_pop($filenames));
    }

    public function testCreateRepo()
    {
        $repository = $this->newRepository();
        $repository->create();

        $this->assertFileExists('./build/tmp/my-project');
    }

    /**
     * @expectedException \Symfony\Component\Filesystem\Exception\IOException
     */
    public function testExceptionWhenCreatingDuplicateRepo()
    {
        $repository = $this->newRepository();
        $repository->create();
        $repository->create();
    }

    /**
     * @expectedException \Symfony\Component\Filesystem\Exception\IOException
     */
    public function testCopyInvalidFile()
    {
        $repository = $this->newRepository();
        $repository->addFilename('testfile');
        $repository->create();
    }
}
