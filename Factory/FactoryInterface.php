<?php

namespace Artack\MxApi\Factory;

use Artack\MxApi\Authenticator\AuthenticatorInterface;
use Artack\MxApi\Randomizer\RandomizerInterface;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
interface FactoryInterface
{

    public static function buildDateHeader();
    public static function buildAccountTokenHeader($type = AccountTokenHeaderInterface::ACCOUNTTOKENHEADER_DEFAULT_TYPE);
    public static function buildAuthenticator($type = AuthenticatorInterface::AUTHENTICATOR_DEFAULT_TYPE);
    public static function buildRandomizer($type = RandomizerInterface::RANDOMIZER_DEFAULT_TYPE);

}
