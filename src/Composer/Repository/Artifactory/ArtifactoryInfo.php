<?php

namespace Composer\Repository\Artifactory;

class ArtifactoryInfo
{
    
    private $repositories;
    
    private $name;
    private $url;
    
    public function __construct($name = '', $url ='', $repositories)
    {
        $this->url = $url;
        $this->repositories = $repositories;
    }
    
    
    public function getName()
    {
        return $this->name;
    }
    
    public function getUrl()
    {
        return $this->url;
    }
    
    public function getRepositories()
    {
        return $this->repositories;
    }
    
    
    public function getPackages()
    {
        $result = array();
        foreach ($this->getRepositories() as $repo) {
            $result = array_merge($result, $repo->getPackages());
        }
        return $result;
    }
    
    
}