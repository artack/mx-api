<?php

namespace ARTACK\MXAPI\Header;

use DateTime;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
interface DateHeaderInterface extends HeaderInterface
{
    
    public function setDate(DateTime $date);
    
}