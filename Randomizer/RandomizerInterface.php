<?php

namespace MailxpertAPI\Randomizer;

interface RandomizerInterface
{

    const RANDOM_DEFAULT_TYPE = 'Pseudo';
    
    public function getRandom($length);

}
