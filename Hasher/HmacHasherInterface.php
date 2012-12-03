<?php

namespace Artack\MxApi\Hasher;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
interface HmacHasherInterface extends HasherInterface
{

    public function setAlgorithm($algorithm);
    
}