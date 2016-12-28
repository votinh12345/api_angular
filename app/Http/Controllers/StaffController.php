<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;

class StaffController extends Controller
{
    //
    
    public function login()
    {
        $input = Request::all();
        print_r($input);die;
        $listPlan = '21212';
        return response()->json($listPlan);
    }
}
