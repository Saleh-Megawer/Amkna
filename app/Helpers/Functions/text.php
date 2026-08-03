<?php

use Illuminate\Support\Str;

/**
 * |
 * | Text Functions
 * |
 */
function textCapitalize($text)
{
    return Str::headline($text);
}



/**
 * Create Text To Slug
 * 1- Remove All (-) IF Isset In The Text
 * 2- String To Lower Case
 * 3- IF Have Space In Text Replace to (-)
 **/
function slug($text, $separator = '-')
{

    $patterns = [' ','!','`' ,'~', '@', '#', '$', '%', '^', '&', '*', '(', ')', '_', '-', '+', '=', '{', '}', '[', ']', '\\', '|', '\'', '"', ';', ':', '/', '?', '>', '.', '<', ','];

    foreach ($patterns as $key) {
        $text =  str_replace($key, $separator, $text);
    }
    $explode = explode($separator, $text);
    $valuesArray = [];
    foreach ($explode as $val) {
        if ($val != null) {
            array_push($valuesArray, $val);
        }
    }
    $text = implode($separator, $valuesArray);

    return strtolower($text);
}
