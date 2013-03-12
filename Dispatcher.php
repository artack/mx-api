<?php

namespace Artack\MxApi;

use Artack\MxApi\Hasher\HasherInterface;
use Artack\MxApi\Header\AcceptHeader;
use Artack\MxApi\Header\AcceptLanguageHeader;
use Artack\MxApi\Header\ContentTypeHeader;
use Artack\MxApi\Header\DateHeader;
use Artack\MxApi\Header\XAuthHeader;
use Artack\MxApi\Headers\HeadersInterface;
use Artack\MxApi\Normalizer\NormalizerInterface;
use Artack\MxApi\Randomizer\RandomizerInterface;
use Artack\MxApi\Request\Call;
use Artack\MxApi\Response\ApiResponse;
use Artack\MxApi\Response\ApiResponseInterface;
use Artack\MxApi\Response\NetworkResponse;
use Buzz\Client\ClientInterface;
use Buzz\Message\RequestInterface;
use DateTime;
use Exception;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Serializer;

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
     * @var NetworkResponse
     */
    protected $response;

    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var ApiResponseInterface
     */
    protected $apiResponse;

    protected $serializer;

    public function __construct(Configuration $configuration, RandomizerInterface $randomizer, NormalizerInterface $normalizer, HasherInterface $hasher, HeadersInterface $headers, RequestInterface $request, NetworkResponse $response, ClientInterface $client)
    {
        $this->configuration = $configuration;
        $this->randomizer = $randomizer;
        $this->normalizer = $normalizer;
        $this->hasher = $hasher;
        $this->headers = $headers;
        $this->request = $request;
        $this->response = $response;
        $this->client = $client;

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $this->serializer = new Serializer(array(), $encoders);;
    }

    public function reset()
    {
        $this->headers->clearHeaders();
        $this->request->setContent("");
        $this->apiResponse = null;
    }

    public function dispatch(Call $call)
    {
        $this->call = $call;

        $this->prepare();
        $this->call();
        $this->parse();

        return $this->apiResponse;
    }

    protected function prepare()
    {
        $this->call->setDate(new DateTime());
        $this->call->setNonce($this->randomizer->getRandom(32));

        if ($this->call->methodHasBody() && count($this->call->getBody()))
        {
            $serializedBody = $this->serializer->encode($this->call->getBody(), $this->call->getFormat());
            $this->call->setFormattedBody($serializedBody);
;
            $this->headers->addHeader(new ContentTypeHeader($this->call->getPath(".", false), $this->configuration->getFormat(), $this->call->getVersion()));
        }

        $this->headers->addHeader(new DateHeader($this->call->getDate()));
        $this->headers->addHeader(new AcceptHeader($this->call->getPath(".", false), $this->configuration->getFormat(), $this->call->getVersion()));
        $this->headers->addHeader(new AcceptLanguageHeader($this->call->getLanguage()));

        $serializedHashData = $this->normalizer->normalizeForHasher($this->call, $this->headers);
        $hmac = $this->hasher->getHash($serializedHashData, $this->configuration->getApiSecret());

        $this->headers->addHeader(new XAuthHeader($this->configuration->getCustomerKey(), $this->configuration->getApiKey(), $hmac, $this->call->getNonce()));
    }

    protected function call()
    {
        $this->request->setMethod($this->call->getMethod());
        $this->request->setHost($this->call->getRequestPartBase());
        $this->request->setResource($this->call->getRequestPartUri());
        $this->request->setHeaders($this->headers->getHeaders());

        if ($this->call->getFormattedBody())
        {
            $this->request->setContent($this->call->getFormattedBody());
        }

        $this->client->setIgnoreErrors(true);
        $this->client->setVerifyPeer($this->configuration->getVerifyPeer());
        $this->client->setMaxRedirects(0);
        $this->client->setTimeout(60);

        $this->client->send($this->request, $this->response);
    }

    protected function parse()
    {
//        var_dump($this->request);
//        var_dump($this->response);

        if ($this->response->isServerError())
        {
            throw new Exception(sprintf("API server error - statuscode [%s] with message [%s] / [%s]", $this->response->getStatusCode(), $this->response->getReasonPhrase(), $this->response->getContent()));
        }

        if ($this->response->isForbidden())
        {
            throw new Exception(sprintf("API call forbidden - statuscode [%s] with message [%s]", $this->response->getStatusCode(), $this->response->getReasonPhrase()));
        }

        $deSerializedBody = "";
        if ($this->response->getContent()) {
            $deSerializedBody = $this->serializer->decode($this->response->getContent(), $this->call->getFormat());
        }

        if(null === $deSerializedBody)
        {
            echo $this->response->getContent();
            throw new \Exception("API response could not deserialize");
        }

        $this->apiResponse = new ApiResponse($this->response->getStatusCode(), $this->response->getReasonPhrase(), $this->response->getHeadersArray(), $deSerializedBody);

        if (isset($deSerializedBody['status']) && $deSerializedBody['status'] != 'success')
        {
             throw new Exception(sprintf("API call error - statuscode [%s] with message [%s] / [%s]", $deSerializedBody['code'], $deSerializedBody['text'], $this->response->getContent()));
        }
    }

    /**
     * @param Configuration $configuration
     */
    public function setConfiguration(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * @return Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

}