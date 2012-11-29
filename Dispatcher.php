<?php

namespace Artack\MxApi;

use Artack\MxApi\Hasher\HasherInterface;
use Artack\MxApi\Header\AcceptHeader;
use Artack\MxApi\Header\AcceptLanguageHeader;
use Artack\MxApi\Header\DateHeader;
use Artack\MxApi\Header\XAuthHeader;
use Artack\MxApi\Headers\HeadersInterface;
use Artack\MxApi\Normalizer\NormalizerInterface;
use Artack\MxApi\Randomizer\RandomizerInterface;
use Artack\MxApi\Request\Call;
use Buzz\Client\Curl;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;
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
     * @var NormalizerInterface
     */
    protected $normalizer;
    
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
    
    /**
     * @var RequestInterface
     */
    protected $request;
    
    /**
     * @var MessageInterface
     */
    protected $response;
    
    /**
     * @var Curl
     */
    protected $curl;
    
    public function __construct(Configuration $configuration, RandomizerInterface $randomizer, NormalizerInterface $normalizer, HasherInterface $hasher, HeadersInterface $headers, RequestInterface $request, MessageInterface $response, Curl $curl)
    {
        $this->configuration = $configuration;
        $this->randomizer = $randomizer;
        $this->normalizer = $normalizer;
        $this->hasher = $hasher;
        $this->headers = $headers;
        $this->request = $request;
        $this->response = $response;
        $this->curl = $curl;
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
        
        $this->headers->addHeader(new DateHeader($this->call->getDate()));
        $this->headers->addHeader(new AcceptHeader($this->call->getPath(".", false), $this->configuration->getFormat(), $this->call->getVersion()));
        $this->headers->addHeader(new AcceptLanguageHeader($this->call->getLanguage()));
        
        $serializedBody = $this->normalizer->normalizeForHasher($this->call, $this->headers);
        $hmac = $this->hasher->getHash($serializedBody, $this->configuration->getApiSecret());
        
        $this->headers->addHeader(new XAuthHeader($this->configuration->getCustomerKey(), $this->configuration->getApiKey(), $hmac, $this->call->getNonce()));
    }
    
    protected function call()
    {
        $this->request->setMethod($this->call->getMethod());
        $this->request->setHost($this->call->getRequestUri());
        $this->request->setHeaders($this->headers->getHeaders());
        
        $this->curl->setVerifyPeer($this->configuration->getVerifyPeer());
        $this->curl->send($this->request, $this->response);
        
        var_dump($this->request);
        var_dump($this->response);
        var_dump($this->curl);
    }
    
    protected function parse()
    {
        return 'dummy';
    }
    
}
