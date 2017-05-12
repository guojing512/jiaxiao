@extends('home.common.layout')
@section('title', '登录-超弦科技')
@section('content')
        <div id="main">
            <div class="admin_page">
                <ul class="a_p_ul1">
                    <li class="a_p_li">
                        <a href="{{url('admin/register')}}"><img src="{{@asset('home/images/gly_user1.png')}}" src_1="{{@asset('home/images/gly_user1.png')}}" src_2="{{@asset('home/images/gly_user2.png')}}"/></a>
                        <p>新用户注册</p>
                    </li>
                    <li class="a_p_li">
                        <a href="{{url('admin/fillCard')}}"><img src="{{@asset('home/images/gly_cha1.png')}}" src_1="{{@asset('home/images/gly_cha1.png')}}" src_2="{{@asset('home/images/gly_cha2.png')}}"/></a>
                        <p>查询、补办</p>
                    </li>
                    <li class="a_p_li">
                        <a href="{{url('rechAdmin')}}"><img src="{{@asset('home/images/gly_cz1.png')}}" src_1="{{@asset('home/images/gly_cz1.png')}}" src_2="{{@asset('home/images/gly_cz2.png')}}"/></a>
                        <p>时长充值</p>
                    </li>
                </ul>

                <ul class="a_p_ul2">
                    <li class="a_p_li">
                        <a href="{{url('admin/statistics')}}"><img src="{{@asset('home/images/gly_tj1.png')}}" src_1="{{@asset('home/images/gly_tj1.png')}}" src_2="{{@asset('home/images/gly_tj2.png')}}"/></a>
                        <p>统计</p>
                    </li>
                    <li class="a_p_li">
                        <a href="{{url('admin/queryLength')}}"><img src="{{@asset('home/images/gly_time1.png')}}" src_1="{{@asset('home/images/gly_time1.png')}}" src_2="{{@asset('home/images/gly_time2.png')}}"/></a>
                        <p>查询时长</p>
                    </li>
                    <li class="a_p_li">
                        <a href="{{url('admin/repair')}}" onclick="goUrl(url)"><img src="{{@asset('home/images/gly_bug1.png')}}" src_1="{{@asset('home/images/gly_bug1.png')}}" src_2="{{@asset('home/images/gly_bug2.png')}}"/></a>
                        <p>报修</p>
                    </li>
                </ul>
            </div>
        </div>

        <div class="login_footer" style="height:80px;">
            <div class="l_f2"><span>全国咨询电话：400-xxx-xxx</span></div>
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                myself_hover(".a_p_li a img");
                myself_touch(".a_p_li a img");
            });
        </script>
@endsection
