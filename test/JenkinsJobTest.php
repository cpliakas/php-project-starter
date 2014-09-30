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
        return new JenkinsJob($projectName, $repository, 'http://example.com');
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
}
