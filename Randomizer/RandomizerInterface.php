<?php

namespace ARTACK\MXAPI\Randomizer;

interface RandomizerInterface
{

    const RANDOMIZER_DEFAULT_TYPE = 'Pseudo';
    
    public function getRandom($length);

}
