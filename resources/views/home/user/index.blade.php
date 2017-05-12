@extends('home.common.layout')
@section('title', '用户主界面-超弦科技')

@section('content')
    <div id="main">
        <div class="user_index">
            <div class="user_sub2">
                <h2 class="u_sub2_title">科目二<span>训练时间：{{$dataUserSubject2['format_train_time']}}小时</span></h2>
                <div class="u_sub2_con">
                    <ul>
                        @foreach($courses as $key => $course)
                            <li class="u_s2_li{{$course['id']}}">
                                <h3>{{$course['course_name']}}</h3>
                                <div class="user_sub2_tiao1"></div>
                                <table class="sub2_top">
                                    <thead>
                                    <tr>
                                        <td>次数</td>
                                        <td>错误</td>
                                        <td>时间</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{$course['train_num']}}</td>
                                        <td>{{$course['error_num']}}</td>
                                        <td>{{$course['train_time']}}</td>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="user_sub2_tiao2"></div>

                                <ul class="sub2_bottom">
                                    <li>完美通过<span>{{$course['perfect_pass_num']}} 次</span></li>
                                    <li>多次失误通过<span>{{$course['error_one_pass_num']}} 次</span></li>
                                    <li>一次失误通过<span>{{$course['error_more_pass_num']}} 次</span></li>
                                    <li>放弃<span>{{$course['give_up_num']}} 次</span></li>
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="u_sub3">
                <div class="sub3_left">
                    <h2 class="u_sub3_title">科目三<span>训练时间：{{$dataUserSubject3->format_train_time}}小时</span></h2>
                    <table class="u_sub3_con">
                        <thead>
                        <tr>
                            <td>最近模拟</td>
                            <td>扣分</td>
                            <td>不合格违规</td>
                            <td>通过</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($subject3Data as $data)
                            <tr>
                                <td>{{$data['format_date']}}</td>
                                <td>-{{$data['score']}}</td>
                                <td>{{$data['error_perfect_num']}}</td>
                                @if($data['out_flag'] == '1')
                                    <td>通过</td>
                                @else
                                    <td class="color_red">未通过</td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="sub3_right">
                    <h2 class="u_sub3_jy_title">科目三建议</h2>
                    <table class="u_sub3_jy_table">
                        <thead>

                        <tr>
                            <td>近期出错类</td>
                            <td>建议</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($errorList as $item)
                            <tr>
                                <td>{{$item['error_type_name']}}</td>
                                <td>{{$item['advice_content']}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
            $s_user = session()->get(config('other.HOME_SESSION_USER_NAME'));
            ?>
            @if($s_user['login_type'] == "1")
                @include('home.user.user_foot')
            @else
                @include('home.user.nocard_foot')
            @endif
        </div>
        <!-- 开始训练确认 -->
        <div class="start_train_tan">
            <p class="train_txt">点击“确认”将锁定屏幕</p>
            <p class="train_txt">设备开始启动并计入倒计时</p>

            <div class="btn_start_train_tan">
                <a href="javascript:{back_user_index();}" ><img src="{{@asset('home/images/242_fan1.png')}}" src_1="{{@asset('home/images/242_fan1.png')}}" src_2="{{@asset('home/images/242_fan2.png')}}"/></a>
                <a href="javascript:{show_countdown();}" class="btn_train_tan_ok"><img src="{{@asset('home/images/242_qr1.png')}}" src_1="{{@asset('home/images/242_qr1.png')}}" src_2="{{@asset('home/images/242_qr2.png')}}"/></a>
            </div>
        </div>

        <!-- 倒计时 -->
        <div class="countdown_tan">
            <div class="countdown_tan_text">
                <p class="c_d_txt">已锁定，需刷卡解除当前锁定</p>
                <p class="c_d_txt">并结束计时</p>
                <div class="countdown_second">10s</div>
            </div>
            <div class="btn_countdown_tan">
                <a href="javascript:;" class="btn_countdown_tan_qx"><img src="{{@asset('home/images/402_qx1.png')}}" src_1="{{@asset('home/images/402_qx1.png')}}" src_2="{{@asset('home/images/402_qx2.png')}}"/></a>
            </div>
        </div>

    </div>
    <script type="text/javascript" src="{{@asset('home/js/radialIndicator.js')}}"></script>
    <script type="text/javascript">
        function start(){
            $.ajax({
                type: "POST",
                url:"{{url('user/getRemainingTime')}}",
                data:"",
                dataType:'json',
                success: function(jsonData){
                    if(jsonData.flag == "success"){
                        if(jsonData.data < (60 * 5)){
                            alert("剩余时长小于5分钟，请及时充值。");
                        }else{
                            hideUser();
                        }
                    }else{
                        alert(jsonData.msg);
                    }
                }
            });

        }
        function showUser(){
            $(".countdown_tan").fadeOut(400);
            $(".start_train_tan").fadeOut(400);
            $(".user_index").fadeIn(800);
        }
        function hideUser(){
            $(".user_index").fadeOut(400);
            $(".start_train_tan").fadeIn(800);
        }
        function back_user_index(){
            $(".start_train_tan").fadeOut(400);
            $(".user_index").fadeIn(800);
        }
        function show_countdown(){
            $(".start_train_tan").fadeOut(400);
            $(".countdown_tan").fadeIn(800);
            countdown('.countdown_second',10,function(){
                showUser();
            });
        }
        $(document).ready(function(){
            //开始按钮
            myself_hover("#start_train a img");
            myself_touch("#start_train a img");
            //开始训练确认按钮
            myself_hover(".start_train_tan a img");
            myself_touch(".start_train_tan a img");
            //倒计时按钮
            myself_hover(".countdown_tan a img");
            myself_touch(".countdown_tan a img");
            //总训练时长
            var total_train_time = parseInt($("#train_time_val").html());
            var total_train = radialIndicator('#total_train_time', {
                radius : 46,
                barWidth : 5,
                barBgColor : '#C8C8C8',
                barColor : '#65D5AA',
                fontColor : '#4DA985',
                fontSize : 16,
                fontStyle : 'italic',
                fontFamily:'微软雅黑',
                displayNumber: true,
                initValue:0,
                maxValue:total_train_time,
                appendTxt:'h',
                frameTime:1,
                frameNum:100
            });
            total_train.animate(total_train_time);
            //剩余时长
            var remaining_time = parseInt($("#remaining_time_val").html());
            var remaining = radialIndicator('#remaining_time', {
                radius : 46,
                barWidth : 5,
                barBgColor : '#C8C8C8',
                barColor : '#D4B263',
                fontColor : '#C09844',
                fontSize : 16,
                fontStyle : 'italic',
                fontFamily:'微软雅黑',
                displayNumber: true,
                initValue:0,
                maxValue:remaining_time + remaining_time/2,
                appendTxt:'h',
                frameTime:1,
                frameNum:100
            });
            remaining.animate(remaining_time);
        });
    </script>
@endsection
