<?php

namespace Artack\MxApi\Headers;

use ArrayAccess;
use Artack\MxApi\Header\HeaderInterface;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class Headers implements HeadersInterface, ArrayAccess
{
    
    public $headers = array();
    
    public function addHeader(HeaderInterface $header)
    {
        $this->headers[$header->getName()] = $header;
    }
    
    public function getHeaders()
    {
        $headers = array();
        
        foreach ($this->headers as /* @var $header HeaderInterface */ $header) {
            $headers[$header->getName()] = $header->getHeader();
        }
        
        return $headers;
    }
    
    public function offsetExists($offset)
    {
        return isset($this->headers[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->headers[$offset]) ? $this->headers[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->headers[] = $value;
        } else {
            $this->headers[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->headers[$offset]);
    }
    
}