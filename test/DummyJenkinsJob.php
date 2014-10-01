<?php

namespace Cpliakas\PhpProjectStarter\Test;

use Cpliakas\PhpProjectStarter\JenkinsJob;
use Guzzle\Http\Message\Response;
use Guzzle\Plugin\Mock\MockPlugin;

class DummyJenkinsJob extends JenkinsJob
{
    public function newHttpClient()
    {
        $client = parent::newHttpClient();

        $plugin = new MockPlugin();
        $plugin->addResponse(new Response(200));
        $client->addSubscriber($plugin);

        return $client;
    }
}
