<?php

namespace Artack\MxApi\Authenticator;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
interface AuthenticatorInterface
{

    const AUTHENTICATOR_DEFAULT_TYPE = 'Hmac';

    public function setData($data);
    public function setKey($key);
    public function getHash();

}
