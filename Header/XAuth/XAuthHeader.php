<?php

namespace Artack\MxApi\Header\XAuth;

use Artack\MxApi\Header\HeaderInterface;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class XAuthHeader implements HeaderInterface
{

    protected $customerKey;
    protected $apiKey;
    protected $hmac;
    protected $nonce;

    public function __construct($customerKey, $apiKey, $hmac, $nonce)
    {
        $this->customerKey = $customerKey;
        $this->apiKey = $apiKey;
        $this->hmac = $hmac;
        $this->nonce = $nonce;
    }
    
    public function getName()
    {
        return 'X-Auth';
    }

    public function getHeader()
    {
        return 'ApiAccountToken KEY="'.$this->customerKey.':'.$this->apiKey.'", HMAC="'.$this->hmac.'", NONCE="'.$this->nonce.'"';
    }

}
