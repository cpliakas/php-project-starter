<?php

namespace Cpliakas\PhpProjectStarter;

class ProjectName
{
    const REGEX = '@^([A-Za-z0-9][A-Za-z0-9_.-]*)/([A-Za-z0-9][A-Za-z0-9_.-]+)$@';

    /**
     * @var string
     */
    protected $vendor;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $projectName
     */
    public function __construct($projectName)
    {
        $this->set($projectName);
    }

    /**
     * @param string $projectName
     *
     * @return ProjectName
     *
     * @throws \RuntimeException
     */
    public function set($projectName)
    {
        if (!preg_match(self::REGEX, $projectName, $matches)) {
            throw new \RuntimeException('Project name not valid');
        }

        $this->vendor = $matches[1];
        $this->name   = $matches[2];

        return $this;
    }

    /**
     * Returns the full project name in vendor/name format.
     *
     * @return string
     */
    public function get()
    {
        return $this->vendor . '/' . $this->name;
    }

    /**
     * @return string
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @var string
     */
    public function getNameCamelCased()
    {
        $parts = preg_split('/[_.-]/', $this->name);

        array_walk($parts, function (&$value, $key) {
            $value = ucfirst($value);
        });

        return join('', $parts);
    }
}
