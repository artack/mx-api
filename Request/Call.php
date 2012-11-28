<?php

namespace Artack\MxApi\Request;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class Call
{
    
    /**
     * @var Url
     */
    protected $url = null;
    
    protected $method = null;
    protected $format = null;
    protected $body = null;
    protected $date = null;
    protected $nonce = null;
    
    function __construct(Url $url)
    {
        $this->url = $url;
    }

    public function getRequestUrl()
    {
        return 'http' . (($this->useSSL) ? 's' : '') . '://' . $this->baseUrl . '/api-' . $this->apiVersion . '/' . $this->url->entity . (($this->format) ? '.' . $this->format : '');
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function setFormat($format)
    {
        $this->format = $format;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getNonce()
    {
        return $this->nonce;
    }

    public function setNonce($nonce)
    {
        $this->nonce = $nonce;
    }

}