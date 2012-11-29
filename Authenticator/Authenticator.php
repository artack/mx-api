<?php

namespace Artack\MxApi\Authenticator;

use Artack\MxApi\Request\Call;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class Authenticator implements AuthenticatorInterface
{
    
    public function getSerializedBody(Call $call)
    {
        return serialize($call->getBody());
    }
    
}