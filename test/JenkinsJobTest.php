<?php

namespace Cpliakas\PhpProjectStarter\Test;

use Cpliakas\PhpProjectStarter\JenkinsJob;
use Cpliakas\PhpProjectStarter\ProjectName;
use Cpliakas\PhpProjectStarter\Repository;
use GitWrapper\GitWrapper;

class JenkinsJobTest extends \PHPUnit_Framework_TestCase
{
    public function testGetConfigTemplate()
    {
        $projectName = new ProjectName('cpliakas/test');
        $repository  = new Repository($projectName, new GitWrapper());
        $jenkinsJob  = new JenkinsJob($projectName, $repository, 'http://example.com');

        $this->assertNotEmpty($jenkinsJob->getConfigTemplate());
    }
}
