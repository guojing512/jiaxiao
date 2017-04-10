<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>VR驾校后台_登陆</title>
<link href="{{@asset('static/css/common.css')}}" rel="stylesheet" type="text/css" media="all" />
<link href="{{@asset('static/css/layout01.css')}}" rel="stylesheet" type="text/css" media="all" />
</head>
<style>
    .error{
        font-size: 12px;
        color: red;
        width:auto;
        height: 20px;
    }
</style>
<body>
<div class="vr_header01"><a href=""><img src="{{@asset('static/images/logo.png')}}" width="200" height="34" alt=""/></a></div>
<div class="clear"></div>
<form method="post">
    {{ csrf_field() }}
    <div class="vr_land">
        <div class="land_main">
            <div>
                <h3>用户登录</h3>
                <ul>
                    @if($errors && $errors->first())
                        <h1 id="error_message" class="error">{{ $errors->first() }}</h1>
                    @endif
                    <li><label><img src="{{@asset('static/images/land01.jpg')}}" alt=""/></label><input name="username" value="{{ old('username') }}" type="text" class="land_in01" placeholder="请输入用户名" /></li>
                    <li><label><img src="{{@asset('static/images/land02.jpg')}}" alt=""/></label><input name="password" value="{{ old('password') }}" type="text" class="land_in01" placeholder="请输入密码" /></li>
                    <li><label><img src="{{@asset('static/images/land03.jpg')}}" alt=""/></label><input name="captcha" type="text" class="land_in02" placeholder="请输入验证码" /></li>
                    <img src="{{ url('/captcha') }}" width="100" height="40" id="captcha_img" onclick="re_captcha(this);"/>
                </ul>
                <input name="" type="submit" class="land_in03" value="登录" />
                <p><a href="">忘记密码？</a></p>
            </div>
        </div>
    </div>
</form>
<div class="clear"></div>
<div class="vr_footer">版权所有:2016-2020&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;超弦科技有限公司&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;京ICP备16051556号-1</div>
<div class="clear"></div>

<script src="{{@asset('static/js/jquery.js')}}"></script>
<script>
    function close_error_msg(){
        $("#error_message").hide();
    }
    $("#captcha_img").click(function(){
        $(this).attr('src',$(this).attr('src')+"?"+Math.random());
    });
    $("form input").bind("input propertychange",function(){
        close_error_msg();
    });
</script>
</body>
</html>
