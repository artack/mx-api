<?php

namespace Artack\MxApi\Header;

use DateTime;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class DateHeader implements HeaderInterface
{

    protected $date;

    public function __construct(DateTime $date)
    {
        $this->date = new DateTime();
    }
    
    public function getName()
    {
        return 'Date';
    }

    public function getHeader()
    {
        return $this->date->format(DateTime::RFC2822);
    }

}