<?php
namespace App\Helpers;
/**
 * Created by PhpStorm.
 * User: gj
 * Date: 2017/5/3
 * Time: 9:52
 */
class SessionHelper
{
    /**
     * 获取前台用户session
     * 其中添加了login_type，表示登陆类型，
     * 'other.HOME_LOGIN_TYPE_CARD'=>1, //正常刷卡登陆
     * 'other.HOME_LOGIN_TYPE_PHONE'=>2, //无卡查询登陆,即手机号，证件号登陆
     * @return Array Models/AdminUser
     */
    public static function getHomeUser()
    {
        return session(config('other.HOME_SESSION_USER_NAME'));
    }

    /**
     * 设置前台用户session
     * 其中添加了login_type，表示登陆类型，
     * 'other.HOME_LOGIN_TYPE_CARD'=>1, //正常刷卡登陆
     * 'other.HOME_LOGIN_TYPE_PHONE'=>2, //无卡查询登陆,即手机号，证件号登陆
     * @return Array Models/AdminUser
     */
    public static function setHomeUser($userArray=null){
        session([config('other.HOME_SESSION_USER_NAME')=>$userArray]);
    }
}