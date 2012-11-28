<?php

namespace Artack\MxApi\Header;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class ApiAccountTokenHeader implements AccountTokenHeaderInterface
{

    protected $customerKey;
    protected $apiKey;
    protected $hmac;
    protected $nonce;

    public function __construct($customerKey = null, $apiKey = null, $hmac = null, $nonce = null)
    {
        $this->customerKey = ($customerKey) ?: $customerKey;
        $this->apiKey = ($apiKey) ?: $apiKey;
        $this->hmac = ($hmac) ?: $hmac;
        $this->nonce = ($nonce) ?: $nonce;
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function setCustomerKey($customerKey)
    {
        $this->customerKey = $customerKey;
    }

    public function setHmac($hmac)
    {
        $this->hmac = $hmac;
    }

    public function setNonce($nonce)
    {
        $this->nonce = $nonce;
    }

    public function getHeader()
    {
        return 'ApiAccountToken KEY="'.$this->customerKey.':'.$this->apiKey.'", HMAC="'.$this->hmac.'", NONCE="'.$this->nonce.'"';
    }

}
