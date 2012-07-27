<?php

interface TransportInterface
{

    public function executeRequest($request, $action, $body);

}