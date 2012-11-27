<?php

namespace MailxpertAPI\Authenticator;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
interface AuthenticatorInterface
{

    const AUTHENTICATOR_DEFAULT_TYPE = 'HMAC';

    public function buildAuthenticationHeader($key, $secret, $nonce, array $data);

}
