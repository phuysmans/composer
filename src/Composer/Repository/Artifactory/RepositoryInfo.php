<?php

/*

 */

namespace Composer\Repository\Artifactory;

/**
 * 
 */
class RepositoryInfo
{
    private $name;
    private $alias;
    private $packages;

    /**
     * @param string        $name
     * @param string        $alias
     * @param PackageInfo[] $packages
     */
    public function __construct($name, $alias, array $packages)
    {
        $this->name = $name;
        $this->alias = $alias;
        $this->packages = $packages;
    }

    /**
     * Name of the channel
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Alias of the channel
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * List of channel packages
     *
     * @return PackageInfo[]
     */
    public function getPackages()
    {
        return $this->packages;
    }
}
