<?php
namespace App\Helper;

class CommonHelper{
    static public function getRandomEnumCase($cases)
    {
        $count = count($cases) - 1;
        return $cases[rand(0, $count)];
    }
}
