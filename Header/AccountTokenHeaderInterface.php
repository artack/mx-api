<?php

namespace ARTACK\MXAPI\Header;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
interface AccountTokenHeaderInterface extends HeaderInterface
{
    
    const ACCOUNTTOKENHEADER_DEFAULT_TYPE = 'ApiAccountToken';
    
    public function setCustomerKey($customerKey);
    public function setApiKey($apiKey);
    public function setHmac($hmac);
    public function setNonce($nonce);
    
}