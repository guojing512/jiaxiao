<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataUserSubject3 extends Model
{
    protected $table = "data_user_subject3";
    protected $fillable  =  ['user_id','company_id','train_num','pass_num','error_pass_num','error_num','score', 'train_time'];

    public function adminUser()
    {
        return $this->hasOne('App\Http\Models\AdminUser','id','user_id');
    }

    //注册时调用，添加一条空数据
    public function registerAdd($user_id,$company_id)
    {
        $dataUserSubject3 =  new self(['user_id'=>$user_id,'company_id'=>$company_id]);
        return $dataUserSubject3->save();
    }

    //添加设备操作记录时跟新
    public function runLogUpdate(DataSubject3Log $dataSubject3Log){
        $dataUserSubject3 = new self();
        //log_type为1时，表示科目三开始，此时只累加练习次数
        if($dataSubject3Log->log_type == "1"){
            $res = $dataUserSubject3
                ->where(array('user_id'=>$dataSubject3Log->user_id))
                ->update([
                    'train_num' => DB::raw('train_num+1'),
                ]);
            return $res;
        //log_type为2时，表示科目三结束，此时累加练习次数
        }elseif($dataSubject3Log->log_type == "2"){
            $score = 0;//扣除分数
            $pass_num = 1;//通过次数，即本次练习累计扣分<=20
            $error_pass_num = 0;//不合格次数，即本次练习累计扣分>20,或犯错为
            $start_time = 0;//科三训练开始时间
            $end_time = 0;//科三训练结束时间
            //获取错误扣分情况

            $courseAdvice = new CourseAdvice();
            $course_score_list = $courseAdvice->getScoreList();
            //获取本次练习的所有日志
            $prevDataSubject3LogList = DataSubject3Log::whereRun_id($dataSubject3Log->run_id)->where('course_num',$dataSubject3Log->course_num)->get()->toArray();
            foreach ($prevDataSubject3LogList as $key=>$prevDataSubject3Log){
                //如果log_typ为1，记录开始时间
                if($prevDataSubject3Log['log_type'] == "1"){
                    $start_time = $prevDataSubject3Log['start_time'];
                //如果log_typ为2，记录结束时间
                }elseif($prevDataSubject3Log['log_type'] == "2"){
                    $end_time = $prevDataSubject3Log['start_time'];
                //根据扣分情况判断是通过还是不合格，以及累计扣分
                }else{
                    if(isset($course_score_list[$prevDataSubject3Log['error_type']])){
                        $error_type_score = $course_score_list[$prevDataSubject3Log['error_type']];
                        if($error_type_score > 0){
                            $score += $course_score_list[$prevDataSubject3Log['error_type']];
                        }else{
                            $pass_num = 0;
                            $error_pass_num = 1;
                        }
                    }
                }
            }
            if($score > 20){
                $pass_num = 0;
                $error_pass_num = 1;
            }
            //跟新数据库
            $res = $dataUserSubject3
                ->where(array('user_id'=>$dataSubject3Log->user_id))
                ->update([
                    'pass_num' => DB::raw('pass_num+'.$pass_num),
                    'error_pass_num' => DB::raw('error_pass_num+'.$error_pass_num),
                    'train_time' => DB::raw('train_time+'.($end_time - $start_time)),
                    'score' => DB::raw('score+'.$score)
                ]);
            return $res;
        //累计错误次数
        }else{
            $res = $dataUserSubject3
                ->where(array('user_id'=>$dataSubject3Log->user_id))
                ->update([
                    'error_num' => DB::raw('error_num+1'),
                ]);
            return $res;
        }
    }
}
