@extends('home.common.layout')
@section('title', '登录-超弦科技')
@section('content')

  <div id="main">
    
    <div class="user_register" style="display:none;">
      <form id="myForm" action="" method="post">
        <input type="hidden" name="_method" value="post">
        <input type="hidden" name="register_type" value="by_phone">
        <div class="input_border">
          <label for="real_name" class>姓名</label>
          <input type="text" name="real_name" id="real_name" value="{{ old('real_name') }}" border="0"/>
          <p class="reg_error_msg">{{$errors->first('real_name')}}</p>
        </div>

        <div class="u_r_sex">
          <ul>
            <li class="input_border" val="1" @if(!old('sex') || old('sex') == '1') checked="checked" @endif >男</li>
            <li class="input_border" val="2" @if(old('sex') == '2') checked="checked" @endif>女</li>
          </ul>
          <input type="hidden" id="u_sex" name="sex" value="{{old('sex')?old('sex'):1}}"  />
        </div>

        <div class="input_border">
          <label for="phone_num" class>手机号</label>
          <input type="text" name="phone_num" id="phone_num" value="{{ old('phone_num') }}" border="0"/>
          <p class="reg_error_msg">{{$errors->first('phone_num')}}</p>
        </div>

        <div class="u_r_identity">
          <ul>
            <li class="input_border" val="1" @if(!old('identity_type') || old('identity_type') == '1') checked="checked" @endif>身份证</li>
            <li class="input_border" val="2" @if(old('identity_type') == '2') checked="checked" @endif>军官证</li>
            <li class="input_border" val="3" @if(old('identity_type') == '3') checked="checked" @endif>护照</li>
          </ul>
          <input type="hidden" name="identity_type" id="u_identity" value="{{old('identity_type')?old('identity_type'):1}}"  />
        </div>

        <div class="input_border">
          <label for="identity_num">证件号</label>
          <input type="text" name="identity_num" id="identity_num" value="{{ old('identity_num') }}" border="0"/>
          <p class="reg_error_msg">{{$errors->first('identity_num')}}</p>
        </div>

        <p class="select_agree"  @if(!old('flag_give_time') || old('flag_give_time') == '0') val="0" @else val="1" @endif>
            <img src="@if(!old('flag_give_time') || old('flag_give_time') == '0'){{@asset('home/images/not_select.png')}}@else{{@asset('home/images/select.png')}}@endif" src_1="{{@asset('home/images/not_select.png')}}" src_2="{{@asset('home/images/select.png')}}"/>
            <span>参与VR驾校体验计划</span>
        </p>
        <div class="present_time input_border" @if(old('flag_give_time') == '1') style="display:block;" @endif>
          <label for="give_time">赠送时长</label>
          <input type="text" name="give_time" id="give_time" value="{{ old('give_time') }}" border="0"/>
          <input type="hidden" name="flag_give_time" id="flag_give_time"  value="{{ old('flag_give_time') }}"/>
          <p class="reg_error_msg">{{$errors->first('give_time')}}</p>
        </div>
        <input type="hidden"  id="card_num" name="card_num" value="" />
        <input type="hidden"  id="is_valid" name="is_valid" @if(count($errors->all()) == 1 && $errors->first('is_valid')) value="{{$errors->first('is_valid')}}" @endif />

        <p class="click_img">
          <a href="javascript:{history.back()};"><img src="{{@asset('home/images/282_fan1.png')}}" src_1="{{@asset('home/images/282_fan1.png')}}" src_2="{{@asset('home/images/282_fan2.png')}}"/></a>
          <a href="javascript:{before_register();}" class="reg_user_info"><img src="{{@asset('home/images/282_tijiao1.png')}}" src_1="{{@asset('home/images/282_tijiao1.png')}}" src_2="{{@asset('home/images/282_tijiao2.png')}}"/></a>
        <p>

      </form>
    </div>
    <!-- 信息确认 -->
    <div class="reg_info" style="display:none;">
      <div class="reg_info_verify">
        <div class="reg_head_icon"><img src="{{@asset('home/images/head_icon.png')}}"/></div>
        <div class="reg_text">
          <p><span>姓名</span><span>王者农药</span></p>
          <p><span>性别</span><span>男</span></p>
          <p><span>出生日期</span><span>2011/11/11</span></p>
          <p><span>电话</span><span>18812345678</span></p>
          <p><span>身份证</span><span>130533121212123333</span></p>
          <p><span>赠送时长</span><span><strong class="red_text1">999</strong>小时</span></p>
        </div>
      </div>

      <div class="reg_info_button">
        <a href="javascript:{back1()};" ><img src="{{@asset('home/images/282_fan1.png')}}" src_1="{{@asset('home/images/282_fan1.png')}}" src_2="{{@asset('home/images/282_fan2.png')}}"/></a>

        <a href="javascript:{submit1()};" class="reg_info_submit"><img src="{{@asset('home/images/282_tijiao1.png')}}" src_1="{{@asset('home/images/282_tijiao1.png')}}" src_2="{{@asset('home/images/282_tijiao2.png')}}"/></a>
      </div>
    </div>
    <!-- 信息提示弹窗 -->
    <div class="submit_verify" style="display:none;">
        <div class="verify_text">
            <h5>提示</h5>
            <p>注册当前信息后无法进行相应的修改如确认无误后，请点击“确认”，填写有误请返回</p>
        </div>
        <div class="btn_info_verify">
            <a href="javascript:{back2()};" id="btn_info_verify_fan"><img src="{{@asset('home/images/222_fan1.png')}}" src_1="{{@asset('home/images/222_fan1.png')}}" src_2="{{@asset('home/images/222_fan2.png')}}"/></a>

            <a href="javascript:{submit2()}" id="btn_info_verify_ok" class="reg_info_submit"><img src="{{@asset('home/images/222_qr1.png')}}" src_1="{{@asset('home/images/222_qr1.png')}}" src_2="{{@asset('home/images/222_qr2.png')}}"/></a>

        </div>
    </div>
    <!-- 刷卡（写卡）提示 -->
    <div class="write_card" style="display:none;">
        <div class="w_c_text">
            <p>请将待激活卡放置刷磁区</p>
            <p>激活卡时请不要拿下磁卡</p>
            <p><span id="fillCard_djs">60s</span>内未操作所有信息不会保存</p>
            <p id="prompt"></p>
        </div>
        <div class="w_c_btn">
            <img onclick="back3();" src="{{@asset('home/images/402_fan1.png')}}" src_1="{{@asset('home/images/402_fan1.png')}}" src_2="{{@asset('home/images/402_fan2.png')}}"/>
        </div>
        <input type="button" onclick="pay_card()" value="点击模拟刷卡">
    </div>
  </div>
  <div class="keyboard">
    <img src="{{@asset('home/images/keyboard.jpg')}}" />
  </div>
  <script>
      function pay_card(){
          $("#prompt").html("等待刷卡...<br>");
          $.ajax({
              type: "POST",
              url:"{{url('admin/getCardNum')}}",
              data: "",
              dataType:'json',
              success: function(jsonData){
                  $("#prompt").html($("#prompt").html()+"以获取道卡片号码："+jsonData.data.card_num+"<BR>");
                  $("#card_num").val(jsonData.data.card_num);
                  $("#prompt").html($("#prompt").html()+"正在提交数据，请稍等...<BR>");
                  $("#myForm").submit();
              }
          });
      }


      function before_register(){
          $("#myForm").submit();
      }
      function submit1(){
          $(".reg_info").hide();
          $(".submit_verify").show();
      }
      function back1(){
          $("#is_valid").attr("value","");
          $(".user_register").show();
          $(".keyboard").show();
          $(".reg_info").hide();
      }
      function submit2(){
          $(".write_card").show();
          $(".submit_verify").hide();
          countdown("#fillCard_djs",60,function(){
              window.location.href = "{{url('admin')}}";
          });
      }
      function back2(){
          show_info();
          $(".submit_verify").hide();
      }
      function back3(){
          $(".write_card").hide();
          $(".submit_verify").show();
      }
      function show_info(){
          $(".user_register").hide();
          $(".keyboard").hide();
          $(".reg_info").show();
          var sex = "男";
          var give_time = "0";
          if($("#u_sex").val() == 2){
              sex = "女";
          }
          if($("#give_time").val()){
              give_time = $("#give_time").val();
          }
          var info_html = "<p><span>姓名</span><span>"+$("#real_name").val()+"</span></p>"+
              "<p><span>性别</span><span>"+sex+"</span></p>"+
              "<p><span>电话</span><span>"+$("#phone_num").val()+"</span></p>"+
              "<p><span>身份证</span><span>"+$("#identity_num").val()+"</span></p>"+
              "<p><span>赠送时长</span><span><strong class='red_text1'>"+give_time+"</strong> 小时</span></p>";
          $(".reg_info").find("div[class='reg_text']").html(info_html);
      }
  </script>
  <script type="text/javascript">
      $(document).ready(function(){
          myself_hover(".click_img a img");
          myself_touch(".click_img a img");

          myself_hover(".reg_info_button a img");
          myself_touch(".reg_info_button a img");

          myself_hover(".btn_info_verify a img");
          myself_touch(".btn_info_verify a img");

          myself_hover(".w_c_btn img");
          myself_touch(".w_c_btn img");


          $("form input").bind("input propertychange",function(){
              $("p[class='reg_error_msg']").hide();
          });
          //性别
          $(".u_r_sex ul li").on("click",function(){
              var curr_val = $(this).attr("val");
              $("#u_sex").val(curr_val);
              $(this).css({"background":"#3393ed","color":"#fff"});
              $(this).siblings().css({"background":"#fff","color":"#646464"});
          });
          $(".u_r_sex ul li").each(function () {
              if($(this).attr('checked') == "checked"){
                  $(this).click();
              }
          });
          //证件类型
          $(".u_r_identity ul li").on("click",function(){
              var curr_val = $(this).attr("val");
              $("#u_identity").val(curr_val);
              $(this).css({"background":"#3393ed","color":"#fff"});
              $(this).siblings().css({"background":"#fff","color":"#646464"});
          });
          $(".u_r_identity ul li").each(function () {
              if($(this).attr('checked') == "checked"){
                  $(this).click();
              }
          });


          //体检计划
          $(".select_agree").on("click",function(){
              var curr_val = $(this).attr("val");
              var img_orig = $(this).find("img").attr("src_1");
              var img_replace = $(this).find("img").attr("src_2");
              if(curr_val == '0'){
                  $(this).attr("val",1)
                  $("#flag_give_time").attr("value",1)
                  $(this).find("img").attr("src",img_replace);
                  $(".keyboard").css({"display":"none"});
                  $(".present_time").css({"display":"block"});
              }else{
                  $(this).attr("val",0)
                  $("#flag_give_time").attr("value",0)
                  $(this).find("img").attr("src",img_orig);
                  $(".present_time").css({"display":"none"});
                  $("#give_time").val('');
              }
          });
          if($("#is_valid").val() == ""){
              $(".user_register").show();
          }else if($("#is_valid").val() == "success"){
              show_info();
          }else{
              $(".write_card").show();
              $("#prompt").html($("#is_valid").val()+"<BR>");
          }
      });
  </script>
@endsection
