<?php

namespace Artack\MxApi\Header;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class AcceptHeader extends MimeTypeHeader
{
    
    public function getName()
    {
        return 'Accept';
    }
    
}