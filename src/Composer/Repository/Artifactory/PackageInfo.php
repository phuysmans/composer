<?php

/*
 
 */

namespace Composer\Repository\Artifactory;

/**
 * Artifactory Package info
 *
 * @author 
 * 
 */
class PackageInfo
{
    private $repositoryName;
    private $packageName;
    private $license;
    private $shortDescription;
    private $description;
    private $releases;


    /**
     * @param string        $channelName
     * @param string        $packageName
     * @param string        $license
     * @param string        $shortDescription
     * @param string        $description
     * @param ReleaseInfo[] $releases         associative array maps release version to release info
     */
    public function __construct($repositoryName, $packageName, $license, $shortDescription, $description, $releases)
    {
        $this->repositoryName = $repositoryName;
        $this->packageName = $packageName;
        $this->license = $license;
        $this->shortDescription = $shortDescription;
        $this->description = $description;
        $this->releases = $releases;
    }

    
    
    /**
     * @return string the package channel name
     */
    public function getRepositoryName()
    {
        return $this->repositoryName;
    }

    /**
     * @return string the package name
     */
    public function getPackageName()
    {
        return $this->packageName;
    }

    /**
     * @return string the package description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string the package short description
     */
    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    /**
     * @return string the package licence
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * @return ReleaseInfo[]
     */
    public function getReleases()
    {
        return $this->releases;
    }
}
