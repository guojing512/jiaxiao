<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>VR驾校后台</title>
  <link href="{{@asset('static/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/>
  <link href="{{@asset('static/css/common.css')}}" rel="stylesheet" type="text/css"/>
  <link href="{{@asset('static/css/layout.css')}}" rel="stylesheet" type="text/css"/>
  <link href="{{@asset('static/css/layout01.css')}}" rel="stylesheet" type="text/css"/>


  <script src="{{@asset('static/js/jquery.js')}}"></script>

</head>

<body>
<div class="vr_header_03">
  @section('top')
    @include('manage.common.top')
  @show
</div>

<div class="vr_mian">

  <div class="vr_left">
  @section('left')
    @include('manage.common.left')
  @show
  </div>

  <!-- 内容 -->
  <div class="vr_yu">
    
    <div class="vr_right">

        <div class="vr_biao">
          @include('manage.common.position')
        </div>
        @include('manage.common.message')

        @yield('content','暂无信息')
    </div>
     
  </div>
   <!-- end内容 -->

</div>

<div class="vr_footer">
@section('footer')
版权所有:2016-2020&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;超弦科技有限公司&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;京ICP备16051556号-1
@show
</div>

  <script src="{{@asset('static/js/zd.js')}}"></script>
  <script src="{{@asset('plugins/layer/layer.js')}}"></script>
  <script src="{{@asset('plugins/layer/layer-myself.js')}}"></script>
  <script src="{{@asset('static/js/bootstrap.min.js')}}"></script>

</body>
</html>
