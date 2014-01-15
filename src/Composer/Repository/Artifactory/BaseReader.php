<?php

namespace Composer\Repository\Artifactory;


use Composer\Util\RemoteFilesystem;

 class BaseReader
 {
     
 
 private $rfs;

    public function __construct(RemoteFilesystem $rfs)
    {
        $this->rfs = $rfs;
    }
    
        protected function requestContent($origin, $path)
    {
        $url = rtrim($origin, '/') . '/' . ltrim($path, '/');
        $content = $this->rfs->getContents($origin, $url, false);
        if (!$content) {
            throw new \UnexpectedValueException('The PEAR channel at ' . $url . ' did not respond.');
        }
        return $content;
    }
    
        protected function requestXml($origin, $path)
    {
        // http://components.ez.no/p/packages.xml is malformed. to read it we must ignore parsing errors.
        $xml = simplexml_load_string($this->requestContent($origin, $path), "SimpleXMLElement", LIBXML_NOERROR);

        if (false == $xml) {
            $url = rtrim($origin, '/') . '/' . ltrim($path, '/');
            throw new \UnexpectedValueException(sprintf('The PEAR channel at ' . $origin . ' is broken. (Invalid XML at file `%s`)', $path));
        }

        return $xml;
    }
   
    
    
 }