<?php


if (!function_exists('pattern')) {

    function pattern(string $pattern)
    {
        $patterns = [
            'email'  => "/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/",
            'number' => "/[0-9]/",
            'name'   => "/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/",
            'url' => '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',

        ];

        if (isset($patterns[$pattern])) {
            return $patterns[$pattern];
        } else {
            return 'Undefined Pattern [ ' . $pattern . ' ] !';
        }
    }
}

if (!function_exists('mimesType')) {

    function mimesType(string $type, $returnAs = 'string')
    {

        $types = [
            'image'  => "jpeg,jpg,png,webp,bmp,tiff,svg,gif",
            'image_accept_resize' => "jpeg,jpg,png,webp,bmp,tiff",
        ];

        // if($returnAs == 'array'){

        // }
        if (isset($types[$type])) {
            return $types[$type];
        } else {
            return 'Undefined Mime Type [ ' . $type . ' ] !';
        }
    }
}


function inValidate(array $entryData = [], $key = 'id', $separator = ',')
{

    $exitData = [];

    foreach ($entryData as $row) {
        array_push($exitData, $row->$key);
    }

    return implode($separator, $exitData);
}

// This Data IF Using "pluck()" method with get data from db
function inValidateByPluck(object $entryData, $separator = ',')
{

    $exitData = [];

    foreach ($entryData as $value) {
        array_push($exitData, $value);
    }

    return implode($separator, $exitData);
}



/**
 * This Function Created For Return All Value As New Array
 * For Check In Validate [ in:$exitData ]
 * use for validate type => ( in: )
 * @param object $entryData
 * @param string $key
 */
function getDataWithImplode($entryData = [], $key = 'id', $separator = ',')
{

    $exitData = [];
    foreach ($entryData as $row) {
        array_push($exitData, $row->$key);
    }

    return implode($separator, $exitData);
}
