<?php

namespace Artack\MxApi\Request;

use Artack\MxApi\Request\Url;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class Call
{
    
    /**
     * @var Url
     */
    protected $url = null;
    
    protected $method = null;
    protected $path = null;
    protected $ids = null;
    protected $version = null;
    protected $format = null;
    
    protected $language = null;
    protected $body = null;
    
    protected $date = null;
    protected $nonce = null;
    
    /**
     * @param Url $url
     */
    function __construct(Url $url, $format, $version, $language)
    {
        $this->url = $url;
        $this->format = $format;
        $this->version = $version;
        $this->language = $language;
    }

    public function getRequestUri()
    {
        return 'http' . (($this->url->getUseSSL()) ? 's' : '') . '://' . $this->url->getBaseUrl() . '/' . $this->getPath("/", true);
    }
    
    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function getPath($separator, $withIds)
    {
        $newPath = "";
        
        if ($withIds) {
            $pathCount = count($this->path);
            for ($i=0; $i<$pathCount; $i++) {
                $newPath .= $this->path[$i] . $separator . ((isset($this->ids[$i])) ? $this->ids[$i] : '') . $separator;
            }
            
            return rtrim($newPath, '/');
        } else {
            return implode($separator, $this->path);
        }
    }

    /**
     * @param string $path
     * @param array $ids
     */
    public function setPath($path, array $ids)
    {
        $this->path = explode("/", strtolower($path));
        $this->ids = $ids;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function setFormat($format)
    {
        $this->format = $format;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function getNonce()
    {
        return $this->nonce;
    }

    public function setNonce($nonce)
    {
        $this->nonce = $nonce;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
    }

}