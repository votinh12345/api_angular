<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use App\Models\OptMst;

class OptionController extends Controller
{
    //
    
    public function index()
    {
        $reason = [];
        $listOption = [];
        $optList = OptMst::all();
        if (count($optList) > 0) {
            foreach ($optList as $key => $value) {
                $listOption[] = [
                    'opt_packcode' => $value->opt_packcode,
                    'opt_packname' => $value->opt_packname,
                    'opt_packdesc' => $value->opt_packdesc,
                    'opt_code' => $value->opt_code,
                    'opt_name' => $value->opt_name,
                    'opt_desc' => $value->opt_desc,
                    'opt_class' => $value->opt_class,
                    'opt_flag' => $value->opt_flag,
                    'opt_start_date' => $value->opt_start_date,
                    'opt_end_date' => $value->opt_end_date,
                    'last_upd_user' => $value->last_upd_user,
                    'last_upd_date' => $value->last_upd_date
                ];
            }
            $reason = [
                'result' => 1,
                'data' => $listOption
            ];
        } else {
            $reason = [
                'result' => 0,
                'message' => 'Not found data'
            ];
        }
        
        return response()->json($reason);
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
