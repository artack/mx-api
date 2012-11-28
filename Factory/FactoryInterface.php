<?php

namespace Artack\MxApi\Factory;

use Artack\MxApi\Authenticator\AuthenticatorInterface;
use Artack\MxApi\Randomizer\RandomizerInterface;

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