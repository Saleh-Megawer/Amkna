<?php

use Illuminate\Support\Facades\Auth;


function userPrefix()
{
    return 'u';
}

function userUrl($url)
{
    return url(userPrefix() . "/" . $url);
}

/**
 * Dashboard Auth Info
 */
function userGuardName()
{
    return 'user';
}
function userAuth($get)
{
    if (Auth::guard(userGuardName())->check()) {
        return auth(userGuardName())->user()->$get;
    } else {
        return NULL;
    }
}

/**
 * check if have auth
 */
function haveAuth()
{
    if (Auth::guard(userGuardName())->check()) {
        return true;
    } else {
        return false;
    }
}


/**
 * user Auth ID
 */
function userId()
{
    return userAuth('id');
}
