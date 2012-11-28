<?php

namespace ARTACK\MXAPI\Factory;

use ARTACK\MXAPI\Authenticator\AuthenticatorInterface;
use ARTACK\MXAPI\Randomizer\RandomizerInterface;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
interface FactoryInterface 
{

    static public function buildDateHeader();
    static public function buildAccountTokenHeader($type = AccountTokenHeaderInterface::ACCOUNTTOKENHEADER_DEFAULT_TYPE);
    static public function buildAuthenticator($type = AuthenticatorInterface::AUTHENTICATOR_DEFAULT_TYPE);
    static public function buildRandomizer($type = RandomizerInterface::RANDOMIZER_DEFAULT_TYPE);
    
}