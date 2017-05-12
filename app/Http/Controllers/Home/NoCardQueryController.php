<?php

namespace App\Http\Controllers\Home;

use App\Helpers\SessionHelper;
use App\Http\Controllers\BaseHomeController;
use App\Http\Models\Course;
use App\Http\Models\CourseAdvice;
use App\Http\Models\DataMachine;
use App\Http\Models\DataSubject3Log;
use App\Http\Models\DataUserSubject2;
use App\Http\Models\DataUserSubject3;
use App\Http\Models\UserExt;
use App\Http\Requests\CourseAdvicePostRequest;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlockFactory;
use Symfony\Component\VarDumper\Cloner\Data;

class NoCardQueryController extends BaseHomeController
{
    /**
     * 无卡查询主页
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $data = $this->getNoCardData();
        return view('home.user.index',$data);
    }



    public static function getNoCardData(){
        SessionHelper::getHomeUser();
        $session_user = SessionHelper::getHomeUser();//获取当前登录用户的session信息
        $dataUserSubject2 = DataUserSubject2::where('user_id',$session_user['id'])->first()->toArray();//查询用户科目二数据统计
        $dataUserSubject3 = DataUserSubject3::where('user_id',$session_user['id'])->first();//查询用户科目三数据统计
        $dataUserSubject2['format_train_time'] = 0;
        //格式化科目三训练时间
        if($dataUserSubject3->train_time > 0){
            $dataUserSubject3->format_train_time = ceil(intval($dataUserSubject3->train_time)/3600);
        }else{
            $dataUserSubject3->format_train_time = 0;
        }
        $subject3Data = [];//初始化返回科目三最近六次练习数据

        //查询最近六次训练的run_id
        $dataSubject3LogList = DataSubject3Log::where('user_id',$session_user['id'])
            ->orderBy('created_at', 'desc')->groupBy('run_id')->groupBy('course_num')->take(6)->get(['run_id','course_num'])->toArray();
        //循环获取每次练习的实际数据
        foreach ($dataSubject3LogList as $key => $dataSubject3){
            $subject3 = (new DataSubject3Log())->getSubject3RunDataByRunId($dataSubject3['run_id'],$dataSubject3['course_num']);
            $subject3['format_date'] = date("n月d日",$subject3['start_time']);
            $subject3Data[] = $subject3;
        }

        //循环获取科目二练习统计数据
        $courses = Course::whereSubject_id("2")->get(['id','course_name'])->toArray();
        foreach ($courses as $key => $course){
            //训练次数
            $courses[$key]['train_num'] = $dataUserSubject2["perfect_pass_num_".$course['id']] + $dataUserSubject2["error_one_pass_num_".$course['id']] + $dataUserSubject2["error_more_pass_num_".$course['id']];
            $courses[$key]['error_num'] = $dataUserSubject2["error_num_".$course['id']];//错误次数
            $courses[$key]['train_time'] = $dataUserSubject2["train_time_".$course['id']];//练习时间
            if($dataUserSubject3->train_time > 0){
                $courses[$key]['train_time'] = ceil(intval($dataUserSubject2["train_time_".$course['id']])/3600);
                $dataUserSubject2['format_train_time'] += $courses[$key]['train_time'];
            }else{
                $courses[$key]['train_time'] = 0;
            }
            $courses[$key]['perfect_pass_num'] = $dataUserSubject2["perfect_pass_num_".$course['id']];//完美通过次数
            $courses[$key]['error_one_pass_num'] = $dataUserSubject2["error_one_pass_num_".$course['id']];//一次错误通过次数
            $courses[$key]['error_more_pass_num'] = $dataUserSubject2["error_more_pass_num_".$course['id']];//多次错误通过次数
            $courses[$key]['give_up_num'] = $dataUserSubject2["give_up_num_".$course['id']];//放弃次数
        }
        //获取用户训练时间和剩余时长
        $userExt = UserExt::where('user_id',$session_user['id'])->first(['used_time','remaining_time'])->toArray();
        $userExt['format_used_time'] = getFriendTime($userExt['used_time'],'h','c');//已用时长
        $userExt['format_remaining_time'] = getFriendTime($userExt['remaining_time'],'h','f');//剩余时长

        //近期出错
        $errorList = DataSubject3Log::where('user_id',$session_user['id'])
            ->orderBy('created_at', 'desc')->take(8)->distinct('error_type')->get(['error_type'])->toArray();
        foreach ($errorList as $key => $error_type){
            $errorProposal = CourseAdvice::where('id',$error_type)->with(['course'])->first()->toArray();
            $errorList[$key]['error_type_name'] = $errorProposal['course']['course_name'];
            $errorList[$key]['advice_content'] = $errorProposal['advice_content'];

        }
        return compact(['courses','subject3Data','dataUserSubject3','dataUserSubject2','userExt','errorList']);
    }
}
