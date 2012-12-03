<?php

namespace Artack\MxApi\Header;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
abstract class MimeTypeHeader implements HeaderInterface
{
    
    protected $vendor = 'mailxpert';
    protected $path;
    protected $format;
    protected $version;
    
    function __construct($path, $format, $version)
    {
        $this->path = $path;
        $this->format = $format;
        $this->version = $version;
    }

    abstract public function getName();
    
    public function getHeader()
    {
        return 'application/vnd.' . $this->vendor . '.' . $this->path . '-v' . $this->version . '+' . $this->format;
    }
    
}