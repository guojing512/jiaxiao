@extends('home.common.layout')
@section('title', '补卡查询-超弦科技')
@section('content')
    
    <div id="main">
        <!-- 用户查询 -->
        <div class="user_sel" @if(isset($user)) style="display:none;" @endif>
            <form id="myForm" action="" method="post">
                <input type="hidden" name="_method" value="post">
                <div>
                    <label for="phone_num" class>手机号</label>
                    <input type="text" name="phone_num" id="phone_num" value="{{isset($user['phone_num'])?$user['phone_num']:old('phone_num')}}" border="0"/>
                </div>

                <p class="error_msg">{{$errors->first('phone_num')?$errors->first('phone_num'):$errors->first('identity_num')}}</p>

                <div>
                    <label for="identity_num">证件号</label>
                    <input type="text" name="identity_num" id="identity_num" value="{{isset($user['identity_num'])?$user['identity_num']:old('identity_num')}}" border="0"/>
                    <input type="hidden"  id="card_num" name="card_num" value="" />
                </div>
                <p class="btn_cha">
                    <a href="{{url("admin")}}" ><img src="{{@asset('home/images/282_fan1.png')}}" src_1="{{@asset('home/images/282_fan1.png')}}" src_2="{{@asset('home/images/282_fan2.png')}}"/></a>
                    <a href="javascript:{do_submit()}" class="user_sel_submit"><img src="{{@asset('home/images/282_dl1.png')}}" src_1="{{@asset('home/images/282_dl1.png')}}" src_2="{{@asset('home/images/282_dl2.png')}}"/></a>
                <p>
            </form>
        </div>

        <!-- 用户信息弹窗 -->
        <div class="user_info_show" @if(isset($user)) style="display:block;" @endif>
            <p><span>编号</span><span>{{isset($user['machine_num'])?$user['machine_num']:""}}</span></p>
            <p><span>姓名</span><span>{{isset($user['real_name'])?$user['real_name']:""}}</span></p>
            <p><span>性别</span><span>{{isset($user['sex'])?$user['sex']=='1'?'男':'女':""}}</span></p>
            <p><span>证件号</span><span>{{isset($user['identity_num'])?$user['identity_num']:""}}</span></p>
            <p><span>手机号</span><span>{{isset($user['phone_num'])?$user['phone_num']:""}}</span></p>
            <div class="btn_buban_verify">
                <a href="javascript:{back1();}" id="btn_info_verify_fan"><img src="{{@asset('home/images/222_fan1.png')}}" src_1="{{@asset('home/images/222_fan1.png')}}" src_2="{{@asset('home/images/222_fan2.png')}}"/></a>
                <a href="javascript:{submit1();}" id="btn_info_verify_ok" class="reg_info_submit"><img src="{{@asset('home/images/222_qr1.png')}}" src_1="{{@asset('home/images/222_qr1.png')}}" src_2="{{@asset('home/images/222_qr2.png')}}"/></a>
            </div>
        </div>

        <!-- 补卡提示弹窗 -->
        <div class="buka_msg">
            <div class="buka_msg_text">
                <p class="bk_text1">补卡操作需要未激活白卡进行操作</p>
                <p class="bk_text1">如已激活卡则不能成功</p>
                <p class="bk_text2">补卡后上一张磁卡予以作废</p>
                <p class="bk_text2">不能继续使用</p>
                <p class="bk_text1">请在<strong><span id="fillCard_djs" style="color:#ff3a3a;">40s</span></strong>内将白卡放到读卡区域进行激活</p>
                <p id="prompt"></p>
            </div>
            <div class="btn_buka_msg">
                <img onclick="back2();" src="{{@asset('home/images/402_fan1.png')}}" src_1="{{@asset('home/images/402_fan1.png')}}" src_2="{{@asset('home/images/402_fan2.png')}}"/>
            </div>
            <input type="button" onclick="pay_card()" value="点击模拟刷卡">
        </div>
        <!-- 补卡成功提示弹窗 -->
        <div class="buka_success_msg" style="display:none;">
            <p>成功激活！</p>
            <p>用户上一张卡已作废</p>
            <div class="btn_buka_ok"><img onclick="goto();" src="{{@asset('home/images/402_fan1.png')}}" src_1="{{@asset('home/images/402_fan1.png')}}" src_2="{{@asset('home/images/402_fan2.png')}}"/></div>
        </div>

    </div>

    <div class="keyboard" @if(isset($user)) style="display:none;" @endif  >
        <img src="{{@asset('home/images/keyboard.jpg')}}" />
    </div>

    <script type="text/javascript">
        function goto(){
            window.location.href = "{{url('admin')}}";
        }
        function pay_card(){
            $("#prompt").html("等待刷卡...<br>");
            $.ajax({
                type: "POST",
                url:"{{url('admin/getCardNum')}}",
                data: "",
                dataType:'json',
                success: function(jsonData){
                    $("#prompt").html($("#prompt").html()+"以获取道卡片号码："+jsonData.data.card_num+"<BR>");
                    console.log(jsonData.data.card_num);
                    $("#card_num").val(jsonData.data.card_num);
                    $("#prompt").html($("#prompt").html()+"正在提交数据，请稍等...<BR>");
                    doFillCard();
                }
            });
        }
        function doFillCard(){
            $.ajax({
                type: "POST",
                url: "{{url('admin/fillCard')}}",
                data: $('#myForm').serialize(),
                dataType:"json",
                success: function(msg){
                    if(msg.flag == 'success'){
                        success();
                    }else{
                        alert("error:"+msg.msg);
                    }
                }
            });
        }
        function do_submit(){
            $("#myForm").submit();
        }
        function back1(){
            $(".user_info_show").hide();
            $(".user_sel").show();
            $(".keyboard").show();
        }
        function submit1(){
            $(".user_info_show").hide();
            $(".buka_msg").show();
            countdown("#fillCard_djs",40,function(){
                window.location.href = "{{url('admin')}}";
            });
        }
        function back2(){
            $(".buka_msg").hide();
            $(".user_info_show").show();
        }
        function success(){
            $(".buka_msg").hide();
            $(".buka_success_msg").show();

        }
        $(document).ready(function(){
            myself_hover(".user_sel form p img");
            myself_touch(".user_sel form p img");

            myself_hover(".btn_buban_verify img");
            myself_touch(".btn_buban_verify img");

            myself_hover(".btn_buka_msg img");
            myself_touch(".btn_buka_msg img");

            myself_hover(".btn_buka_ok img");
            myself_touch(".btn_buka_ok img");
        });
    </script>
@endsection
