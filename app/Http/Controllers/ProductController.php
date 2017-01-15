<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Request;
use App\Models\GoodsMst;
use App\Models\GoodsPlan;

class ProductController extends Controller
{
    //
    
    public function index()
    {
        $reason = [];
        $listProduct = [];
        $productList = GoodsMst::all();
        $modelGoodsPlan = new GoodsPlan();
        if (count($productList) > 0) {
            foreach ($productList as $key => $value) {
                $listProduct[] = [
                    'goods_jan' => $value->goods_jan,
                    'goods_name' => $value->goods_name,
                    'plan' => $modelGoodsPlan->getListPlan($value->goods_jan),
                    'last_upd_date' => $value->last_upd_date
                ];
            }
            $reason = [
                'result' => 1,
                'data' => $listProduct
            ];
        } else {
            $reason = [
                'result' => 0,
                'message' => 'Not found data'
            ];
        }
        
        return response()->json($reason);
    }
    
    public function detail($goodsJan){
        $goodsMst = new GoodsMst();
        $modelGoodsPlan = new GoodsPlan();
        $reason = [];
        $data = $goodsMst->getDetai($goodsJan);
        if (count($data) > 0) {
            $reason = [
                'result' => 1,
                'data' => [
                    'goods_jan' => $data->goods_jan,
                    'goods_name' => $data->goods_name,
                    'goods_name2' => $data->goods_name2,
                    'goods_model_id' => $data->goods_model_id,
                    'goods_sim_type' => $data->goods_sim_type,
                    'goods_sim_class' => $data->goods_sim_class,
                    'goods_color' => $data->goods_color,
                    'goods_size' => $data->goods_size,
                    'goods_maker' => $data->goods_maker,
                    'goods_decr' => $data->goods_decr,
                    'goods_last_upd_id' => $data->goods_last_upd_id,
                    'last_upd_date' => $data->last_upd_date,
                    'plan_name' => $modelGoodsPlan->getListPlan($data->goods_jan),
                    'option_name' => $data->goods_last_upd_id,
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
