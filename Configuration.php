<?php

namespace Artack\MxApi;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class Configuration
{

    protected $host;
    protected $useSSL;
    
    protected $version;
    protected $format;

    protected $customerKey;
    protected $apiKey;
    protected $apiSecret;

    public function __construct($host, $useSSL, $version, $format, $customerKey, $apiKey, $apiSecret)
    {
        $this->host = $host;
        $this->useSSL = $useSSL;
        $this->version = $version;
        $this->format = $format;
        $this->customerKey = $customerKey;
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getUseSSL()
    {
        return $this->useSSL;
    }
    
    public function getVersion()
    {
        return $this->version;
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

}
