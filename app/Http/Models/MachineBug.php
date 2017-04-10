<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class MachineBug extends Model
{
    protected $table = "machine_bug";
    protected $guarded  = [];

    public function machine()
    {
        return $this->hasOne( 'App\Http\Models\Machine','id' , 'machine_id' );
    }
}
