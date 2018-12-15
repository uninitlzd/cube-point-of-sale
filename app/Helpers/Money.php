<?php

namespace App\Helpers;

class Money
{
    public static function round(int $n)
    {
        return ($n % 100 > 50) ? ($n - $n % 100) + 100 : ($n - $n % 100);
    }
}
