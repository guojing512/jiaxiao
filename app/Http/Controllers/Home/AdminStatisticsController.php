<?php

namespace App\Http\Controllers\Home;

use App\Helpers\SessionHelper;
use App\Http\Controllers\BaseHomeController;
use App\Http\Models\AdminUser;
use App\Http\Models\Course;
use App\Http\Models\DataMachine;
use App\Http\Models\DataUserSubject2;
use App\Http\Models\DataUserSubject3;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;

class AdminStatisticsController extends BaseHomeController
{
    /**
     * 统计主页面
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $machine_id = Cookie::get("machine_id");
        $dataMachine = DataMachine::whereMachine_id($machine_id)->firstOrFail();
        //换算设备总运营时间
        if($dataMachine->total_run_time > 0){
            $dataMachine->h_total_run_time = ceil(intval($dataMachine->total_run_time)/3600);
        }else{
            $dataMachine->h_total_run_time = 0;
        }
        $dataMachine->h_subject3_pass_rate = round($dataMachine->subject3_pass_rate * 100, 2);
        $dataMachine->h_subject3_average_score = round($dataMachine->subject3_average_score, 2);
        $dataMachine->subject2_train_num = 0;

        $dataMachineArr = $dataMachine->toArray();
        $courses = Course::whereSubject_id("2")->get(['id','course_name'])->toArray();
        foreach ($courses as $key => $course){
            $courses[$key]['train_num'] = $dataMachineArr['train_num_'.$course['id']];
            $dataMachine->subject2_train_num += $courses[$key]['train_num'];
            $hs_time = $dataMachineArr['train_time_'.$course['id']];
            if($hs_time > 0){
                $courses[$key]['train_time'] = ceil(intval($hs_time)/3600);
            }else{
                $courses[$key]['train_time'] = 0;
            }
        }
        return view('home.admin.statistics',compact(['dataMachine','courses']));
    }

    public function userList()
    {
        if(Input::get('data_flag') != ""){
            $session_user = SessionHelper::getHomeUser();
            $adminUser = AdminUser::where('company_id',$session_user['company_id'])
                ->where('user_status',1)
                ->with(['UserExt'])
                ->paginate(30);
            $userList = $adminUser->toArray();
            foreach ($userList['data'] as $key=>$user){
                $userList['data'][$key]['format_remaining_time'] = getFriendTime($user['user_ext']['remaining_time'],'h','c');
                $userList['data'][$key]['format_used_time'] = getFriendTime($user['user_ext']['used_time'],'h','c');
                $userList['data'][$key]['format_sex'] = $user['sex']==1?'男':'女';
            }
            return response()->json($userList);
        }else{
            return view('home.admin.userList');
        }
    }

    public function subject2List()
    {
        if(Input::get('data_flag') != ""){
            $session_user = SessionHelper::getHomeUser();
            $dataUserSubject2 = DataUserSubject2::where('company_id',$session_user['company_id'])
                ->with(['adminUser'])
                ->paginate(30);
            $dataList = $dataUserSubject2->toArray();
            foreach ($dataList['data'] as $key=>$data){
                $dataList['data'][$key]['format_course_total_1'] = $data['perfect_pass_num_1'] + $data['error_one_pass_num_1'] + $data['error_more_pass_num_1'] + $data['give_up_num_1'];
                $dataList['data'][$key]['format_course_total_2'] = $data['perfect_pass_num_2'] + $data['error_one_pass_num_2'] + $data['error_more_pass_num_2'] + $data['give_up_num_2'];
                $dataList['data'][$key]['format_course_total_3'] = $data['perfect_pass_num_3'] + $data['error_one_pass_num_3'] + $data['error_more_pass_num_3'] + $data['give_up_num_3'];
                $dataList['data'][$key]['format_course_total_4'] = $data['perfect_pass_num_4'] + $data['error_one_pass_num_4'] + $data['error_more_pass_num_4'] + $data['give_up_num_4'];
                $dataList['data'][$key]['format_course_total_5'] = $data['perfect_pass_num_5'] + $data['error_one_pass_num_5'] + $data['error_more_pass_num_5'] + $data['give_up_num_5'];
                $dataList['data'][$key]['format_total'] = $dataList['data'][$key]['format_course_total_1'] + $dataList['data'][$key]['format_course_total_2'] + $dataList['data'][$key]['format_course_total_3'] + $dataList['data'][$key]['format_course_total_4'] + $dataList['data'][$key]['format_course_total_5'];
                $dataList['data'][$key]['format_train_time_total'] = $data['train_time_1'] + $data['train_time_2'] + $data['train_time_3'] + $data['train_time_4'] + $data['train_time_5'] ;
                $dataList['data'][$key]['format_train_h_total'] = getFriendTime($dataList['data'][$key]['format_train_time_total'],'h','c');
            }
            return response()->json($dataList);
        }else{
            return view('home.admin.subject2List');
        }
    }

    public function subject3List()
    {
        if(Input::get('data_flag') != ""){
            $session_user = SessionHelper::getHomeUser();
            $dataUserSubject3 = DataUserSubject3::where('company_id',$session_user['company_id'])
                ->with(['adminUser'])
                ->paginate(30);
            $dataList = $dataUserSubject3->toArray();
            foreach ($dataList['data'] as $key=>$data){
                if($data['pass_num'] > 0){
                    $dataList['data'][$key]['format_pass_rate'] = round($data['pass_num']/$data['train_num'], 4)*100;
                }else{
                    $dataList['data'][$key]['format_pass_rate'] = "0.00";
                }
                if($data['score']){
                    $dataList['data'][$key]['format_pass_score'] = round($data['score']/$data['train_num'],2);
                }else{
                    $dataList['data'][$key]['format_pass_score'] = 0.00;
                }
                if($data['error_num']){
                    $dataList['data'][$key]['format_pass_error_num'] = round($data['error_num']/$data['train_num'],2);
                }else{
                    $dataList['data'][$key]['format_pass_error_num'] = 0.00;
                }
                $dataList['data'][$key]['format_train_time'] = getFriendTime($dataList['data'][$key]['train_time'],'h','c');


            }
            return response()->json($dataList);
        }else{
            return view('home.admin.subject3List');
        }
    }
}
