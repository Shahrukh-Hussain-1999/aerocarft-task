<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\{trafficSignal};


class TrafficLightController extends Controller
{
    //

    function store(Request $request){
        
        $session_id = session()->getId();

        $input = $request->all();

        trafficSignal::updateOrCreate(['session_id'=>$session_id], $input);

        return response()->json(['message'=>'Data Updated Successfully!'], 200);
        
    }

}
