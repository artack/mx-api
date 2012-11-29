<?php

namespace Artack\MxApi\Normalizer;

use Artack\MxApi\Headers\HeadersInterface;
use Artack\MxApi\Request\Call;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
interface NormalizerInterface
{
    
    public function normalizeForHasher(Call $call, HeadersInterface $headers);
    
}