<?php

namespace Artack\MxApi\Authenticator;

use Artack\MxApi\Request\Call;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
interface AuthenticatorInterface
{

    public function getSerializedBody(Call $call);

}
