<?php

namespace Artack\MxApi\Header\Accept;

use Artack\MxApi\Header\HeaderInterface;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class AcceptHeader implements HeaderInterface
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

    public function getName()
    {
        return 'Accept';
    }
    
    public function getHeader()
    {
        return 'application/vnd.' . $this->vendor . '.' . $this->path . '-v' . $this->version . '+' . $this->format;
    }
    
}