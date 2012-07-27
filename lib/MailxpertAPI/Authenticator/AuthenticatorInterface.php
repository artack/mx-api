<?php

interface AuthenticatorInterface
{

    public function buildAuthenticationHeader($key, $secret, $nonce, array $data);

}
