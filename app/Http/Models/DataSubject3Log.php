<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class DataSubject3Log extends Model
{
    protected $table = "data_subject3_log";
    protected $fillable  = ['id','run_id','machine_num','user_id','subject_id','course_id','start_time','error_type','log_type','src_type','created_at','is_del'];

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

    /**
     * 获取一次练习的统计数据
     *@param  String run_id
     * @return Array
     */
    public function getSubject3RunDataByRunId($run_id,$course_num)
    {
        $start_time = 0;//练习开始时间
        $end_time = 0;//练习结束时间
        $score = 0;//累计扣分
        $out_flag = 1;//是否通过计数
        $error_num = 0;//总错误次数
        $error_perfect_num = 0;//不合格错误次数
        $course_score_list = (new CourseAdvice())->getScoreList();
        $dataSubject3LogList = DataSubject3Log::where('run_id',$run_id)->where('course_num',$course_num)->get()->toArray();
        foreach ($dataSubject3LogList as $dataSubject3Log){
            if($dataSubject3Log['log_type'] == "1"){
                $subject3['start_time'] = $dataSubject3Log['start_time'];
                $start_time = $dataSubject3Log['start_time'];
            }elseif ($dataSubject3Log['log_type'] == "2"){
                $end_time = $dataSubject3Log['start_time'];
            }else{
                $error_num++;
                if(isset($course_score_list[$dataSubject3Log['error_type']])){
                    $error_type_score = $course_score_list[$dataSubject3Log['error_type']];
                    if($error_type_score > 0){
                        $score += $course_score_list[$dataSubject3Log['error_type']];
                    }else{
                        $out_flag = 0;
                        $error_perfect_num++;
                    }
                }
            }
        }
        if($score > 20){
            $out_flag = 0;
        }
        return ['out_flag'=>$out_flag,'error_num'=>$error_num,'error_perfect_num'=>$error_perfect_num,'score'=>$score,'start_time'=>$start_time,'train_time'=>$end_time - $start_time];
    }
}
