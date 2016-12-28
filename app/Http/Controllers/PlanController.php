<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlanMst;

class PlanController extends Controller
{
    //
    
    public function index()
    {
        $listPlan = [];
        $planList = PlanMst::all();
        if (count($planList) > 0) {
            foreach ($planList as $key => $value) {
                $listPlan[] = [
                    'plan_code' => $value->plan_code,
                    'plan_name' => $value->plan_name,
                    'plan_last_upd_user' => $value->plan_last_upd_user,
                    'plan_last_upd_date' => $value->plan_last_upd_date,
                ];
            }
        }
        return response()->json($listPlan);
    }
}
