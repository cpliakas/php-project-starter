<?php

namespace Cpliakas\PhpProjectStarter\Test;

use Cpliakas\PhpProjectStarter\Repository;

class DummyRepository extends Repository
{
    protected function initRepository($dir)
    {
        $git = parent::initRepository($dir);
        $git->config('user.email', 'test@example.com');
        $git->config('user.name',  'Chris Pliakas');
        return $git;
    }
}
