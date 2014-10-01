<?php

namespace Cpliakas\PhpProjectStarter\Test;

use Cpliakas\PhpProjectStarter\Console\NewCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

class ConsoleTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        parent::tearDown();
        $fs = new Filesystem();
        if ($fs->exists('./build/tmp')) {
            $fs->remove('./build/tmp');
        }
    }

    public function testNewCommandInputs()
    {
        $application = new Application();
        $application->add(new NewCommand());

        $command = $application->find('new');
        $commandTester = new CommandTester($command);

        $input = [
            'command' => $command->getName(),
            'project-name' => 'cpliakas/my-project',
            'directory' => './build/tmp/my-project'
        ];

        $commandTester->execute($input);

        $this->assertFileExists($input['directory']);
    }
}
