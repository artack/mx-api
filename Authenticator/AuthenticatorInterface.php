<?php

namespace MailxpertAPI\Authenticator;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
interface AuthenticatorInterface 
{
    
    public function computeDataHash();
    
}