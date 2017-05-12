<?php

namespace App\Http\Controllers\Home;

use App\Http\Models\Course;
use App\Http\Models\Subject;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SubjectCourse extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subject2_course = Course::where('subject_id','2')
            ->orderBy('sort_num', 'desc')
            ->orderBy('id', 'asc')
            ->get(['id','course_name','pic_cover']);
        $subject3_course = Course::where('subject_id','3')->orderBy('sort_num', 'desc')->orderBy('id', 'asc')->get(['id','course_name']);
        return view('home.course.index',compact('subject2_course','subject3_course'));
    }

    public function detail($id)
    {

        $course = Course::find($id);
        $subject = Subject::find($course->subject_id);
        return view('home.course.detail',compact('course','subject'));
    }
}
