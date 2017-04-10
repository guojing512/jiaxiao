<?php

namespace App\Http\Controllers\Api;

use App\Http\Models\DataMachineRun;
use App\Http\Models\DataMachineRunLog;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class DataMachineRunLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setRunLog()
    {
        $input = Input::all();
        $saveId = "";
        if(isset($input['start_time']) && $input['start_time'] != ''){
            $input['start_time'] = strtotime($input['start_time']);
        }
        if(isset($input['end_time']) && $input['end_time'] != ''){
            $input['end_time'] = strtotime($input['end_time']);
        }
        $dataMachineRunLog = new DataMachineRunLog($input);
        DB::beginTransaction();
        try{
            if($input['log_type'] == "1"){
                $dataMachineRun = new DataMachineRun($input);
                $dataMachineRun->save();
            }elseif($input['log_type'] == "2"){
                DataMachineRun::where("run_id",$input['run_id'])->update(['end_time'=>$input['end_time']]);
            }else{
                $prev_error_num = 0;
                $prev = DataMachineRunLog::where('run_id',$input['run_id'])
                    ->where('subject_id',$input['subject_id'])
                    ->where('course_id',$input['course_id'])
                    ->orderBy('id', 'desc')
                    ->first();
                if($prev){
                    $prev_error_num = $prev->error_num;
                }
                //log_type为8时表示通过，此时通过error_num判断通过状态
                //error_num=0完美通过，error_num=1一次错误完美通过,error_num=0多次错误完美通过
                if($input['log_type'] == "8"){
                    if($prev_error_num == 0){
                        $dataMachineRunLog->log_type = 3;
                    }elseif ($prev_error_num == 1){
                        $dataMachineRunLog->log_type = 4;
                    }else{
                        $dataMachineRunLog->log_type = 5;
                    }
                    $dataMachineRunLog->error_num =  $prev_error_num;
                //log_type为7时错误，此时累计错误次数error_num
                }else if($input['log_type'] == "7"){
                    $dataMachineRunLog->error_num =  $prev_error_num + 1;
                //log_type为6时表示放弃，此时只记录以前错误次数error_num
                }else if($input['log_type'] == "6"){
                    $dataMachineRunLog->error_num =  $prev_error_num;
                }
            }
            $saveId = $dataMachineRunLog->save();
            DB::commit();
            return response()->json(['status'=>true,'msg'=>'ok','save_id'=>$saveId]);
        }catch (\mysqli_sql_exception $exception){
            return response()->json(['status'=>true,'msg'=>$exception->getMessage(),'save_id'=>'']);
            DB::rollBack();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('api.index');
    }
}
