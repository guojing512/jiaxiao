@extends('home.common.layout')
@section('title', '帮助-其他-超弦科技')

@section('content')
    <div id="main">
        <div class="help_sj help_main">

            <div class="help_con">
                <ul>
                    <li>
                        <p class="con_img"><img src="{{@asset('home/images/help_qt1.jpg')}}" width="200" height="170" /></p>
                        <p class="con_txt">出现不适感请下机休息</p>
                    </li>
                    <li>
                        <p class="con_img"><img src="{{@asset('home/images/help_qt2.jpg')}}" width="200" height="170" /></p>
                        <p class="con_txt">每半小时训练请休息5-10分钟</p>
                    </li>
                    <li>
                        <p class="con_img"><img src="{{@asset('home/images/help_qt3.jpg')}}" width="200" height="170" /></p>
                        <p class="con_txt">心脏病、高血压等请不要上机训练</p>
                    </li>

                </ul>
            </div>


            <!-- 右侧导航条 -->
            <div class="help_item">
                <ul>
                    <a href="{{url('user/helpShangji')}}"><li class="h_i_li1">上<br/>机<br/>注<br/>意<br/>事<br/>项</li></a>
                    <a href="{{url('user/helpShebei')}}"><li class="h_i_li2">设<br/>备<br/>注<br/>意<br/>事<br/>项</li></a>
                    <a href="{{url('user/helpXunlian')}}"><li class="h_i_li3">训<br/>练<br/>操<br/>作</li></a>
                    <a href=""><li class="h_i_li4 bg_blue">其<br/>他</li></a>
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
