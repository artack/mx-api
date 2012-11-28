<?php

namespace Artack\MxApi\Request;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class Url
{
    
    protected $baseUrl;
    protected $useSSL;
    protected $apiVersion;
    
    protected $path = null;
    protected $ids = null;

    function __construct($baseUrl, $useSSL, $apiVersion)
    {
        $this->baseUrl = $baseUrl;
        $this->useSSL = $useSSL;
        $this->apiVersion = $apiVersion;
    }
    
    public function setPath($path, $ids)
    {
        $this->path = $path;
        $this->ids = $ids;
    }

}