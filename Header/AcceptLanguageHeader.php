<?php

namespace Artack\MxApi\Header;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class AcceptLanguageHeader implements HeaderInterface
{
    
    protected $language;
    
    function __construct($language)
    {
        $this->language = $language;
    }
    
    public function getHeader()
    {
        return $this->language;
    }

    public function getName()
    {
        return 'Accept-Language';
    }
    
}