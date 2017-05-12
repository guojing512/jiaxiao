@extends('home.common.layout')
@section('title', '帮助-上机注意事项-超弦科技')

@section('content')
    <div id="main">
        <div class="help_sj help_main">

            <div class="sj_con">
                <div class="h_sj_img"><img src="{{@asset('home/images/help_sj1.jpg')}}"/></div>
                <p>1. 上机后请调整座椅位置，以舒适为准</p>
                <p>2. 请系上安全带，否则训练无法启动</p>
                <p class="h_sj_zhu">注：在驾驶中正确系上安全带可在车祸中提升54%的存活率</p>
            </div>

            <!-- 右侧导航条 -->
            <div class="help_item">
                <ul>
                    <a href=""><li class="h_i_li1 bg_blue">上<br/>机<br/>注<br/>意<br/>事<br/>项</li></a>
                    <a href="{{url('user/helpShebei')}}"><li class="h_i_li2">设<br/>备<br/>注<br/>意<br/>事<br/>项</li></a>
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
