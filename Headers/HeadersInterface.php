<?php

namespace Artack\MxApi\Headers;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
interface HeadersInterface
{

    public function getHeaders();
    public function clearHeaders();

}
