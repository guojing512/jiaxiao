<?php

namespace App\Http\Models;

use App\Helpers\SessionHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class Company extends Model
{
    protected $table = "company";
    protected $guarded  = [];

    //前台注册时，为用户分配时长
    public function registerUpdateAvailable_time()
    {
        $give_time = Input::get('give_time');
        $give_time = $give_time * 60 * 60;
        $company = new self();
        $session_user = SessionHelper::getHomeUser();
        $res = $company
            ->where('id',$session_user['company_id'])
            ->where('available_time',">=",$give_time)
            ->update([
                'available_time' => DB::raw('available_time-'.$give_time),
            ]);
        return $res;
    }

    public function getByNumAndTime($company_id,$give_time)
    {
        $give_time = $give_time * 60 * 60;
        $count = Company::where('id',$company_id)->where('available_time',">=",$give_time)->count();
        return $count;
    }
    public function user()
    {
        return $this->belongsTo( 'App\Http\Models\AdminUser','user_id' , 'id' );
    }

    public function province()
    {
        return $this->hasOne('App\Http\Models\City','id','province_id');
    }

    public function city()
    {
        return $this->hasOne('App\Http\Models\City','id','city_id');
    }

    public function county()
    {
        return $this->hasOne('App\Http\Models\City','id','county_id');
    }

    public function machineBug()
    {
        return $this->hasManyThrough('App\Http\Models\MachineBug','App\Http\Models\Machine','company_id','machine_id');
    }
}
