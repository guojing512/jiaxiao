<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class DataMachineRun extends Model
{
    protected $table = "data_machine_run";
    protected $fillable  = ['id','run_id','machine_num','user_id','start_time','end_time','mac','end_mode','src_type','updated_at','created_at','is_del'];
}
