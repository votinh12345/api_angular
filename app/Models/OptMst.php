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
}
