@extends('home.common.layout')
@section('title', '帮助-设备注意事项-超弦科技')

@section('content')
    <div id="main">
        <div class="help_sj help_main">

            <div class="help_con">
                <ul>
                    <li>
                        <p class="con_img"><img src="{{@asset('home/images/help_sb1.jpg')}}" width="200" height="170" /></p>
                        <p class="con_txt">上下设备时请站稳扶好护栏</p>
                    </li>
                    <li>
                        <p class="con_img"><img src="{{@asset('home/images/help_sb2.jpg')}}" width="200" height="170" /></p>
                        <p class="con_txt">请不要在设备周围追跑大闹</p>
                    </li>
                    <li>
                        <p class="con_img"><img src="{{@asset('home/images/help_sb3.jpg')}}" width="200" height="170" /></p>
                        <p class="con_txt">未推出科目训练时不可下车防止意外发生</p>
                    </li>
                    <li>
                        <p class="con_img"><img src="{{@asset('home/images/help_sb4.jpg')}}" width="200" height="170" /></p>
                        <p class="con_txt">请勿损坏设备<br/>防止意外发生</p>
                    </li>

                </ul>
            </div>


            <!-- 右侧导航条 -->
            <div class="help_item">
                <ul>
                    <a href="{{url('user/helpShangji')}}"><li class="h_i_li1">上<br/>机<br/>注<br/>意<br/>事<br/>项</li></a>
                    <a href=""><li class="h_i_li2 bg_blue">设<br/>备<br/>注<br/>意<br/>事<br/>项</li></a>
                    <a href="{{url('user/helpXunlian')}}"><li class="h_i_li3">训<br/>练<br/>操<br/>作</li></a>
                    <a href="{{url('user/helpQita')}}"><li class="h_i_li4">其<br/>他</li></a>
                </ul>
            </div>

        </div>
    </div>
    <div class="goback" style="right:275px;bottom:160px;">
        <a href="{{url('user')}}"  onclick="history.back();"><img src="{{@asset('home/images/goback1.png')}}" src_1="{{@asset('home/images/goback1.png')}}" src_2="{{@asset('home/images/goback2.png')}}"></a>
    </div>


    <script type="text/javascript">
        $(document).ready(function(){
            //返回按钮
            myself_hover(".goback img");
            myself_touch(".goback img");
        });
    </script>
@endsection
