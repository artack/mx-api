<?php

namespace MailxpertAPI;

use MailxpertAPI\Factory\Factory;
use MailxpertAPI\Factory\FactoryInterface;

/**
 * @author Patrick Landolt <patrick.landolt@artack.ch>
 */
class MailxpertAPI
{

    protected $factory;
    protected $browser;
    protected $coder;
    protected $randomizer;
    
    function __construct(FactoryInterface $factory) {
    
        $this->factory = $factory ?: new Factory();
        
        $this->randomizer = Factory::buildRandomizer();
        var_dump($this->randomizer);
    }
    
}
