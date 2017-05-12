<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8"/>
  <title>@yield('title')</title>
  <meta name="machine_mac" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <link rel="stylesheet" type="text/css" href="{{@asset('home/css/reset.css')}}">
  <link rel="stylesheet" type="text/css" href="{{@asset('home/css/common.css')}}">
  <script type="text/javascript" src="{{@asset('home/js/jquery.js')}}"></script>
  <script type="text/javascript" src="{{@asset('home/js/js.js')}}"></script>
  <script type="text/javascript" src="{{@asset('home/js/drivingschool.js')}}"></script>
</head>
<body>
<div id="wrapper">
  <div id="header">
    @include('home.common.head')
  </div>
  @yield('content')
</div>
<script type="text/javascript" src="{{@asset('home/js/jquery.cookie.js')}}"></script>
<script type="text/javascript" src="{{@asset('home/js/jquery.timers.min.js')}}"></script>
<script>
    $(document).ready(function() {
        var machine_num_cookie =$.cookie('machine_num');
        $('body').everyTime('2s','machine_timer',function(){
            if(typeof(machine_num_cookie) == 'undefined' || machine_num_cookie == ""){
                console.log("正在获取设备编号");
                var machine_mac = $("meta[name='machine_mac']").attr('content');
                if(machine_mac != ""){
                    $.ajax({
                        type: "POST",
                        url:"{{action('Api\MachineController@getMachineByMac')}}",
                        data:"mac="+machine_mac,
                        dataType:'json',
                        success: function(jsonData){
                            if(jsonData.flag == "success"){
                                console.log("设备编号获取成功：" + jsonData.data.machine_num);
                                $('body').stopTime ('machine_timer')
                            }else{
                                console.log(jsonData.msg);
                            }
                        }
                    });
                }
            }else{
                $('body').stopTime ('machine_timer');
            }
        });
        setTimeout(function(){
            $("meta[name='machine_mac']").attr('content',"9d-er-9o-dd-4r");
        },1000);

    });
</script>

</body>
</html>