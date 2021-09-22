<?php

namespace App\Services;

class SwearWordCensor
{
    const BADWORDS = ['fuck', 'shit', 'piss', 'cunt', 'ass', 'wank'];

    public function purify($string) :string
    {
        foreach (self::BADWORDS as $badword) {
            $replace = str_repeat("*", mb_strlen($badword));
            $string = str_ireplace($badword, $replace, $string);
        }
        return $string;
    }
}