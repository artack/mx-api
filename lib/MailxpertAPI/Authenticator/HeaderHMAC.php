<?php

namespace MailxpertAPI\Authenticator;

class HeaderHMAC extends Authenticator implements AuthenticatorInterface
{

    private $hAlgo = 'sha256';

    public function buildAuthenticationHeader($key, $secret, $nonce, array $data)
    {
        return parent::getAuthenticationHeader($key, $secret, $nonce, $this->hAlgo, $data);
    }

}
