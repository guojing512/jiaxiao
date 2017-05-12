<?php

namespace App\Http\Models;

use App\Http\Requests\Request;
use Illuminate\Database\Eloquent\Model;

class AdminUserLog extends Model
{
    protected $table = "admin_user_log";
    public $timestamps = false;
    protected $fillable = ['id','user_id','user_name','real_name','log_type','log_content','login_ip','created_at'];

    public function loginAdd($user,$clientIp)
    {
        $adminUserLog = new self([
            'user_id'=>$user->id,
            'user_name'=>$user->user_name,
            'real_name'=>$user->real_name,
            'log_type'=>1,
            'log_content'=>'登陆',
            'login_ip'=>$clientIp,
            'created_at'=>date('Y-m-d H:i:s',time()),
        ]);
        return $adminUserLog->save();
    }
}
