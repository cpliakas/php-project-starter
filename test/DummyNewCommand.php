<?php

namespace Cpliakas\PhpProjectStarter\Test;

use Cpliakas\PhpProjectStarter\Console\NewCommand;
use Cpliakas\PhpProjectStarter\ProjectName;
use GitWrapper\GitWrapper;

class DummyNewCommand extends NewCommand
{
    protected function newRepository(ProjectName $projectName, GitWrapper $gitWrapper)
    {
        return new DummyRepository($projectName, new GitWrapper());
    }
}
