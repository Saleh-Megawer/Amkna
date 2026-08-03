<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class InterestController extends Controller
{

    public function index()
    {

        $pageTitle = __('client.aside.interests');

        $interests = client()->interests()->with('property:id,uuid')->latest()->get();

        return view('clients.interests', compact('pageTitle', 'interests'));
    }

}
