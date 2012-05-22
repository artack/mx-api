<?php

namespace MailxpertAPI\Transport;

use MailxpertAPI\Authenticator\AuthenticatorInterface;
use MailxpertAPI\Parser\ParserInterface;
use MailxpertAPI\Randomizer\RandomizerInterface;

abstract class Transport
{

    protected $dateTimeZoneDefault = "Europe/Zurich";
    protected $dateTimeZone = null;
    protected $randomLength = 32;
    protected $baseURL = null;
    protected $useSSL = true;
    protected $SSLVerifyPeer = true;
    protected $version = null;
    protected $format = 'json';
    protected $language = 'en';
    protected $key = null;
    protected $secret = null;
    protected $headers = null;

    protected $possibleMethod = array(
        'GET',
        'POST',
        'PUT',
        'PATCH',
        'DELETE'
    );

    protected $request;
    protected $method;
    protected $formattedBody;
    protected $date;

    protected $dateFormat = \DateTime::RFC1123;

    protected $mimeTypes = array(
        'xml'   => 'text/xml',
        'json'  => 'application/json'
    );

    protected $authenticator = null;
    protected $parser = null;
    protected $randomizer = null;
    protected $debug = false;

    function __construct()
    {
        $this->dateTimeZone = new \DateTimeZone($this->dateTimeZoneDefault);
    }

    /*
     * INTERNALS
     */
    public function executeRequest($path, $action, $body)
    {
        $this->prepareHeaders();

        $this->method = strtoupper($action);

        if (!$this->isKnownMethod($this->method))
        {
            $this->method = "POST";
        }

        if($this->method != 'GET')
        {
            $this->formattedBody = $this->parser->encode($body);
            $this->addHeader('Content-Length', strlen($this->formattedBody));
        }
        else
        {
            $this->formattedBody = null;
        }

        $this->request = $this->buildBaseURL() . $path;

        $this->date = new \DateTime("now", $this->dateTimeZone);
        $this->addHeader('Date', $this->date->format($this->dateFormat));

        $hashContent = array(
            $this->method,
            $this->request,
            $this->mimeTypes[$this->format],
            $this->formattedBody,
            $this->date->format($this->dateFormat)
        );
        $this->addHeader('X-Auth', $this->authenticator->buildAuthenticationHeader($this->key, $this->secret, $this->randomizer->getRandom($this->randomLength), $hashContent));
    }

    protected function decodeResult($result)
    {
        return $this->parser->decode($result);
    }

    protected function buildBaseURL()
    {
        return 'http'.(($this->useSSL) ? 's' : '').'://'.$this->baseURL.'/api'.(($this->version) ? '-'.$this->version : '').'/';
    }

    protected function prepareHeaders()
    {
        $this->headers = array(
            'Content-Type'      => $this->mimeTypes[$this->format].'; charset=utf-8',
            'Accept'            => $this->mimeTypes[$this->format],
            'Accept-Language'   => $this->language.(($this->language != 'en') ? ', en;q=0.4' : ''),
            'Accept-Charset'    => 'utf-8'
        );
    }

    public function isKnownMethod($method)
    {
        return in_array(strtoupper($method), $this->possibleMethod);
    }

    public function getHeaderForHTTP()
    {
        $headers = array();
        foreach ($this->headers as $key => $value)
        {
            $headers[] = $key.': '.$value;
        }
        return $headers;
    }

    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    public function replaceHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }


    /*
     * SETTERS
     */
    public function setAuthenticator(AuthenticatorInterface $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    public function setRandomizer(RandomizerInterface $randomizer)
    {
        $this->randomizer = $randomizer;
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public function setKey($key)
    {
        $this->key = $key;
    }

    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    public function setBaseURL($baseURL)
    {
        $this->baseURL = $baseURL;
    }

    public function setUseSSL($useSSL)
    {
        $this->useSSL = (boolean) $useSSL;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function setDebug($debug)
    {
        $this->debug = (boolean) $debug;
    }

    public function setSSLVerifyPeer($SSLVerifyPeer)
    {
        $this->SSLVerifyPeer = (boolean) $SSLVerifyPeer;
    }

    public function setParser(ParserInterface $parser)
    {
        $this->parser = $parser;
        $this->format = strtolower(substr(strrchr(get_class($this->parser), '\\'), 1));
    }


    /*
     * GETTERS
     */
    public function getAuthenticator()
    {
        return $this->authenticator;
    }

    public function getParser()
    {
        return $this->parser;
    }

    public function getRandomizer()
    {
        return $this->randomizer;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function getBaseURL()
    {
        return $this->baseURL;
    }

    public function getUseSSL()
    {
        return $this->useSSL;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getSecret()
    {
        return $this->secret;
    }

    public function getSSLVerifyPeer()
    {
        return $this->SSLVerifyPeer;
    }

    public function getDebug()
    {
        return $this->debug;
    }


}