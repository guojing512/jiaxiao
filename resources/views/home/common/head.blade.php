
<?php
	$s_user = session()->get(config('other.HOME_SESSION_USER_NAME'));
	//dump($s_user);
?>

@if(!empty($s_user) && isset($s_user['group_id']) && $s_user['group_id'] == 2)
    <div class="user_info">
    <p class="logout"><a href="{{url('logout')}}"><img src="{{@asset('home/images/logout.png')}}" width="32" height="32" /></a></p>
    <p class="user_content">设备编号：@yield('subject_num')</p>
</div>
<script>
    $(document).ready(function(){
        if($.cookie("machine_num")){
            $(".user_info").find("p[class='user_content']").html("设备编号："+$.cookie("machine_num"));
        }
    });
</script>
@elseif(!empty($s_user) && isset($s_user['group_id']) && $s_user['group_id'] == 3)
<div class="user_info">
    <p class="logout"><a href="{{url('logout')}}"><img src="{{@asset('home/images/logout.png')}}" width="32" height="32" /></a></p>
    <p class="user_content"><img src="{{@asset('home/images/head_icon.png')}}" width="40" height="40" />您好，{{$s_user['real_name']}}</p>
</div>
@else
  
@endif
