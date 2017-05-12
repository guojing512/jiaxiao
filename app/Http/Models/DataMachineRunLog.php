<?php

namespace App\Http\Models;

use App\Helpers\SessionHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class DataMachineRunLog extends Model
{
    protected $table = "data_machine_run_log";
    protected $fillable  = ['id','run_id','machine_num','user_id','subject_id','course_id','start_time','end_time','course_num','error_num','error_type','log_type','src_type','created_at','is_del'];

    /**
     * 添加设备运行日志
     * @return array
     */
    public function setRunLog()
    {
        $input = $this->setRunLogInput();
        if($input['subject_id'] == '2'){
            //设备开启
            if($input['log_type']  == '1'){
                //设置课程session 记录课程练习次数
                $courseRumNum = ['course'=>['course_1'=>0,'course_2'=>0,'course_3'=>0,'course_4'=>0,'course_5'=>0],'subject3'=>0];
                session(['runLog' => $courseRumNum]);
                $retrun_arr = $this->start($input);
            //设备关闭
            }else if($input['log_type']  == '2'){
                $retrun_arr = $this->end($input);
            //添加操作数据
            }else{
                $retrun_arr = $this->addSubject2Log($input);
            }
        }elseif ($input['subject_id'] == '3'){
            $retrun_arr = $this->addSubject3Log($input);
        }else{
            $retrun_arr = ['status'=>false,'code'=>0,'message'=>"参数错误"];
        }

        return $retrun_arr;
    }
    /**
     * 添加设备运行日志，科目二
     * * @param array  $input post数组
     * @return array
     */
    public function addSubject2Log($input){
        $dataMachineRunLog = new self($input);
        $dataMachineRunLog->end_time = 0;//课程练习结束时的用时长度,只在课程结束时计算
        DB::beginTransaction();
        try{
            $prev_error_num = 0;
            $prev = DataMachineRunLog::where('run_id',$input['run_id'])
                ->where('subject_id',$input['subject_id'])
                ->where('course_id',$input['course_id'])
                ->orderBy('id', 'desc')
                ->first();
            if($prev){
                $prev_error_num = $prev->error_num;
            }
            $sessionRunLog = session('runLog');
            if(!$sessionRunLog){
                return ['status'=>false,'code'=>$input['log_type'],'message'=>"记录课程运行次数出错"];
            }
            //log_type为8时表示通过，此时通过$prev_error_num判断通过状态
            //$prev_error_num=0完美通过，$prev_error_num=1一次错误通过,$prev_error_num>1多次错误通过
            if($input['log_type'] == "8"){
                if($prev_error_num == 0){
                    $dataMachineRunLog->log_type = 3;
                }elseif ($prev_error_num == 1){
                    $dataMachineRunLog->log_type = 4;
                }else{
                    $dataMachineRunLog->log_type = 5;
                }
                $dataMachineRunLog->course_num = $sessionRunLog['course']['course_'.$dataMachineRunLog->course_id];
                $dataMachineRunLog->error_num =  $prev_error_num;

            //log_type为7时错误，此时累计错误次数error_num
            }else if($input['log_type'] == "7"){
                $dataMachineRunLog->course_num = $sessionRunLog['course']['course_'.$dataMachineRunLog->course_id];
                $dataMachineRunLog->error_num =  $prev_error_num + 1;
            //log_type为6时表示放弃，此时只记录以前错误次数error_num
            }else if($input['log_type'] == "6"){
                $dataMachineRunLog->course_num = $sessionRunLog['course']['course_'.$dataMachineRunLog->course_id];
                $dataMachineRunLog->error_num =  $prev_error_num;
            }else if($input['log_type'] == "9" ){//如果是课程开始，跟新session中课程成练习次数，并给要添加的数据加上此项
                $sessionRunLog['course']['course_'.$dataMachineRunLog->course_id] = $sessionRunLog['course']['course_'.$dataMachineRunLog->course_id] + 1;
                session(['runLog' => $sessionRunLog]);
                $dataMachineRunLog->course_num = $sessionRunLog['course']['course_'.$dataMachineRunLog->course_id];
            }else if($input['log_type'] == "10"){//如果是课程结束，查询课程练习时间，赋值给要插入的日志
                $dataMachineRunLog->course_num = $sessionRunLog['course']['course_'.$dataMachineRunLog->course_id];
                $prevRunLog = DataMachineRunLog::where('run_id',$dataMachineRunLog->run_id)
                    ->where('course_id',$dataMachineRunLog->course_id)
                    ->where('course_num',$dataMachineRunLog->course_num)
                    ->where('log_type',9)
                    ->first();
                $dataMachineRunLog->end_time =  $dataMachineRunLog->start_time - $prevRunLog->start_time;//练习时间
            }

            $saveDataMachineRunLog = $dataMachineRunLog->save();
            if(!$saveDataMachineRunLog){
                throw new \Exception('日志添加出现未知错误',$input['log_type']);
            }

            $dataUserSubject2 = new DataUserSubject2();
            $updateDataUserSubject2 = $dataUserSubject2->runLogUpdate($dataMachineRunLog);
            if(!$updateDataUserSubject2['status']){
                throw new \Exception($updateDataUserSubject2['message'],$input['log_type']);
            }
            DB::commit();
            return ['status'=>true,'code'=>$input['log_type'],'message'=>"Success"];
        }catch (\Exception $e){
            DB::rollBack();
            return ['status'=>false,'code'=>$e->getCode(),'message'=>$e->getMessage()];
        }
    }
    /**
     * 添加设备运行日志，科目三
     * * @param array  $input post数组
     * @return array
     */
    public function addSubject3Log($input){
        $dataSubject3Log = new DataSubject3Log($input);
        $sessionRunLog = session('runLog');//获取session中的runLog数据
        if(!$sessionRunLog){
            return ['status'=>false,'code'=>120,'message'=>"记录课程运行次数出错"];
        }
        //如果为课程开始，取出session中存储的练习次数 + 1赋值给要存储的日志,其余的直接赋值给日志，不用 + 1
        if($input['log_type'] == "1"){
            $sessionRunLog['subject3'] = $sessionRunLog['subject3'] + 1;
            session(['runLog' => $sessionRunLog]);
            $dataSubject3Log->course_num = $sessionRunLog['subject3'];
        }elseif($input['log_type'] == "2"){
            $dataSubject3Log->course_num = $sessionRunLog['subject3'];
            $prevRunLog = DataSubject3Log::where('run_id',$dataSubject3Log->run_id)
                ->where('course_id',$dataSubject3Log->course_id)
                ->where('course_num',$dataSubject3Log->course_num)
                ->where('log_type',1)
                ->first();
            $dataSubject3Log->end_time =  $dataSubject3Log->start_time - $prevRunLog->start_time;//练习时间
        }else{
            $dataSubject3Log->course_num = $sessionRunLog['subject3'];
        }
        DB::beginTransaction();
        try{
            $saveDataSubject3Log = $dataSubject3Log->save();
            if(!$saveDataSubject3Log){
                throw new \Exception('科目三日志出现未知错误',3);
            }
            $dataUserSubject3 = new DataUserSubject3();
            $updateDataUserSubject3 = $dataUserSubject3->runLogUpdate($dataSubject3Log);
            if(!$updateDataUserSubject3){
                throw new \Exception('科目三跟新统计表出现未知错误',$input['log_type']);
            }
            DB::commit();
            return ['status'=>true,'code'=>$input['log_type'],'msg'=>"Success"];
        }catch (\Exception $e){
            DB::rollBack();
            return ['status'=>false,'code'=>$e->getCode(),'msg'=>$e->getMessage()];
        }
    }
    /**
     * 添加设备运行日志，设备开启
     * @return array
     */
    public function start($input){
        $dataMachineRunLog = new self($input);
        DB::beginTransaction();
        try{
            $dataMachineRun = new DataMachineRun($input);
            $saveDataMachineRun = $dataMachineRun->save();
            if(!$saveDataMachineRun){
                throw new \Exception('设备开启时插入设备运行表出现未知错误',$input['log_type']);
            }
            $save = $dataMachineRunLog->save();
            if(!$save){
                throw new \Exception('设备开启时插入设备日志表出现未知错误',$input['log_type']);
            }
            DB::commit();
            return ['status'=>true,'code'=>$input['log_type'],'msg'=>'success'];
        }catch (\Exception $exception){
            DB::rollBack();
            return ['status'=>false,'code'=>$input['log_type'],'msg'=>$exception->getMessage()];
        }
    }
    /**
     * 添加设备运行日志，设备关闭
     * @return array
     */
    public function end($input){
        $dataMachineRunLog = new self($input);
        DB::beginTransaction();
        try{
            $updateDataMachineRun = DataMachineRun::where("run_id",$input['run_id'])->update(['end_time'=>$input['start_time']]);
            if(!$updateDataMachineRun){
                throw new \Exception('设备关闭时跟新设备日志表出现未知错误',$input['log_type']);
            }
            $save = $dataMachineRunLog->save();
            if(!$save){
                throw new \Exception('设备关闭时插入设备日志表出现未知错误',$input['log_type']);
            }

            $updateUserExt = UserExt::runLogSendUpdate($input['run_id'],$input['user_id']);
            if (!$updateUserExt) {
                throw new \Exception('设备关闭时跟新用户时长出现未知错误',$input['log_type']);
            }
            DB::commit();
            return ['status'=>true,'code'=>$input['log_type'],'msg'=>'success'];
        }catch (\Exception $exception){
            DB::rollBack();
            return ['status'=>false,'code'=>$input['log_type'],'msg'=>$exception->getMessage()];
        }
    }

    /**
     * 设置设备运行日志的完整参数，设备关闭
     * @return array
     */
    public function setRunLogInput()
    {
        $userSession = SessionHelper::getHomeUser();
        $input = Input::all();
        $input['user_id'] = $userSession['id'];
        $input['mac'] = Cookie::get('machine_mac');
        $input['machine_num'] = Cookie::get('machine_num');
        if(isset($input['start_time']) && $input['start_time'] != ''){
            $input['start_time'] = strtotime($input['start_time']);
        }
        return $input;
    }

    public function getColumns($input)
    {
        DB::enableQueryLog();
        $querys = DB::getQueryLog();
        echo '<pre>';
        print_r($querys);
        echo '</pre>';
        $tableColumns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        return $tableColumns;
    }
    /**
     * Update the creation and update timestamps.
     *
     * @return void
     */
    protected function updateTimestamps()
    {
        $time = $this->freshTimestamp();
        if (! $this->exists && ! $this->isDirty(static::CREATED_AT)) {
            $this->setCreatedAt($time);
        }
    }

}
