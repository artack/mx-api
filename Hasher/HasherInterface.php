<?php

namespace Artack\MxApi\Hasher;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
interface HasherInterface
{

    public function getHash($data, $key);

}
