<?php

namespace Artack\MxApi;

use Artack\MxApi\Authenticator\AuthenticatorInterface;
use Artack\MxApi\Configuration;
use Artack\MxApi\Hasher\HasherInterface;
use Artack\MxApi\Header\Accept\AcceptHeader;
use Artack\MxApi\Header\Date\DateHeader;
use Artack\MxApi\Header\HeadersInterface;
use Artack\MxApi\Header\XAuth\XAuthHeader;
use Artack\MxApi\Randomizer\RandomizerInterface;
use Artack\MxApi\Request\Call;
use DateTime;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class Dispatcher
{

    /**
     * @var Configuration
     */
    protected $configuration;
    
    /**
     * @var RandomizerInterface
     */
    protected $randomizer;
    
    /**
     * @var AuthenticatorInterface
     */
    protected $authenticator;
    
    /**
     * @var HasherInterface
     */
    protected $hasher;
    
    /**
     * @var HeadersInterface
     */
    protected $headers;
    
    /**
     * @var Call
     */
    protected $call;
    
    public function __construct(Configuration $configuration, RandomizerInterface $randomizer, AuthenticatorInterface $authenticator, HasherInterface $hasher, HeadersInterface $headers)
    {
        $this->configuration = $configuration;
        $this->randomizer = $randomizer;
        $this->authenticator = $authenticator;
        $this->hasher = $hasher;
        $this->headers = $headers;
    }
    
    public function dispatch(Call $call)
    {
        $this->call = $call;
        
        $this->prepare();
        $this->call();
        
        return $this->parse();
    }
    
    protected function prepare()
    {
        $this->call->setDate(new DateTime());
        $this->call->setNonce($this->randomizer->getRandom(32));
        
        $serializedBody = $this->authenticator->getSerializedBody($this->call);
        $hmac = $this->hasher->getHash($serializedBody, $this->configuration->getApiSecret());
        
        $this->headers->addHeader(new XAuthHeader($this->configuration->getCustomerKey(), $this->configuration->getApiKey(), $hmac, $this->call->getNonce()));
        $this->headers->addHeader(new DateHeader($this->call->getDate()));
        $this->headers->addHeader(new AcceptHeader($this->call->getPath(".", false), $this->configuration->getFormat(), $this->call->getVersion()));
        
        var_dump($this->call->getRequestUrl());
    }
    
    protected function call()
    {
        var_dump($this->headers->getHeaders());
    }
    
    protected function parse()
    {
        return 'dummy';
    }
    
}
