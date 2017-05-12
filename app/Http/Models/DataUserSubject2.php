<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataUserSubject2 extends Model
{
    protected $table = "data_user_subject2";
    protected $fillable  =  ['user_id','company_id',
        'course_id_1','perfect_pass_num_1','error_one_pass_num_1','error_more_pass_num_1','error_num_1','train_time_1',
        'course_id_2','perfect_pass_num_2','error_one_pass_num_2','error_more_pass_num_2','error_num_2','train_time_2',
        'course_id_3','perfect_pass_num_3','error_one_pass_num_3','error_more_pass_num_3','error_num_3','train_time_3',
        'course_id_4','perfect_pass_num_4','error_one_pass_num_4','error_more_pass_num_4','error_num_4','train_time_4',
        'course_id_5','perfect_pass_num_5','error_one_pass_num_5','error_more_pass_num_5','error_num_5','train_time_5',
    ];

    public function adminUser()
    {
        return $this->hasOne('App\Http\Models\AdminUser','id','user_id');
    }

    //注册时调用添加
    public function registerAdd($user_id,$company_id)
    {
//        $data_arr = array_reduce($this->fillable,function($newDataArr,$field) use ($user_id){
//            $newDataArr[$field] = 0;
//            return $newDataArr;
//        });
//        $data_arr['user_id'] = $user_id;
//        $dataUserSubject2 =  new self($data_arr);
        $dataUserSubject2 =  new self(['user_id'=>$user_id,'company_id'=>$company_id]);
        return $dataUserSubject2->save();
    }

    //添加设备操作记录时跟新科目二统计
    public function runLogUpdate(DataMachineRunLog $dataMachineRunLog){
        $perfect_pass_num = 0;//完美通过
        $error_one_pass_num = 0;//一次错误通过
        $error_more_pass_num = 0;//多次错误通过
        $give_up_num = 0;//放弃次数
        $error_num = 0;//错误
        if($dataMachineRunLog->log_type == "3"){
            $perfect_pass_num++;
        }else if($dataMachineRunLog->log_type == "4"){
            $error_one_pass_num++;
        }else if($dataMachineRunLog->log_type == "5"){
            $error_more_pass_num++;
        }else if($dataMachineRunLog->log_type == "6"){
            $give_up_num++;
        }else if($dataMachineRunLog->log_type == "7"){
            $error_num++;
        }
        $dataUserSubject2 = new self();
        DB::beginTransaction();
        try{
            $res = $dataUserSubject2
                ->where(array('user_id'=>$dataMachineRunLog->user_id))
                ->update([
                    'perfect_pass_num_'.$dataMachineRunLog->course_id => DB::raw('perfect_pass_num_'.$dataMachineRunLog->course_id.'+'.$perfect_pass_num),
                    'error_one_pass_num_'.$dataMachineRunLog->course_id => DB::raw('error_one_pass_num_'.$dataMachineRunLog->course_id.'+'.$error_one_pass_num),
                    'error_more_pass_num_'.$dataMachineRunLog->course_id => DB::raw('error_more_pass_num_'.$dataMachineRunLog->course_id.'+'.$error_more_pass_num),
                    'error_num_'.$dataMachineRunLog->course_id => DB::raw('error_num_'.$dataMachineRunLog->course_id.'+'.$error_num),
                    'train_time_'.$dataMachineRunLog->course_id => DB::raw('train_time_'.$dataMachineRunLog->course_id.'+'.$dataMachineRunLog->end_time),
                    'give_up_num_'.$dataMachineRunLog->course_id => DB::raw('give_up_num_'.$dataMachineRunLog->course_id.'+'.$give_up_num)
                ]);
//            if(!$res){
//                throw new \Exception('科目二跟新统计表出现未知错误',2);
//            }
            DB::commit();
            return ['status'=>true,'code'=>0,'message'=>"Success"];
        }catch(\Exception $exception){
            DB::rollBack();
            return ['status'=>false,'code'=>$exception->getCode(),'message'=>$exception->getMessage()];
        }
    }
}
