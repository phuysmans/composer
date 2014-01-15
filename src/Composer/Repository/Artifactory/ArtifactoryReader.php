<?php

namespace Composer\Repository\Artifactory;

use Composer\Util\RemoteFilesystem;

class ArtifactoryReader extends BaseReader
{
    
    protected $rfs;
    
        public function __construct(RemoteFilesystem $rfs)
    {
        parent::__construct($rfs);
        $this->rfs = $rfs;
    }
    
    
    public function readRepositories($url)
    {
        $repoLocations = array(
            // '/app-snapshot-local/php/' => 'release',
            '/app-release-local/php/' => 'dev',
            '/plugins-release-local/php/' => 'dev'
            
        );
        
        $respositories = array();
        foreach ($repoLocations as $repo => $dist) {
            
            $reader = new RepositoryReader($this->rfs);
            $repositories[] = $reader->read($url, $repo);
        }

        return $repositories;
    }
    
    
    public function read($url)
    {
        
        // repositories
        
        // app-release-local/php
        // app-snapshot-local/php
        
        $repositories = $this->readRepositories($url);

        /*
        $xml = $this->requestXml($url, '');
        $nodes = $xml->xpath('//a[.!=".."]');
        var_dump($xml, $nodes);
         * 
         */
        /*
        $channelName = (string) $xml->name;
        $channelSummary = (string) $xml->summary;
        $channelAlias = (string) $xml->suggestedalias;

        $supportedVersions = array_keys($this->readerMap);
        $selectedRestVersion = $this->selectRestVersion($xml, $supportedVersions);
        if (!$selectedRestVersion) {
            throw new \UnexpectedValueException(sprintf('PEAR repository %s does not supports any of %s protocols.', $url, implode(', ', $supportedVersions)));
        }

        $reader = $this->readerMap[$selectedRestVersion['version']];
        $packageDefinitions = $reader->read($selectedRestVersion['baseUrl']);
        */
        return new ArtifactoryInfo('', $url, $repositories);
    }

    
    
    
    
    

}