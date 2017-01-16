<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class OptMst extends Model
{
    //
    protected $table = 'opt_mst';
    
    public function getDetai($optPackcode, $optCode){
        
        $query = DB::table('opt_mst')->select('opt_mst.*')->where('opt_packcode', $optPackcode)->where('opt_code', $optCode)->first();
        return $query;
    }
    
    public static function listOptSpecial(){
        $listOptSpecial = [];
        $query = DB::table('opt_mst')->select('opt_code')->where(['opt_packcode' => '000', 'opt_flag' => 1])->get()->toArray();
        if (count($query) > 0) {
            foreach ($query as $key => $value) {
                $listOptSpecial[] = $value->opt_code;
            }
        }
        return $listOptSpecial;
    }
}
