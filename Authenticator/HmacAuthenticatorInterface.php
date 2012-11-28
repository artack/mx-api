<?php

namespace ARTACK\MXAPI\Authenticator;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
interface HmacAuthenticatorInterface extends AuthenticatorInterface
{
    
    public function setAlgorithm($algorithm);
    
}