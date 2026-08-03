<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $pattern = [
        'email'  => "/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/",
        'number' => "/[0-9]/",
        'name'   => "/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/",
        'image'  => "jpeg,jpg,png,webp,bmp,tiff,svg",
    ];

    /**
     * resources\views\dashboard
     * Dashboard Dir Prefix
     * Don't Forget Do Not Remove '.' Very Important
     */
    public function pathPrefix()
    {
        /**
         * pathPrefix() Function In \app\Helpers\helpers-admin.php
         */
        return pathPrefix();

    }


    /**
     * Return Admin Auth ID
     */
    protected function adminId()
    {
        // getAuth() => helper function from helpers_admin.php
        return adminId();
    }
}
