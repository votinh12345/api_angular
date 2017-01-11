<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class PlanMst extends Model
{
    //
    protected $table = 'plan_mst';
    
    
    public function getDetai($planCode){
        
        $query = DB::table('plan_mst')->select('plan_mst.*')->where('plan_code', $planCode)->first();
        return $query;
    }
}
