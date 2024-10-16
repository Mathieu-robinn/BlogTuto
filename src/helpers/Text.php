<?php
namespace App\helpers;

class Text{

    public static function excerpt(string $content, int $limit = 60){
        if(mb_strlen($content) <= $limit){
            return $content;

        }
        $last_space = mb_strpos($content, ' ', $limit);
        return mb_substr($content, 0, $last_space). ' ...' ;     
    }
}