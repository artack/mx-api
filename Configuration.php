<?php

namespace Artack\MxApi;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class Configuration
{

    protected $host;
    protected $useSSL;
    protected $verifyPeer;
    protected $format;
    protected $customerKey;
    protected $apiKey;
    protected $apiSecret;
    protected $defaultVersion;
    protected $defaultLanguage;

    function __construct($host, $useSSL, $verifyPeer, $format, $customerKey, $apiKey, $apiSecret, $defaultVersion, $defaultLanguage)
    {
        $this->host = $host;
        $this->useSSL = $useSSL;
        $this->verifyPeer = $verifyPeer;
        $this->format = $format;
        $this->customerKey = $customerKey;
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->defaultVersion = $defaultVersion;
        $this->defaultLanguage = $defaultLanguage;
    }
    
    public function getHost()
    {
        return $this->host;
    }

    public function getUseSSL()
    {
        return $this->useSSL;
    }
    
    public function getVerifyPeer()
    {
        return $this->verifyPeer;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function getCustomerKey()
    {
        return $this->customerKey;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function getApiSecret()
    {
        return $this->apiSecret;
    }

    public function getDefaultVersion()
    {
        return $this->defaultVersion;
    }

    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }

}
