<?php

namespace Artack\MxApi\Response;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
interface ApiResponseInterface
{

    public function getStatusCode();
    public function getStatusMessage();
    public function getHeaders();
    public function getContent();
    public function getData();

}