<?php

namespace MailxpertAPI\Factory;

use MailxpertAPI\Authenticator\AuthenticatorInterface;
use MailxpertAPI\Randomizer\RandomizerInterface;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class Factory implements FactoryInterface
{
    
    static public function buildAuthenticator($type = AuthenticatorInterface::AUTHENTICATOR_DEFAULT_TYPE) {
        $buildClass = '\\MailxpertAPI\\Authenticator\\' . $type . 'Authenticator';
        
        return static::load($buildClass);
    }

    static public function buildRandomizer($type = RandomizerInterface::RANDOMIZER_DEFAULT_TYPE) {
        $buildClass = '\\MailxpertAPI\\Randomizer\\' . $type . 'Randomizer';
        
        return static::load($buildClass);
    }
    
    static protected function load($buildClass)
    {
        if (!class_exists($buildClass))
        {
            throw new \Exception(sprintf("Class [%s] not found", $buildClass));
        }
        
        return new $buildClass;
    }
    
}