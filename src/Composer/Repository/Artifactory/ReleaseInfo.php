<?php

/*
 * file that was distributed with this source code.
 */

namespace Composer\Repository\Artifactory;

/**
 * PEAR package release info
 *
 * @author Alexey Prilipko <palex@farpost.com>
 */
class ReleaseInfo
{
    private $stability;
    private $dependencyInfo;
    private $distributionPath;

    /**
     * @param string         $stability
     * @param DependencyInfo $dependencyInfo
     */
    public function __construct($stability, $dependencyInfo, $distributionPath)
    {
        $this->stability = $stability;
        $this->dependencyInfo = $dependencyInfo;
        $this->distributionPath = $distributionPath;
    }
    
    public function getDistributionPath()
    {
        return $this->distributionPath;
    }
    

    /**
     * @return DependencyInfo release dependencies
     */
    public function getDependencyInfo()
    {
        return $this->dependencyInfo;
    }

    /**
     * @return string release stability
     */
    public function getStability()
    {
        return $this->stability;
    }
}
