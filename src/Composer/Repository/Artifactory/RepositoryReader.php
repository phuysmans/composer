<?php

namespace Composer\Repository\Artifactory;

use Composer\Util\RemoteFilesystem,
    Composer\Downloader\TransportException;

class RepositoryReader extends BaseReader
{

    public function __construct(RemoteFilesystem $rfs)
    {
        parent::__construct($rfs);
    }    
    
    
    public function read($url, $path)
    {
        $packageDefinitions = $this->readPackages($url, $path);
        return new RepositoryInfo($path, '', $packageDefinitions);
    }

    /**
     * 
     * @param type $url
     * @return array
     */
    public function readPackages($url, $path)
    {
        $content = $this->requestContent($url, $path);
        // parse whacky artifactory list format
        preg_match_all('/<a href="(.+)\/"/', $content, $matches);
        $result = array();
        foreach ($matches[1] as $packageName) {
            if ($packageName == '.' || $packageName == '..') {
                continue;
            }
            
            try {
                $packageInfo = $this->readPackage($url, $path, $packageName);
                $result[] = $packageInfo;
            } catch (TransportException $exception) {
                if ($exception->getCode() != 404) {
                    throw $exception;
                }
            }            
        }
        return $result;
    }

    
    private function readPackage($url, $path, $packageName)
    {
        $xmlPath = $path . $packageName .'/maven-metadata.xml';
        $xml = $this->requestXml($url, $xmlPath);
        /// $xml->registerXPathNamespace('ns', self::PACKAGE_INFO_NS);

        $repositoryName = trim($path, '/');
        $packageName = (string) $xml->artifactId;
        $latestVersion = (string) $xml->versioning->latest;
        
        return new PackageInfo(
            $repositoryName,
            $packageName,
            '', // $license,
            '', // $shortDescription,
            '', // $description,
            $this->readPackageReleases($url, $path, $packageName)
        );
    }

    
    private function readPackageReleases($url, $path, $packageName)
    {
        $xmlPath = $path . $packageName .'/maven-metadata.xml';
        $xml = $this->requestXml($url, $xmlPath);
        $result = array();
        foreach ($xml->versioning->versions->version as $version) {
            $releaseVersion = (string) $version;
            $releaseInfo = $this->readPackageRelease($url, $path, $packageName, $releaseVersion);
            $result[$releaseVersion] = $releaseInfo;
        }
        return $result;
    }
    
    private function readPackageRelease($url, $path, $packageName, $release)
    {
        // open dir and parse pom file 
        $xmlPath = $path . $packageName .'/'. $release .'/'. $packageName .'-'. $release .'.pom';
        $xml = $this->requestXml($url, $xmlPath);
        
        // $packageName = (string) $xml->name;
        $packageVersion = (string) $xml->version;
        $packageExtension = (string) $xml->packaging;

        $distributionPath = $path . $packageName . '/'. $release .'/'. $packageName .'-'. $release .'.'. $packageExtension;
        // $xml->distributionManagement->repository->name
        
        return new ReleaseInfo('', '', $distributionPath);
    }
    
    
    
}