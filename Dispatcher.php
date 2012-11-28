<?php

namespace Artack\MxApi;

use Artack\MxApi\Authenticator\AuthenticatorInterface;
use Artack\MxApi\Configuration;
use Artack\MxApi\Hasher\HasherInterface;
use Artack\MxApi\Header\Date\DateHeader;
use Artack\MxApi\Header\HeadersInterface;
use Artack\MxApi\Header\XAuth\XAuthHeader;
use Artack\MxApi\Randomizer\RandomizerInterface;
use Artack\MxApi\Request\Call;
use Artack\MxApi\Request\Url;
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
        $this->prepare($call);
        $this->call();
        
        return $this->parse();
    }
    
    protected function prepare($call)
    {
        // $method, $requestUrl, $format, $body, $date, $nonce
        
        $date = new DateTime();
        $nonce = $this->randomizer->getRandom(32);
        
//        $call = new Call($data['method'], $this->url->getRequestUrl(), $data['format'], $data['body'], $dateHeader->getHeader(), $nonce);
        var_dump($call);
        
        $serializedBody = $this->authenticator->getSerializedBody($call);
        $hmac = $this->hasher->getHash($serializedBody, $this->configuration->getApiSecret());
        
        $this->headers->addHeader(new DateHeader($date));
        $this->headers->addHeader(new XAuthHeader($this->configuration->getCustomerKey(), $this->configuration->getApiKey(), $hmac, $nonce));
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
