<?php

namespace Artack\MxApi\Normalizer;

use Artack\MxApi\Headers\HeadersInterface;
use Artack\MxApi\Request\Call;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class Normalizer implements NormalizerInterface
{

    public function normalizeForHasher(Call $call, HeadersInterface $headers)
    {
        $normalizedData = array();
        
        $normalizedData[] = $call->getMethod();
        $normalizedData[] = $call->getRequestUri();
        $normalizedData[] = $headers['Date']->getHeader();
        $normalizedData[] = $headers['Accept']->getHeader();
        $normalizedData[] = $headers['Accept-Language']->getHeader();
        $normalizedData[] = $call->getNonce();
        $normalizedData[] = $call->getBody();
        
        return implode("", $normalizedData);
    }
    
}