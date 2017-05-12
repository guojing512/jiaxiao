@extends('home.common.layout')
@section('title', '登录-超弦科技')
@section('content')
    <div id="main">
        <div class="user_sel">
            <form id="myForm" action="" method="post">
                <input type="hidden" name="_method" value="post">
                <div>
                    <label for="phone_num" class>手机号</label>
                    <input type="text" name="phone_num" id="phone_num" border="0"/>
                </div>

                <p class="error_msg">{{$errors->first('phone_num')}}</p>

                <div>
                    <label for="identity_num">证件号</label>
                    <input type="text" name="identity_num" id="identity_num" border="0"/>
                </div>
                <p class="btn_cha">
                    <a href="{{url("/")}}" ><img src="{{@asset('home/images/282_fan1.png')}}" src_1="{{@asset('home/images/282_fan1.png')}}" src_2="{{@asset('home/images/282_fan2.png')}}"/></a>

                    <a href="javascript:{do_submit()}" class="user_sel_submit"><img src="{{@asset('home/images/282_dl1.png')}}" src_1="{{@asset('home/images/282_dl1.png')}}" src_2="{{@asset('home/images/282_dl2.png')}}"/></a>
                <p>

            </form>
        </div>

    </div>
    <div class="progress_bar bar_html5"></div>
    <div class="keyboard">
        <img src="{{@asset('home/images/keyboard.jpg')}}" />
    </div>
    <script type="text/javascript">
        function do_submit(){
            $("#myForm").submit();
        }
        $(document).ready(function(){
            myself_hover(".user_sel form p img");
            myself_touch(".user_sel form p img");
        });
    </script>
@endsection
