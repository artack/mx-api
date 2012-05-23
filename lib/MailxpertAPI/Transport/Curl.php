<?php

namespace MailxpertAPI\Transport;

class Curl extends Transport implements TransportInterface
{

    function __construct()
    {

        parent::__construct();

        if (!function_exists('curl_init')) {
            throw new Exception('CURL module not available!');
        }

    }

    public function executeRequest($path, $action, $body)
    {
        parent::executeRequest($path, $action, $body);

        if ($this->debug)
        {
            var_dump($this->method, $this->request, $this->headers, $body);
        }

        $cSession = curl_init($this->request);

        if($this->method != 'GET')
        {
            curl_setopt ($cSession, CURLOPT_POSTFIELDS, $this->formattedBody);
            curl_setopt($cSession, CURLOPT_POST, 1);
        }

        if ($this->debug)
        {
            var_dump($this->formattedBody);
        }

        curl_setopt($cSession, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cSession, CURLOPT_HTTPHEADER, $this->getHeaderForHTTP());
//        curl_setopt($cSession, CURLINFO_HEADER_OUT, true);
//        curl_setopt($cSession, CURLOPT_HEADER, true);
        curl_setopt($cSession, CURLOPT_SSL_VERIFYPEER, $this->SSLVerifyPeer);

        $result = curl_exec($cSession);
        $info   = curl_getinfo($cSession);
        $error  = curl_error($cSession);
        $errno  = curl_errno($cSession);
        curl_close($cSession);

        if ($this->debug)
        {
            var_dump($result);
            var_dump($info);
            var_dump($error);
            var_dump($errno);
        }
//        die (var_dump($result));

        return $this->decodeResult($result);
    }

}