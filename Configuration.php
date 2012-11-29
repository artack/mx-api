<?php

namespace Artack\MxApi;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class Configuration
{

    protected $host;
    protected $useSSL;
    protected $format;
    protected $customerKey;
    protected $apiKey;
    protected $apiSecret;
    protected $defaultVersion;

    public function __construct($host, $useSSL, $format, $customerKey, $apiKey, $apiSecret, $defaultVersion)
    {
        $this->host = $host;
        $this->useSSL = $useSSL;
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

}
