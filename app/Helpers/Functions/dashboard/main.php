<?php
require 'auth.php';

/**
 * Admin Prefix URL For Open The Admin Dashboard
 */
function adminPrefix()
{
    return 'admin';
}


/**
 * View Dashboard Path Prefix URL For Open The Admin Dashboard
 */
function pathPrefix()
{
    return 'dashboard' . '.';
}



/**
 * ( NEW ) Admin URL To Get Admin Route Name And Prefix
 */
function adminUrl($url)
{
    return url(adminPrefix() . "/" . $url);
}


/**
 * Get Locale Language
 */

function lang()
{
    return app()->getLocale();
}



/**
 * Function For Set Actives Class To Blade Pages
 * $url = Page Uri
 * $setClassName = If Need Set Other Class Name
 */
function adminActiveLink($url, $setClassName = 'active')
{
    if (request()->path() == adminPrefix() . '/' . $url) {
        return $setClassName;
    } else {
        return false;
    }
}



// /**
//  * tran() Function Return laravel helper function trans() and set the dashboard name dynamic like this
//  * use laravel helper function trans(set file name for example file name is => 'dashboard' + fetch value from this file )
//  * if u change the dashboard.php name any time just come here and change dashboard to => new file name ?
//  * and everything is good now....
//  *
//  * tran() properties $value
//  */
// function tran($value)
// {
//     // Set Translate File Name And Don't Forget Set (.) after file name
//     // File Dir => lang\en\dashboard.php
//     return trans('dashboard.' . $value);
// }

function dbTrans($value)
{
    // Set Translate File Name And Don't Forget Set (.) after file name
    // File Dir => lang\en\dashboard.php
    return textCapitalize(trans('dashboard/' . $value));
}

// function dbTransComponent($value, $headline = true)
// {
//     // Set Translate File Name And Don't Forget Set (.) after file name
//     // File Dir => lang\en\dashboard.php
//     if ($headline == true) {
//         return textCapitalize(trans('dashboard/components/' . $value));
//     } else {
//         return trans('dashboard/components/' . $value);
//     }
// }



/**
 *
 */
// function getPermission(string $key, $separator = '|')
// {
//    return implode($separator, config('roles-and-permissions.' . $key));
// }

function getPermissions(string $role_name)
{
    return config('roles-and-permissions.' . $role_name);
}






