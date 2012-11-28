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

    protected static $classNamespace = '\\Artack\MxApi\\';

    /**
     * @return DateHeaderInterface
     */
    public static function buildDateHeader()
    {
        $buildClass = 'Header\\Date\\DateHeader';

        return static::load($buildClass);
    }

    /**
     * @param  string                      $type
     * @return AccountTokenHeaderInterface
     */
    public static function buildXAuthHeader()
    {
        $buildClass = 'Header\\XAuth\\XAuthHeader';

        return static::load($buildClass);
    }

    /**
     * @param  string                 $type
     * @return AuthenticatorInterface
     */
    public static function buildAuthenticator($type = AuthenticatorInterface::AUTHENTICATOR_DEFAULT_TYPE)
    {
        $buildClass = 'Authenticator\\' . $type . 'Authenticator';

        return static::load($buildClass);
    }

    /**
     * @param  string              $type
     * @return RandomizerInterface
     */
    public static function buildRandomizer($type = RandomizerInterface::RANDOMIZER_DEFAULT_TYPE)
    {
        $buildClass = 'Randomizer\\' . $type . 'Randomizer';

        return static::load($buildClass);
    }

    /**
     * @param  string    $buildClass
     * @return object
     * @throws Exception
     */
    protected static function load($class)
    {
        $buildClass = static::$classNamespace . $class;
        if (!class_exists($buildClass)) {
            throw new Exception(sprintf("Class [%s] not found", $buildClass));
        }

        return new $buildClass;
    }

}
