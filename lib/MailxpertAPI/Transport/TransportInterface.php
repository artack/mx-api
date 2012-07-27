<?php

namespace MailxpertAPI\Transport;

interface TransportInterface
{

    public function executeRequest($request, $action, $body);

}
