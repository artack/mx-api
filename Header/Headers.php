<?php

namespace Artack\MxApi\Header;

use Artack\MxApi\Header\HeaderInterface;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class Headers implements HeadersInterface
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
    
}