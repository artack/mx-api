<?php

namespace ARTACK\MXAPI;

use ARTACK\MXAPI\Factory\Factory;
use ARTACK\MXAPI\Factory\FactoryInterface;
use Exception;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class MailxpertAPI
{

    
    /**
     * @var \ARTACK\MXAPI\Factory\FactoryInterface
     */
    protected $factory;
    protected $browser;
    protected $coder;
    
    /**
     * @var \ARTACK\MXAPI\Authenticator\AuthenticatorInterface
     */
    protected $authenticator;
    
    /**
     * @var \ARTACK\MXAPI\Randomizer\RandomizerInterface
     */
    protected $randomizer;
    
    /**
     * @var \ARTACK\MXAPI\Header\AccountTokenHeaderInterface
     */
    protected $accountTokenHeader;
    
    /**
     * @var \ARTACK\MXAPI\Header\DateHeaderInterface
     */
    protected $dateHeader;
    
    protected $nonce;
    protected $customerKey = null;
    protected $apiKey = null;
    protected $secret = null;
    
    function __construct($customerKey, $apiKey, $secret, FactoryInterface $factory = null) {
    
        $this->customerKey = $customerKey;
        $this->apiKey = $apiKey;
        $this->secret = $secret;
        $this->factory = $factory ?: new Factory();
        
        $this->build();
        $this->init();
    }
    
    protected function build()
    {
        $this->randomizer = Factory::buildRandomizer();
        $this->authenticator = Factory::buildAuthenticator();
        $this->accountTokenHeader = Factory::buildAccountTokenHeader();
        $this->dateHeader = Factory::buildDateHeader();
    }
    
    protected function init()
    {
        $this->nonce = $this->randomizer->getRandom(32);
        
        $this->authenticator->setData('anydata');
        $this->authenticator->setKey($this->secret);
        
        $hmac = $this->authenticator->getHash();
        
        $this->accountTokenHeader->setCustomerKey($this->customerKey);
        $this->accountTokenHeader->setApiKey($this->apiKey);
        $this->accountTokenHeader->setHmac($hmac);
        $this->accountTokenHeader->setNonce($this->nonce);
    }
    
    /**
     * @return string
     */
    public function getCustomerKey()
    {
        return $this->customerKey;
    }

    /**
     * @param string $customerKey
     */
    public function setCustomerKey($customerKey)
    {
        $this->customerKey = $customerKey;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }
    
    /**
     * @return string
     */
    public function getRandom($length)
    {
        return $this->randomizer->getRandom($length);
    }
    
    /**
     * @return string
     */
    public function getDateHeader()
    {
        return $this->dateHeader->getHeader();
    }
    
    /**
     * @return string
     */
    public function getAccountTokenHeader()
    {
        return $this->accountTokenHeader->getHeader();
    }
    
}
