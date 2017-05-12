@extends('home.common.layout')
@section('title', '帮助-训练操作-超弦科技')

@section('content')
    <div id="main">
        <div class="help_sj help_main">

            <div class="help_con">
                <ul>
                    <li>
                        <p class="con_img"><img src="{{@asset('home/images/help_xl1.jpg')}}" width="200" height="170" /></p>
                        <p class="con_txt">调整头盔松紧、大小，正确佩戴头盔</p>
                    </li>
                    <li>
                        <p class="con_img"><img src="{{@asset('home/images/help_xl2.jpg')}}" width="200" height="170" /></p>
                        <p class="con_txt">与手动挡一致自动挡可忽略离合器</p>
                    </li>
                    <li>
                        <p class="con_img"><img src="{{@asset('home/images/help_xl3.jpg')}}" width="200" height="170" /></p>
                        <p class="con_txt">开始训练时放手刹否则车体不会移动</p>
                    </li>
                    <li>
                        <p class="con_img"><img src="{{@asset('home/images/help_xl4.jpg')}}" width="200" height="170" /></p>
                        <p class="con_txt">保持驾驶时握把姿势</p>
                    </li>
                    <li>
                        <p class="con_img"><img src="{{@asset('home/images/help_xl5.jpg')}}" width="200" height="170" /></p>
                        <p class="con_txt">选择内容眼睛请直视一段时间</p>
                    </li>
                </ul>
            </div>


            <!-- 右侧导航条 -->
            <div class="help_item">
                <ul>
                    <a href="{{url('user/helpShangji')}}"><li class="h_i_li1">上<br/>机<br/>注<br/>意<br/>事<br/>项</li></a>
                    <a href="{{url('user/helpShebei')}}"><li class="h_i_li2">设<br/>备<br/>注<br/>意<br/>事<br/>项</li></a>
                    <a href=""><li class="h_i_li3 bg_blue">训<br/>练<br/>操<br/>作</li></a>
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
