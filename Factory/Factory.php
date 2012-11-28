<?php

namespace Artack\MxApi\Factory;

use Artack\MxApi\Authenticator\AuthenticatorInterface;
use Artack\MxApi\Header\AccountTokenHeaderInterface;
use Artack\MxApi\Header\DateHeaderInterface;
use Artack\MxApi\Randomizer\RandomizerInterface;
use Exception;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class Factory implements FactoryInterface
{
    
    /**
     * @return DateHeaderInterface
     */
    public static function buildDateHeader()
    {
        $buildClass = '\\ARTACK\\MXAPI\\Header\\DateHeader';
        return static::load($buildClass);
    }
    
    /**
     * @param string $type
     * @return AccountTokenHeaderInterface
     */
    public static function buildAccountTokenHeader($type = AccountTokenHeaderInterface::ACCOUNTTOKENHEADER_DEFAULT_TYPE)
    {
        $buildClass = '\\ARTACK\\MXAPI\\Header\\' . $type . 'Header';
        return static::load($buildClass);
    }

    /**
     * @param string $type
     * @return AuthenticatorInterface
     */
    static public function buildAuthenticator($type = AuthenticatorInterface::AUTHENTICATOR_DEFAULT_TYPE) {
        $buildClass = '\\ARTACK\\MXAPI\\Authenticator\\' . $type . 'Authenticator';
        return static::load($buildClass);
    }

    /**
     * @param string $type
     * @return RandomizerInterface
     */
    static public function buildRandomizer($type = RandomizerInterface::RANDOMIZER_DEFAULT_TYPE) {
        $buildClass = '\\ARTACK\\MXAPI\\Randomizer\\' . $type . 'Randomizer';
        return static::load($buildClass);
    }
    
    /**
     * @param string $buildClass
     * @return object
     * @throws Exception
     */
    static protected function load($buildClass)
    {
        if (!class_exists($buildClass))
        {
            throw new Exception(sprintf("Class [%s] not found", $buildClass));
        }
        
        return new $buildClass;
    }
    
}