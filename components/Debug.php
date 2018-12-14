<?php

namespace app\components;

class Debug
{
    public static function debug($value)
    {
        echo "<pre>";
        var_dump($value);
        echo "</pre>";
    }
}