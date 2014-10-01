<?php

namespace Cpliakas\PhpProjectStarter\Test;

use Cpliakas\PhpProjectStarter\JenkinsJob;
use Cpliakas\PhpProjectStarter\ProjectName;
use Cpliakas\PhpProjectStarter\Repository;
use GitWrapper\GitWrapper;

class JenkinsJobTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Returns a stub JenkinsJob method
     *
     * @return JenkinsJob
     */
    public function newJenkinsJob()
    {
        $projectName = new ProjectName('cpliakas/test');
        $repository  = new Repository($projectName, new GitWrapper());
        return new DummyJenkinsJob($projectName, $repository, 'http://example.com');
    }

    public function testGetConfigTemplate()
    {
        $this->assertNotEmpty($this->newJenkinsJob()->getConfigTemplate());
    }

    public function testDefaultSslVerification()
    {
        $this->assertTrue($this->newJenkinsJob()->getSslVerification());
    }

    public function testSetSslVerification()
    {
        $jenkinsJob = $this->newJenkinsJob();
        $jenkinsJob->sslVerification(false);

        $this->assertFalse($jenkinsJob->getSslVerification());
    }

    public function testCreateJenkinsJob()
    {
        $jenkinsJob = $this->newJenkinsJob();
        $this->assertTrue($jenkinsJob->create());
    }

    public function testCreateJenkinsJobNoSslVerification()
    {
        $jenkinsJob = $this->newJenkinsJob();
        $jenkinsJob->sslVerification(false);
        $this->assertTrue($jenkinsJob->create());
    }
}
