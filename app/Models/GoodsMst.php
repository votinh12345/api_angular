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
    
}
