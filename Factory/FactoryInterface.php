<?php

namespace MailxpertAPI\Factory;

use MailxpertAPI\Authenticator\AuthenticatorInterface;
use MailxpertAPI\Randomizer\RandomizerInterface;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
interface FactoryInterface 
{
    
    function buildAuthenticator($type = AuthenticatorInterface::AUTHENTICATOR_DEFAULT_TYPE);
    function buildRandomizer($type = RandomizerInterface::RANDOMIZER_DEFAULT_TYPE);
    
}