<?php

namespace Artack\MxApi\Authenticator;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class HmacAuthenticator implements HmacAuthenticatorInterface
{

    protected $algorithm = "sha256";
    protected $data;
    protected $key;

    public function setAlgorithm($algorithm)
    {
        $this->algorithm = $algorithm;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setKey($key)
    {
        $this->key = $key;
    }

    public function getHash()
    {
        return hash_hmac($this->algorithm, $this->data, $this->key);
    }

}
