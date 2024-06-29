<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{trafficSignal};

class HomeController extends Controller
{
    //

    function index(){

        $session_id = session()->getId();

        $trafficSignalSetting = trafficSignal::where('session_id', $session_id)->first();

        return view('welcome', compact('trafficSignalSetting'));

    }
}
