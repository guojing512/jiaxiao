<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CourseAdvice extends Model
{
    protected $table = "course_advice";
    protected $guarded  = [];

    public function course()
    {
        return $this->hasOne( 'App\Http\Models\Course','id' , 'course_id' );
    }
}
