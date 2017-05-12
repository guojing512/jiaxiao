@extends('home.common.layout')
@section('title', '课程介绍-超弦科技')
@section('content')
    <div id="main">
        <div class="c_detail">
            <div class="position"> <span>{{$subject->subject_name}}训练课程</span>&nbsp;&gt;&nbsp;<span class="p_two">{{$course->course_name}}</span></div>

            <div class="c_d_img"><img src="{{@asset('home/images/detail.png')}}" width="570" height="380" /></div>
            <div class="c_content">
                {!! $course->content !!}
            </div>

        </div>
    </div>
    <div class="goback" style="right:309px;bottom:64px;">
        <a href="{{url("course")}}"><img src="{{@asset('home/images/goback1.png')}}" src_1="{{@asset('home/images/goback1.png')}}" src_2="{{@asset('home/images/goback2.png')}}" > </a>
    </div>
@endsection
