@extends('home.common.layout')
@section('title', '登录-超弦科技')
@section('content')
        <div id="main">
            <div class="login_top1">
                <img src="{{@asset('home/images/activity1.png')}}" width="1280" height="80" />
            </div>
            <div class="login_top2">
                <img src="{{@asset('home/images/activity2.png')}}" width="1280" height="660" />
                <div class="lg_slide_up"><img src="{{@asset('home/images/lg_up.png')}}" width="60" height="60" /></div>
            </div>
            <div class="login_content">
                <dl>
                    <div>
                        <dd><a href="{{url('course')}}"><img src="{{@asset('home/images/lg_kc1.png')}}" width="230" height="230" src_1="{{@asset('home/images/lg_kc1.png')}}" src_2="{{@asset('home/images/lg_kc2.png')}}"/></a></dd>
                        <dt>课程介绍</dt>
                    </div>
                    <div>
                        <dd><a href="{{url('loginPhone')}}" onclick="goUrl(url)"><img src="{{@asset('home/images/lg_cha1.png')}}" width="230" height="230" src_1="{{@asset('home/images/lg_cha1.png')}}" src_2="{{@asset('home/images/lg_cha2.png')}}"/></a></dd>
                        <dt>无卡查询</dt>
                    </div>
                    <div>
                        <dd><a href="javascript:;" id="card_entry"><img src="{{@asset('home/images/lg_sk1.png')}}" width="230" height="230" src_1="{{@asset('home/images/lg_sk1.png')}}" src_2="{{@asset('home/images/lg_sk2.png')}}"/></a></dd>
                        <dt>刷卡进入</dt>
                    </div>
                </dl>
            </div>
        </div>
        <div class="login_footer">
            <div class="l_f1">
                <div class="l_f1_1">
                    <p>已办理上机卡的用户请点击“<span class="red1">刷卡进入</span>”按钮</p>
                </div>
            </div>
            <div class="l_f2"><span>全国咨询电话：400-xxx-xxx</span></div>
        </div>
    <div class="fugaiqu"></div>
    <div class="lg_msg">
        请在右侧刷卡机上刷卡进入系统
    </div>

    <script type="text/javascript">

        function ReadCallBack(car_num){
            paycard(car_num);
        }
        function paycard(car_num){
            alert("刷卡登陆。")
            car_num = "170412149196658847405669";//管理员
            car_num = "170508149423662836780240";//普通用户
            ds.loginByCard(car_num,function(json_data){
                console.log(json_data.data.next_url);
                if(json_data.flag == 'success'){
                    window.location.href = json_data.data.next_url;
                }else{
                    alert(json_data.msg);
                }
            });
        }

        $(document).ready(function(){
            setInterval("login_gundong()",20);
            myself_hover(".login_content dl div dd img");
            myself_touch(".login_content dl div dd img");

            $("#card_entry").children('img').on('click',function(){
                console.log("等待刷卡登陆");
                if(typeof ($.cookie('machine_num')) == "undefined" || $.cookie('machine_num') == ""){
                    console.log("没有获取到当前设备的相关信息，请稍后再试。");
                }else{
                    paycard("170508149423662836780240");
                }
            });
        });
    </script>
@endsection
