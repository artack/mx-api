<?php

namespace Artack\MxApi\Response;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class ApiResponse implements ApiResponseInterface
{
    
    protected $statusCode;
    protected $statusMessage;
    protected $headers = array();
    protected $content;
    
    function __construct($statusCode, $statusMessage, array $headers, $content)
    {
        $this->statusCode = $statusCode;
        $this->statusMessage = $statusMessage;
        $this->headers = $headers;
        $this->content = $content;
    }
    
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getStatusMessage()
    {
        return $this->statusMessage;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getContent()
    {
        return $this->content;
    }

}