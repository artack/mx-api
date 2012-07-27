<?php

abstract class Authenticator
{
    protected $debug = false;

    public function getAuthenticationHeader($key, $secret, $nonce, $hAlgo, array $data)
    {
        $data[] = $nonce;

        $hmac = base64_encode(hash_hmac($hAlgo, $this->computeHashBody($data), $secret));

        return sprintf('ApiAccountToken KEY="%s", HMAC="%s", NONCE="%s"', $key, $hmac, $nonce);
    }

    protected function computeHashBody(array $data)
    {
        $hBody = '';
        foreach ($data as $d) {
            if (null !== $d) {
                $hBody .= $d;
            }
        }

        if ($this->debug) {
            var_dump("hash-body", $hBody);
        }

        return $hBody;
    }

    public function getDebug()
    {
        return $this->debug;
    }

    public function setDebug($debug)
    {
        $this->debug = (boolean) $debug;
    }

}
