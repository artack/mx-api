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
use Artack\MxApi\Response\Response;
use Buzz\Client\ClientInterface;
use Buzz\Message\RequestInterface;
use DateTime;
use Exception;

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
     * @var Response
     */
    protected $response;
    
    /**
     * @var ClientInterface
     */
    protected $client;
    
    public function __construct(Configuration $configuration, RandomizerInterface $randomizer, NormalizerInterface $normalizer, HasherInterface $hasher, HeadersInterface $headers, RequestInterface $request, Response $response, ClientInterface $client)
    {
        $this->configuration = $configuration;
        $this->randomizer = $randomizer;
        $this->normalizer = $normalizer;
        $this->hasher = $hasher;
        $this->headers = $headers;
        $this->request = $request;
        $this->response = $response;
        $this->client = $client;
    }
    
    public function dispatch(Call $call)
    {
        $this->call = $call;
        
        $this->prepare();
        $this->call();
        $this->parse();
        
        return $this->return;
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
        
        $this->client->setIgnoreErrors(true);
        $this->client->setVerifyPeer($this->configuration->getVerifyPeer());
        $this->client->send($this->request, $this->response);
    }
    
    protected function parse()
    {
        var_dump($this->request);
        var_dump($this->response);
        
        if ($this->response->isForbidden())
        {
            throw new Exception(sprintf("API call forbidden - statuscode [%s] with message [%s]", $this->response->getStatusCode(), $this->response->getReasonPhrase()));
        }
        
        $this->return = $this->response->getContent();
    }
    
}
