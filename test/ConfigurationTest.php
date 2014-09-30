<?php

namespace Cpliakas\PhpProjectStarter\Test;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function testSetConfig()
    {
        $config = new DummyConfiguration();
        $config->setConfig('test', 'value');

        $this->assertEquals($config->getConfig('test'), 'value');
    }

    public function testGetNullConfig()
    {
        $config = new DummyConfiguration();

        $this->assertNull($config->getConfig('test'));
    }
}
