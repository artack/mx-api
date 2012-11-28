<?php

namespace Artack\MxApi\Hasher;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class HmacHasher implements HmacHasherInterface
{

    protected $algorithm = "sha256";
    protected $data;
    protected $key;

    public function setAlgorithm($algorithm)
    {
        $this->algorithm = $algorithm;
    }

    public function getHash($data, $key)
    {
        return hash_hmac($this->algorithm, $data, $key);
    }

}
