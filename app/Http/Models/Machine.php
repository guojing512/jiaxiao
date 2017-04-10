<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $table = "machine";
    protected $guarded  = [];

    public function company()
    {
        return $this->hasOne( 'App\Http\Models\Company','id' , 'company_id' );
    }

    public function BelongsToCompany()
    {
        return $this->belongsTo('App\Http\Models\Company', 'company_id', 'id');
    }
}
