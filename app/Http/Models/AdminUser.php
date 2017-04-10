<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    protected $table = "admin_user";

    public function company()
    {
        return $this->hasOne('App\Http\Models\Company','id','company_id');
    }

    public function group()
    {
        return $this->hasOne('App\Http\Models\Group','id','group_id');
    }
}
