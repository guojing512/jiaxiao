<?php

namespace App\Http\Controllers\Home;

use App\Helpers\SessionHelper;
use App\Http\Controllers\BaseHomeController;
use App\Http\Models\UserExt;

class UserController extends BaseHomeController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = NoCardQueryController::getNoCardData();
        return view('home.user.index',$data);
    }

    //帮助-上机注意事项
    public function helpShangji()
    {
        return view('home.user.helpShangji');
    }

    //帮助-设备注意事项
    public function helpShebei()
    {
        return view('home.user.helpShebei');
    }

    //帮助-训练操作注意事项
    public function helpXunlian()
    {
        return view('home.user.helpXunlian');
    }

    //帮助-其他注意事项
    public function helpQita()
    {
        return view('home.user.helpQita');
    }
    
    //获取用户剩余时长
    public function getRemainingTime()
    {
        try {
            $userSession = SessionHelper::getHomeUser();
            $userExt = UserExt::where("user_id",$userSession['id'])->first(['remaining_time']);
            if (!$userExt) {
                throw new \Exception('获取用户剩余时长出现未知错误，请稍后再试。');
            }
            return response()->json(returnRes("success", 'ok', $userExt->remaining_time));
        } catch (\Exception $exception) {
            return response()->json(returnRes("error", $exception->getMessage()));
        }
    }
}
