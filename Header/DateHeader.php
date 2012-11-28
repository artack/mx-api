<?php

namespace Artack\MxApi\Header;

use DateTime;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class DateHeader implements DateHeaderInterface
{
    
    protected $date;
    
    function __construct(DateTime $date = null)
    {
        if (null === $date)
        {
            $this->date = new DateTime();
        }
    }

    
    public function setDate(DateTime $date)
    {
        $this->date = $date;
    }
    
    public function getHeader()
    {
        return $this->date->format(DateTime::RFC2822);
    }

}