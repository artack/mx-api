<?php

namespace MailxpertAPI\Parser;

interface ParserInterface
{

    public function encode($data);

    public function decode($data);

}
