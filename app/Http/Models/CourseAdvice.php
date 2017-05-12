<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CourseAdvice extends Model
{
    protected $table = "course_advice";
    protected $guarded  = [];

    public function course()
    {
        return $this->hasOne( 'App\Http\Models\Course','id' , 'course_id' );
    }


    public function getScoreList()
    {
        $course_advice_score_list = Cache::remember(config('other.COURSE_ADVICE_SCORE_LIST'), 24*60, function() {
            $courseAdviceList = CourseAdvice::all(['id',"advice_score"])->toArray();
            $score_list = array_reduce($courseAdviceList,function($newList,$courseAdvice){
                $newList[$courseAdvice['id']] = $courseAdvice['advice_score'];
                return $newList;
            });
            return $score_list;
        });
        return $course_advice_score_list;
    }
}
