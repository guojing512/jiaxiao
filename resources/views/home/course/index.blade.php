@extends('home.common.layout')
@section('title', '登录-超弦科技')
@section('content')
    <div id="main">

        <div class="course2">
            <h3 class="c_title">科目二训练课程</h3>
            <ul>
                @foreach($subject2_course as $key=>$course)
                    <li>
                        <div><img src="{{@asset($course->pic_cover)}}" width="208" height="161" /></div>
                        <p><span>{{$course->course_name}}</span><a href="{{url('course/detail/'.$course->id)}}"><span class="c2_click">点击进入</span></a></p>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="course_mid">
            <div class="course3">
                <h3 class="c_title">科目三训练课程</h3>
                <div class="course3_info">
                    <p>真实模拟科三考试，加入指令，11个功能点全部覆盖，让您考驾无忧。真实模拟科三考试，加入指令，11个功能点全部覆盖，让您考驾无忧。</p>
                    <ul>
                        @foreach($subject3_course as $key=>$course)
                            <li>
                                <h5>{{$course->course_name}}</h5>
                                <a href="{{url('course/detail/'.$course->id)}}">
                                    <span>点击进入<img src="{{@asset('home/images/djjr1.png')}}" src_1="{{@asset('home/images/djjr1.png')}}" src_2="{{@asset('home/images/djjr2.png')}}"/></span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="course_notes">
                <h3 class="c_title">操作事项</h3>
                <ul>
                    <li>
                        <img src="images/note1.png" width="180" height="120" />
                        <div class="notes_con">
                            <h5>安全操作</h5>
                            <p>直角转弯，考试中相对比较简单些，但是却容易失误的项目。</p>
                        </div>
                    </li>
                    <li>
                        <img src="images/note2.png" width="180" height="120" />
                        <div class="notes_con">
                            <h5>安全操作</h5>
                            <p>直角转弯，考试中相对比较简单些，但是却容易失误的项目。</p>
                        </div>
                    </li>
                    <li>
                        <img src="images/note3.png" width="180" height="120" />
                        <div class="notes_con">
                            <h5>付费问题</h5>
                            <p>直角转弯，考试中相对比较简单些，但是却容易失误的项目。</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="goback">
        <a href="{{url("/")}}"><img src="{{@asset('home/images/goback1.png')}}" src_1="{{@asset('home/images/goback1.png')}}" src_2="{{@asset('home/images/goback2.png')}}" > </a>
    </div>


    <script type="text/javascript">
        $(document).ready(function(){
            myself_hover(".c2_click",'#3393ed','#236098');
            myself_touch(".c2_click",'#3393ed','#236098');
            //返回按钮
            myself_hover(".goback img");
            myself_touch(".goback img");

        });
    </script>
@endsection
