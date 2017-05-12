<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Course extends Model
{
    protected $table = "subject_course";
    //获取课程对应扣分放入缓存，缓存时间为24小时。
    public function getScoreList()
{
    $course_score_list = Cache::remember('course_score_list', 24*60, function() {
        $courseList = Course::all(['id',"score"])->toArray();
        $score_list = array_reduce($courseList,function($newList,$course){
            $newList[$course['id']] = $course['score'];
            return $newList;
        });
        return $score_list;
    });
    return $course_score_list;
}
}

