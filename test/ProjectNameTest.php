<?php

namespace Cpliakas\PhpProjectStarter\Test;

use Cpliakas\PhpProjectStarter\ProjectName;

class ProjectNameTest extends \PHPUnit_Framework_TestCase
{
    public function testParseProjectName()
    {
        $projectName = new ProjectName('cpliakas/my-project');

        $this->assertEquals($projectName->getVendor(), 'cpliakas');
        $this->assertEquals($projectName->getName(), 'my-project');
    }

    public function testSetProjectName()
    {
        $projectName = new ProjectName('cpliakas/my-project');
        $projectName->set('cpliakas/another-project');

        $this->assertEquals($projectName->get(), 'cpliakas/another-project');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testSetInvalidProjectName()
    {
        $projectName = new ProjectName('invalid');
    }

    public function testGetNameCamelCased()
    {
        $projectName = new ProjectName('cpliakas/my-project');

        $this->assertEquals($projectName->getNameCamelCased(), 'MyProject');
    }
}
