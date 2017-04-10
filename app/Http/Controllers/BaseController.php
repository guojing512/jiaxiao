<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
//use App\Http\Requests\Request as R;

class BaseController extends Controller
{


	/**
     * 初始化类，进行各项判断和处理
     */
    public function __construct() {
        
        //判断用户是否登录
        self::checkLogin();
        //判断用户是否有执行权限
        if(!self::checkPrivate()) {
            return redirect()->back()
                ->with('error','您无权访问')
                ->send();
        }
    }

    /**
     * 判断用户是否已经登陆
     */
    final public function checkLogin() {

        $route = \Route::current()->uri();//获取当前路由
        if(in_array($route, array('login','logout'))){
            return true;
        }else{
            $s_user = session()->get('user');
            if (empty($s_user) || !$s_user['id'] || !$s_user['group_id']) {
                redirect()->to('login')->send();
                exit;

            }
            return true;

        }
    }

    /**
     * 权限判断
     */
    final public function checkPrivate() {

        $route = \Route::current()->uri();//获取当前路由
        $s_user = session()->get('user');

        // 判断是否是超级管理员组
        if ($s_user['group_id'] == env('GROUP_ID_ADMIN')){
            return true;
        }

        // 如果是基础方法(登录或登出) 直接返回true
        
        if(in_array($route, array('login','logout','index'))){
            return true;
        }

        $s_group_id = $s_user['group_id'];

        // 查询是否有对应权限
        $res = DB::table('menu as m')
            ->leftJoin('group_role as gr', 'm.id', '=', 'gr.menu_id')
            ->whereRaw("ds_m.route = '$route' and ds_gr.group_id = $s_group_id")
            ->first();

        if (!$res){
            return false;
        }
        return true;
    }

}
