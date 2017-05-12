<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\BaseController;
use App\Http\Models\Course;
use App\Http\Models\CourseAdvice;
use App\Http\Requests\CourseAdvicePostRequest;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CourseAdviceController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = Input::get('keyword');
        $courseAdvice = CourseAdvice::with(['course'])->where('id','>',0);
        if($keyword != ''){
            $courseAdvice = $courseAdvice->where('advice_content','like','%'.$keyword.'%');

        }
        $courseAdvice = $courseAdvice->paginate(10);
        //传给分页
        if($keyword != ''){
            $courseAdvice->appends(['keyword' => $keyword])->render();
        }
        $courseAdvice_arr = $courseAdvice->toArray();
        $pages = get_pages_html($courseAdvice_arr);
        $data = $courseAdvice_arr['data'];
        return view('manage.courseAdvice.index',compact(['data','pages','keyword']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $course = Course::all()->toArray();
        return view('manage.courseAdvice.add',compact(['course']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CourseAdvicePostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseAdvicePostRequest $request)
    {
        $input = Input::all();
        $courseAdvice = new CourseAdvice($input);
        $result = $courseAdvice->save();
        if($result){
            return redirect('manage/courseAdvice')->with('success','更新成功');
        }else{
            return redirect()->with('error','更新失败')->back();
        }
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $id = Input::get('id');
        $info = CourseAdvice::find($id)->toArray();
        $course = Course::all()->toArray();
        return view('manage.courseAdvice.edit',compact(['course','info']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\CourseAdvicePostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function doEdit(CourseAdvicePostRequest $request)
    {
        $input = Input::all();
        $courseAdvice = CourseAdvice::find($input['id']);
        $courseAdvice->course_id = $input['course_id'];
        $courseAdvice->advice_content = $input['advice_content'];
        $courseAdvice->sort_num = $input['sort_num'];
        $result = $courseAdvice->update();
        if($result){
            return redirect('manage/courseAdvice')->with('success','更新成功');
        }else{
            return redirect()->with('error','更新失败')->back();
        }
    }
}
