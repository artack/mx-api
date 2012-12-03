<?php

namespace Artack\MxApi\Header;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class ContentTypeHeader extends MimeTypeHeader
{
    
    public function getName()
    {
        return 'Content-Type';
    }
    
}