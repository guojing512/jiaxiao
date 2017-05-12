<?php

namespace App\Http\Controllers\Home;

use App\Helpers\SessionHelper;
use App\Http\Models\AdminUser;
use App\Http\Models\AdminUserLog;
use App\Http\Models\UserExt;
use App\Http\Requests\LoginPostRequest;

use App\Http\Requests\LoginByPhonePostRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function main()
    {
        return view('home.main');
    }

    public function login(Request $request)
    {
        $onlyLogin = create_randomstr();
        $request->session()->put('onlyLogin', $onlyLogin);
        return view('home.login.login',['onlyLogin'=>$onlyLogin]);
    }

    public function doLogin(LoginPostRequest $request){
        $adminUser = new AdminUser();
        $loginUser = $adminUser->loginByPhone();
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
                $userSession = $user->getAttributes();
                $userSession['login_type'] = config('other.HOME_LOGIN_TYPE_CARD');
                SessionHelper::setHomeUser($userSession);
                return redirect('index');
            }else{
                return redirect()->with('error','未知错误')->back();
            }
        }
    }

    /**
     * 前台刷卡登陆，ajax调用
     *
     * @return \Illuminate\Http\Response
     */
    public function doLoginByCard(Request $request){
        $adminUser = new AdminUser();
        $loginUser = $adminUser->loginByCard();
        if($loginUser['flag'] == "success"){
            $user = $loginUser['data'];
            DB::beginTransaction();
            try{
                $saveAdminUserLog = (new AdminUserLog())->loginAdd($user,$request->getClientIp());
                if (!$saveAdminUserLog) {
                    throw new \Exception('添加登录日志出现未知错误');
                }
                $updateUserExt = (new UserExt())->loginUpdate($user->id);
                if (!$updateUserExt) {
                    throw new \Exception('跟新用户附加表信息出现未知错误');
                }
                $userSession = $user->getAttributes();
                $userSession['login_type'] = config('other.HOME_LOGIN_TYPE_CARD');
                SessionHelper::setHomeUser($userSession);
                if(config('other.GROUP_ID_SCHOOL_ADMIN') == $loginUser['data']->group_id){
                    $loginUser['data']->next_url = url('admin');
                }elseif(config('other.GROUP_ID_SCHOOL_USER') == $loginUser['data']->group_id){
                    $loginUser['data']->next_url = url('user');
                }
                DB::commit();
            }catch (\Exception $exception){
                DB::rollBack();
                return returnRes("error",$exception->getMessage());
            }
        }
        return response()->json($loginUser);
    }

    /**
     * 无卡查询时输手机号，身份证号登陆
     *
     * @return \Illuminate\Http\Response
     */
    public function loginByPhone(LoginByPhonePostRequest $request)
    {
        if($request->isMethod("post")){
            $adminUser = new AdminUser();
            $loginUser = $adminUser->loginByPhone();
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
                    $userSession = $user->getAttributes();
                    $userSession['login_type'] = config('other.HOME_LOGIN_TYPE_PHONE');
                    SessionHelper::setHomeUser($userSession);
                    return redirect('noCard');
                }else{
                    return redirect()->with('error','未知错误')->back();
                }
            }
        }else{
            return view('home.login.loginPhone');
        }
    }

    public function logout()
    {
        $sessionUser = SessionHelper::getHomeUser();
        if(config('other.HOME_LOGIN_TYPE_CARD') == $sessionUser['login_type']){//正常刷卡登陆退出
            SessionHelper::setHomeUser();
            return redirect('/');
        }elseif(config('other.HOME_LOGIN_TYPE_PHONE') == $sessionUser['login_type'] ){//无卡查询退出
            SessionHelper::setHomeUser();
            return redirect('/');
        }
    }

}
