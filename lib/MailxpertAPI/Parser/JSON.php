<?php

namespace MailxpertAPI\Parser;

class JSON implements ParserInterface
{

    public function encode($data)
    {
        if (null === $data)
        {
            return '';
        }
        
        return json_encode($data);
    }

    public function decode($data)
    {
        return json_decode($data, true);
    }

}