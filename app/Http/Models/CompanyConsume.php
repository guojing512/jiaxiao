<?php

namespace App\Http\Models;

use App\Helpers\SessionHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class CompanyConsume extends Model
{
    protected $table = "company_consume";
    protected $fillable  =  ['id','user_id','company_id','give_time','created_at','updated_at'];

    public function adminUser()
    {
        return $this->hasOne('App\Http\Models\AdminUser','id','user_id');
    }

    //前台注册注册，给学员分配赠送时长时跟新驾校的消费记录表
    public function registerAdd(AdminUser $user)
    {
        $give_time = Input::get('give_time');
        $give_time = $give_time * 60 * 60;
        $session_user = SessionHelper::getHomeUser();
        $companyConsume =  new self(['user_id'=>$user->id,'company_id'=>$session_user['company_id'],'give_time'=>$give_time]);
        return $companyConsume->save();
    }
}
