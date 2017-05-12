<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\BaseController;
use App\Http\Models\AdminUser;
use App\Http\Models\AdminUserLog;
use App\Http\Models\Company;
use App\Http\Models\Group;
use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\RegisterPostRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class LoginController extends BaseController
{

    public function index(Request $request)
    {
        return view('manage.login.index');
    }

    public function login(LoginPostRequest $request){
        $adminUser = new AdminUser();
        $loginUser = $adminUser->loginByUserName();
        if($loginUser['flag'] == "error"){
            $validator = Validator::make($request->all(), []);
            $validator->after(function($validator) use($loginUser) {
                $validator->errors()->add($loginUser['data']['errorFiled'], $loginUser['msg']);
            });
            if ($validator->fails()) {
                $this->throwValidationException($request, $validator);
            }
        }else{
            $user = $loginUser['data'];
            $adminUserLog = new AdminUserLog();
            $saveAdminUserLog = $adminUserLog->loginAdd($user,$request->getClientIp());
            if($saveAdminUserLog){
                returnRes('success','登陆成功');
                session(['user'=>$user->getAttributes()]);
                return redirect('manage/index');
            }else{
                return redirect()->with('error','未知错误')->back();
            }
        }
    }

    public function logout(){
        session(['user'=>null]);
        return redirect('manage/login');
    }

    public function register(){
        $company = Company::where('is_del',1)->get()->toArray();
        $group = Group::where('flag',1)->get()->toArray();
        return view('manage.login.register',compact(['company','group']));
    }

    public function doRegister(RegisterPostRequest $request)
    {
        $user = new AdminUser();
        $result = $user->register();
        if($result && $result['status']){
            return redirect('manage/index')->with('success','添加成功');
        }else{
            return redirect()->with('error','添加失败')->back();
        }
    }
}
