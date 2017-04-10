<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class DataMachineRunLog extends Model
{
    protected $table = "data_machine_run_log";
    public $timestamps = false;
    protected $fillable  = ['id','run_id','machine_num','user_id','subject_id','course_id','start_time','end_time','error_num','error_type','log_type','src_type','created_at','is_del'];

    public function getColumns($input)
    {
        $tableColumns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        return $tableColumns;
    }
}
