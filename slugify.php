<?php

function slugify ($string) {
    $string = utf8_encode($string);
    $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);   
    $string = preg_replace('/[^a-z0-9- ]/i', ' ', $string);
    $string = trim($string, ' ');
    $string = str_replace(' ', '-', $string);
    $string = preg_replace("/[\-]+/", '-', $string);
    $string = strtolower($string);

    if (empty($string)) {
        return 'n-a';
    }

    return $string;
}

?>