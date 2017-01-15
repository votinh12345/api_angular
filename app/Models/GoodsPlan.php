<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class GoodsPlan extends Model
{
    //
    
    protected $table = 'goods_plan';
    
    public function getListPlan($goodsJan){
        $textPlan = '';
        $query = DB::table('goods_plan')
                ->join('plan_mst', 'goods_plan.plan_code', '=' , 'plan_mst.plan_code')
                ->select('plan_mst.plan_name')
                ->where('goods_plan.goods_jan', $goodsJan)->get();
        if (count($query) > 0) {
            foreach ($query as $key => $value) {
                $textPlan .= $value->plan_name . '<br/>';
            }
        }
        return $textPlan;
    }
}
