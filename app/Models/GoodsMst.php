<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class GoodsMst extends Model
{
    //
    
    protected $table = 'goods_mst';
    
    public function getDetai($goodsJan){
        
        $query = DB::table('goods_mst')->select('goods_mst.*')->where('goods_jan', $goodsJan)->first();
        return $query;
    }
    
    
    public function getListOption($goodsJan, $flag = true)
    {
        $query = new \yii\db\Query();
        $query->select('opt_mst.*, goods_opt.goods_opt_order')
                ->from('goods_opt');
        if ($flag){
            $query->join('INNER JOIN', 'opt_mst', 'goods_opt.goods_opt_packcode = opt_mst.opt_packcode'
                . ' AND goods_opt.goods_opt_code = opt_mst.opt_code');
        } else {
            $query->join('INNER JOIN', 'opt_mst', 'goods_opt.goods_opt_packcode = opt_mst.opt_packcode'
                . ' AND goods_opt.goods_opt_code = opt_mst.opt_code AND'
                . ' ((opt_mst.opt_start_date IS NULL AND opt_mst.opt_end_date IS NULL)'
                . ' OR (opt_mst.opt_start_date = "0000-00-00 00:00:00" AND opt_mst.opt_end_date ="0000-00-00 00:00:00")'
                . ' OR (opt_mst.opt_start_date IS NULL AND opt_mst.opt_end_date ="0000-00-00 00:00:00")'
                . ' OR (opt_mst.opt_end_date IS NULL AND opt_mst.opt_start_date ="0000-00-00 00:00:00")'
                . ' OR (opt_mst.opt_start_date IS NOT NULL AND'
                . ' (opt_mst.opt_end_date IS NULL OR opt_mst.opt_end_date="0000-00-00 00:00:00")'
                . ' AND DATE_FORMAT(opt_mst.opt_start_date,"%Y-%m-%d") <= DATE_FORMAT(NOW(),"%Y-%m-%d"))'
                . ' OR (opt_mst.opt_end_date IS NOT NULL AND'
                . ' (opt_mst.opt_start_date IS NULL OR opt_mst.opt_start_date="0000-00-00 00:00:00")'
                . ' AND DATE_FORMAT(opt_mst.opt_end_date,"%Y-%m-%d") >= DATE_FORMAT(NOW(),"%Y-%m-%d"))'
                . ' OR (DATE_FORMAT(NOW(),"%Y-%m-%d") BETWEEN DATE_FORMAT(opt_mst.opt_start_date,"%Y-%m-%d")'
                . ' AND DATE_FORMAT(opt_mst.opt_end_date,"%Y-%m-%d")))');
        }
        $query->where(['=', 'goods_opt.goods_opt_jan', $goodsJan]);
        $query->orderBy(['goods_opt.goods_opt_order' => SORT_ASC]);
        return $query->all();
    }
}
