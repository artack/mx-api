<?php

namespace Artack\MxApi\Request;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class Url
{
    
    protected $baseUrl;
    protected $useSSL;
    
    function __construct($baseUrl, $useSSL)
    {
        $this->baseUrl = $baseUrl;
        $this->useSSL = $useSSL;
    }
    
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    public function getUseSSL()
    {
        return $this->useSSL;
    }

}