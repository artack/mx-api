<?php

namespace Artack\MxApi\Request;

use Artack\MxApi\Request\Url;
use Artack\MxApi\Util\Pluralization;
use Exception;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class Call
{
    
    /**
     * @var Url
     */
    protected $url;
    
    protected $method = null;
    protected $path = null;
    protected $ids = null;
    protected $version = null;
    protected $format = null;
    
    protected $pluralization = true;
    
    protected $language = null;
    protected $body = array();
    protected $settings = array();
    protected $formattedBody = "";
    
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
        return $this->getRequestPartBase() . $this->getRequestPartUri();
    }
    
    public function getRequestPartBase()
    {
        return 'http' . (($this->url->getUseSSL()) ? 's' : '') . '://' . $this->url->getBaseUrl();
    }
    
    public function getRequestPartUri()
    {
        $uri = '/' . $this->getPath("/", true);
        
        if ($this->method == 'GET' && count($this->settings)) {
            $uri .= '?' . http_build_query(array('settings' => $this->settings));
        }
        
        return rtrim($uri, '&');
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
        $newPath = $this->path[0] . $separator;
        
        if ($withIds) {
            $pathCount = count($this->path);
            for ($i=1; $i<$pathCount; $i++) {
                
                $next = $i+1;
                $prev = $i-1;
                
                $entity = $this->path[$i];
                
                if (!(($next) == $pathCount && $this->method == 'POST' && $entity == key($this->getBody())) && $this->pluralization) {
                    $entity = Pluralization::pluralize($entity);
                }
                
                $newPath .= $entity . $separator . ((isset($this->ids[$prev])) ? $this->ids[$prev] : '') . $separator;

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
    
    /**
     * @param boolean $pluralization
     */
    public function setPluralization($pluralization)
    {
        $this->pluralization = $pluralization;
    }
    
    /**
     * @return boolean
     */
    public function getPluralization()
    {
        return $this->pluralization;
    }
    
    /**
     * @param array $settings
     */
    public function setSettings(array $settings)
    {
        $this->settings = $settings;
    }
    
    /**
     * @return array
     */
    public function getSettings()
    {
        return $this->settings;
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

    public function getFormattedBody()
    {
        return $this->formattedBody;
    }

    public function setFormattedBody($formattedBody)
    {
        if (!is_string($formattedBody))
        {
            throw new Exception(sprintf("Paramtere [%s] needs to be a string, [%] given", 'formattedBody', get_class($formattedBody)));
        }
        
        $this->formattedBody = $formattedBody;
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