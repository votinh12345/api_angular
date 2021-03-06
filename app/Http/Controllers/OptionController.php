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
    
    public function detail($optPackcode, $optCode){
        $optMst = new OptMst();
        $reason = [];
        $data = $optMst->getDetai($optPackcode, $optCode);
        if (count($data) > 0) {
            $reason = [
                'result' => 1,
                'data' => [
                    'opt_packcode' => $data->opt_packcode,
                    'opt_packname' => $data->opt_packname,
                    'opt_packdesc' => $data->opt_packdesc,
                    'opt_code' => $data->opt_code,
                    'opt_name' => $data->opt_name,
                    'opt_desc' => $data->opt_desc,
                    'opt_flag' => $data->opt_flag,
                    'opt_class' => $data->opt_class,
                    'opt_start_date' => $data->opt_start_date,
                    'opt_end_date' => $data->opt_end_date,
                    'last_upd_user' => $data->last_upd_user,
                    'last_upd_date' => $data->last_upd_date,
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
        if (!isset($data->optPackcodePost) || ($data->optPackcodePost == '')) {
            $reason['optPackcode'] = 'Packcode không được để trống.';
        }

        if (!isset($data->optCodePost) || ($data->optCodePost == '')) {
            $reason['optCode'] = 'optCode không được để trống.';
        }
        if (!isset($reason)) {
            $reason = [
                'result' => 0,
                'reason' => $reason
            ];
        } else {
            try {
                $optionMst = new OptMst();
                $opt = $optionMst::where('opt_packcode', '=', $data->optPackcodePost)->where('opt_code', '=', $data->optCodePost)->delete();
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
