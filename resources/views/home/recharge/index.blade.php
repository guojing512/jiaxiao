@extends('home.common.layout')
@section('title', '充值')
@section('content')
<div id="main">

		<div class="cz_user">
			<div class="cz_user_icon">
				<img src="{{@asset('home/images/head_icon.png')}}"/>
				<p>{{$info['nickname']}}</p>
			</div>

			<div class="cz_user_info">
				<div class="u_i_left">
					<p class="cz_ui_p1">证件号</p>
					<p class="cz_ui_p2">{{$info['identity_num']}}</p>
				</div>
				<div class="u_i_right">
					<p class="cz_ui_p1">剩余时长</p>
					<p class="cz_ui_p2">{{getFriendTime($info['remaining_time'],'m')}}分钟</p>
				</div>

				<div class="tiao_cz_user"></div>

			</div>

			<form action="{{url('rechQrCode')}}" method="post" id="form_cz">

				<div class="pay_num">
					<ul>
						<li val="0.01"><p class="pm_t1">60分钟</p><p class="pm_t2">售价：60元</p></li>
						<li val="120"><p class="pm_t1">120分钟</p><p class="pm_t2">售价：120元</p></li>
						<li val="300"><p class="pm_t1">300分钟</p><p class="pm_t2">售价：300元</p></li>
						<li val="600"><p class="pm_t1">600分钟</p><p class="pm_t2">售价：600元</p></li>
					</ul>
				</div>

				<div class="cz_pay_type">
					<div class="pay_type pay_zfb" val="1">
						<div class="pay_logo"><img src="{{@asset('home/images/pay_zfb.png')}}" width="80" height="80"/></div>
						<p class="pay_txt1">支付宝钱包支付</p>
						<p class="pay_txt2">推荐支付宝用户使用</p>
						<div class="pay_select"><img src="{{@asset('home/images/select.png')}}" src_1="{{@asset('home/images/not_select.png')}}" src_2="{{@asset('home/images/select.png')}}"/></div>
					</div>

					<div class="pay_type pay_wx" val="2">
						<div class="pay_logo"><img src="{{@asset('home/images/pay_wx.png')}}" width="80" height="80" /></div>
						<p class="pay_txt1">微信钱包支付</p>
						<p class="pay_txt2">推荐微信用户使用</p>
						<div class="pay_select"><img src="{{@asset('home/images/not_select.png')}}" src_1="{{@asset('home/images/not_select.png')}}" src_2="{{@asset('home/images/select.png')}}"/></div>
					</div>
				</div>

				<input type="hidden" id="cz_money" name="money" value="120" />
				<input type="hidden" id="pay_type" name="pay_type" value="1" />
				<input type="hidden" name="group_id" value="3" />

			</form>

			<p class="btn_cz">
				<a href="javascript:;" onclick="history.back()"><img src="{{@asset('home/images/282_fang_fan1.png')}}" src_1="{{@asset('home/images/282_fang_fan1.png')}}" src_2="{{@asset('home/images/282_fang_fan2.png')}}"/></a>

				<a href="javascript:;" id="submit_cz"><img src="{{@asset('home/images/282_cz1.png')}}" src_1="{{@asset('home/images/282_cz1.png')}}" src_2="{{@asset('home/images/282_cz2.png')}}"/></a>
			<p>

		</div>
	</div>

	<script type="text/javascript">
		myself_hover(".btn_cz a img");
		myself_touch(".btn_cz a img");
	</script>
	<script type="text/javascript">

		$(function(){
			//选择支付方式
			$(".pay_type").on("click",function(){
				var src_1 = $(".pay_wx .pay_select img").attr("src_1");
				var src_2 = $(".pay_wx .pay_select img").attr("src_2");
				var curr_val = $(this).attr("val");

				$(this).siblings(".pay_type").find(".pay_select img").attr("src",src_1);
				$(this).find(".pay_select img").attr("src",src_2);

				if(curr_val == '1'){
					$(this).attr("val","2");
					$("#pay_type").val("1");
					$(this).css({"border":"solid 2px #3393ed"});

				}else{
					$(this).attr("val","1");
					$("#pay_type").val("2");
					$(this).siblings(".pay_type").css({"border":"solid 2px #c8c8c8"});
				}
			});

			//充值金额pay_num
			$(".pay_num ul li").on("click",function(){

				var curr_val = $(this).attr("val");
				$("#cz_money").val(curr_val);
				$(this).siblings("li").css({"border":"solid 2px #c8c8c8"});
				$(".pm_t1").css({"color":"#323232"});
				$(".pm_t2").css({"color":"#505050"});

				$(this).css({"border":"solid 2px #3393ed"});
				$(this).find("p").css({"color":"#3393ed"});

			});

			//充值提交
			var is_submit = false;
			$("#submit_cz").on("click",function(){
				if(!is_submit){
					$("#form_cz").submit();
					is_submit = true;
				}
			});

		});

		//初始化支付类型和充值金额
		$(function(){
			//支付类型
			var src_1 = $(".pay_wx .pay_select img").attr("src_1");
			var src_2 = $(".pay_wx .pay_select img").attr("src_2");

			if($("#pay_type").val() == '1'){
				$(".cz_pay_type .pay_type").css({"border":"solid 2px #c8c8c8"});
				$(".cz_pay_type .pay_type:nth-child(1)").css({"border":"solid 2px #3393ed"});
				$(".pay_select img").attr("src",src_1);
				$(".pay_select:eq(0) img").attr("src",src_2);

				
			}else if($("#pay_type").val() == '2'){
				$(".cz_pay_type .pay_type").css({"border":"solid 2px #c8c8c8"});
				$(".cz_pay_type .pay_type:nth-child(2)").css({"border":"solid 2px #3393ed"});
				$(".pay_select img").attr("src",src_1);
				$(".pay_select:eq(1) img").attr("src",src_2);
			}

			//金额默认样式
			for(var n = 0; n < $(".pay_num ul li").length; n++){

				if($("#cz_money").val() == $(".pay_num ul li:eq("+n+")").attr("val")){
					$(".pay_num ul li:eq("+n+")").css({"border":"solid 2px #3393ed"});
					$(".pay_num ul li:eq("+n+")").find("p").css({"color":"#3393ed"});
				}else{
					$(".pay_num ul li:eq("+n+")").css({"border":"solid 2px #c8c8c8"});
					$(".pay_num ul li:eq("+n+") .pm_t1").css({"color":"#323232"});
					$(".pay_num ul li:eq("+n+") .pm_t2").css({"color":"#505050"});
				}
			}

		});



	</script>
@endsection


