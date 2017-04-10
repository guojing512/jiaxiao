<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = "company";
    protected $guarded  = [];
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
