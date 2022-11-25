<?php

namespace App\Connections;

class SqlUtils
{

    public static function sql_escape(string $string)
    {
        return str_replace(' ','',$string);
    }
}