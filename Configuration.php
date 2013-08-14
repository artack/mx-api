<?php

namespace Artack\MxApi;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
/**
 * Class Configuration
 * @package Artack\MxApi
 */
/**
 * Class Configuration
 * @package Artack\MxApi
 */
class Configuration
{

    /**
     * @var string
     */
    protected $host;

    /**
     * @var boolean
     */
    protected $useSSL;

    /**
     * @var boolean
     */
    protected $verifyPeer;

    /**
     * @var string
     */
    protected $format;

    /**
     * @var string
     */
    protected $customerKey;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
    protected $apiSecret;

    /**
     * @var int
     */
    protected $defaultVersion;

    /**
     * @var string
     */
    protected $defaultLanguage;

    /**
     * timeout in seconds
     *
     * @var int
     */
    protected $timeout = 300;

    /**
     * @param $host
     * @param $useSSL
     * @param $verifyPeer
     * @param $format
     * @param $customerKey
     * @param $apiKey
     * @param $apiSecret
     * @param $defaultVersion
     * @param $defaultLanguage
     * @param $timeout
     */
    function __construct($host, $useSSL, $verifyPeer, $format, $customerKey, $apiKey, $apiSecret, $defaultVersion, $defaultLanguage, $timeout)
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
        $this->timeout = $timeout;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return boolean
     */
    public function getUseSSL()
    {
        return $this->useSSL;
    }

    /**
     * @return boolean
     */
    public function getVerifyPeer()
    {
        return $this->verifyPeer;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @return string
     */
    public function getCustomerKey()
    {
        return $this->customerKey;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @return string
     */
    public function getApiSecret()
    {
        return $this->apiSecret;
    }

    /**
     * @return int
     */
    public function getDefaultVersion()
    {
        return $this->defaultVersion;
    }

    /**
     * @return string
     */
    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
    }

    /**
     * @param $customerKey
     */
    public function setCustomerKey($customerKey)
    {
        $this->customerKey = $customerKey;
    }

    /**
     * @param $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param $apiSecret
     */
    public function setApiSecret($apiSecret)
    {
        $this->apiSecret = $apiSecret;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

}
