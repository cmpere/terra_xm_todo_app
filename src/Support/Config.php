<?php

namespace App\Support;

class Config
{
    public static function get()
    {
        return parse_ini_file(__DIR__.'/../../.env', true);
    }
}
