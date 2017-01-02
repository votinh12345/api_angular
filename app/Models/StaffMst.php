<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffMst extends Model
{
    //
    protected $table = 'staff_mst';
    
    public $timestamps = false;

    protected $fillable = array('auth_key', 'staff_expired_date_key');
}
