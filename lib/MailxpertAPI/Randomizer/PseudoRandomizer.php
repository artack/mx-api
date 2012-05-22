<?php

namespace MailxpertAPI\Randomizer;

class PseudoRandomizer extends Randomizer implements RandomizerInterface
{

    static private $charPool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    public function getRandom($length)
    {
        $charPoolLen = strlen(self::$charPool)-1;
        $random = '';

        for ($i=1; $i<=$length; $i++)
        {
            $random .= substr(self::$charPool, mt_rand(0, $charPoolLen), 1);
        }

        return $random;
    }

}