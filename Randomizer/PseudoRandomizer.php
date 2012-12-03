<?php

namespace Artack\MxApi\Randomizer;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class PseudoRandomizer implements RandomizerInterface
{

    private static $charPool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    public function getRandom($length)
    {
        $charPoolLen = strlen(self::$charPool)-1;
        $random = '';

        for ($i=1; $i<=$length; $i++) {
            $random .= substr(self::$charPool, mt_rand(0, $charPoolLen), 1);
        }

        return $random;
    }

}
