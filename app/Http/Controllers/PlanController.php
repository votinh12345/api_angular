<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
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
    
    public function detail($planCode){
        $planMst = new PlanMst();
        $reason = [];
        $data = $planMst->getDetai($planCode);
        if (count($data) > 0) {
            $reason = [
                'result' => 1,
                'data' => [
                    'plan_code' => $data->plan_code,
                    'plan_name' => $data->plan_name,
                    'plan_desc' => $data->plan_desc,
                    'plan_class' => $data->plan_class,
                    'plan_initial_dis' => $data->plan_initial_dis,
                    'plan_start_date' => $data->plan_start_date,
                    'plan_end_date' => $data->plan_end_date,
                    'plan_type' => $data->plan_type,
                    'plan_last_upd_user' => $data->plan_last_upd_user,
                    'plan_last_upd_date' => $data->plan_last_upd_date,
                ]
            ];
        } else {
            $reason = [
                'result' => 0,
                'message' => 'Not found data'
            ];
        }
        return response()->json($reason);
    }
    
    
    public function delete(){
        $reason = [];
        $data = Request::all();
        $data = json_decode($data['dataPost']);
        //check param
        if (!isset($data)) {
            $reason = [
                'result' => 0,
                'message' => 'Vui lòng truyền plan code!'
            ];
        } else {
            try {
                $planMst = new PlanMst();
                $plan = $planMst::where('plan_code', '=', $data)->delete();
                $reason = [
                    'result' => 1
                ];
            } catch (Exception $ex) {
                 $reason = [
                    'result' => 0,
                    'message' => $ex->getMessage ()
                ];
            }
        }
        
        return response()->json($reason);
    }
}
