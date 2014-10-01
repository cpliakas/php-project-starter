<?php

namespace Cpliakas\PhpProjectStarter;

use Guzzle\Http\Client;

class JenkinsJob implements ConfigurableInterface, CreatableInterface
{
    use Configuration;

    /**
     * @var ProjectName
     */
    protected $projectName;

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var boolean
     */
    protected $sslVerification = true;

    /**
     * @param ProjectName $projectName
     * @param Repository  $repository
     * @param string      $url
     */
    public function __construct(ProjectName $projectName, Repository $repository, $url)
    {
        $this->projectName = $projectName;
        $this->repository  = $repository;
        $this->url         = $url;
    }

    /**
     * @param boolean $verify
     *
     * @return JenkinsJob
     */
    public function sslVerification($verify = false)
    {
        $this->sslVerification = (bool) $verify;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getSslVerification()
    {
        return $this->sslVerification;
    }

    /**
     * @return Client
     */
    public function newHttpClient()
    {
        return new Client($this->url);
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $client = $this->newHttpClient();

        if (!$this->sslVerification) {
            $client->setSslVerification(false, false);
        }

        $job = str_replace('{{ project.name }}', $this->projectName->get(), $this->getConfigTemplate());

        $headers = [
            'Content-Type' => 'text/xml'
        ];

        $options = [
            'query' => array('name' => $this->projectName->getName()),
        ];

        $client->post($this->url . '/createItem', $headers, $job, $options)->send();
        return true;
    }

    /**
     * @return string
     */
    public function getConfigTemplate()
    {
        return file_get_contents(__DIR__ . '/../jenkins/config.xml');
    }
}
