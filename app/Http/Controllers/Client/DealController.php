<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class DealController extends Controller
{

    public function index()
    {

        $pageTitle = __('client.aside.deals');

        $deals = client()->deals()->with(['propertyType'])->latest()->get();

        return view('clients.deals', compact('pageTitle', 'deals'));
    }

}
