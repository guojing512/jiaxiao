@extends('home.common.layout')
@section('title', '管理员充值')
@section('content')
<div id="main">
	<div class="cz_admin">
		<div class="cz_admin_icon"><img src="{{@asset('home/images/cz_admin.png')}}"/></div>

		<div class="cz_admin_info">
			<div class="a_i_left">
				<p class="cz_ai_p1">管理员卡号</p>
				<p class="cz_ai_p2">{{$info['identity_num']}}</p>
			</div>
			<div class="a_i_right">
				<p class="cz_ai_p1">剩余时长</p>
				<p class="cz_ai_p2">{{getFriendTime($info['available_time'],'friend')}}</p>
			</div>

			<div class="tiao_cz_admin"></div>

		</div>

		<form action="{{url('rechQrCodeAdmin')}}" method="post" id="form_cz">
			<div class="buy_time">
				<label for="buy_time">购买数量<br/>(小时)</label>
				<input type="text" name="buy_time" id="buy_time" placeholder="最少充值1小时以上" maxlength="8"/>

				<div class="buy_time_money"></div>
			</div>

			

			<div class="cz_pay_type">
				<div class="pay_type pay_zfb" val="2">
					<div class="pay_logo"><img src="{{@asset('home/images/pay_zfb.png')}}" width="80" height="80"/></div>
					<p class="pay_txt1">支付宝钱包支付</p>
					<p class="pay_txt2">推荐支付宝用户使用</p>
					<div class="pay_select"><img src="{{@asset('home/images/select.png')}}" src_1="images/not_select.png')}}" src_2="images/select.png')}}"/></div>
				</div>
				<div class="pay_type pay_wx" val="2">
					<div class="pay_logo"><img src="{{@asset('home/images/pay_wx.png')}}" width="80" height="80" /></div>
					<p class="pay_txt1">微信钱包支付</p>
					<p class="pay_txt2">推荐微信用户使用</p>
					<div class="pay_select"><img src="{{@asset('home/images/not_select.png')}}" src_1="{{@asset('home/images/not_select.png')}}" src_2="{{@asset('home/images/select.png')}}"/></div>
				</div>
			</div>

			<input type="hidden" id="pay_type" name="pay_type" value="1" />
			<input type="hidden" name="group_id" value="2" />

		</form>

		<p class="btn_cz">
			<a href="{{url('admin')}}" ><img src="{{@asset('home/images/282_fang_fan1.png')}}" src_1="{{@asset('home/images/282_fang_fan1.png')}}" src_2="{{@asset('home/images/282_fang_fan2.png')}}"/></a>

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

		var src_1 = $(".pay_wx .pay_select img").attr("src_1");
		var src_2 = $(".pay_wx .pay_select img").attr("src_2");
		//选择支付方式
		$(".pay_type").on("click",function(){
			
			var curr_val = $(this).attr("val");

			for(var i = 0; i < $(".pay_type").length; i++){
				$(".pay_type").find(".pay_select img").attr("src",src_1);
				$(".pay_type").css({"border":"solid 2px #c8c8c8"});
			}

			$(this).find(".pay_select img").attr("src",src_2);
			$(this).css({"border":"solid 2px #3393ed"});
			$("#pay_type").val(curr_val);

		});


		//buy_time_money

		$("#buy_time").on("blur",function(){
			if($(this).val() >= 1){
				var money = "{{config('other.TIME_HOUR_TO_MONEY')}}";
				$(".buy_time_money").html(money*$(this).val() + '元');
			}else{
				$(".buy_time_money").html('');
			}
		});

		//充值提交
		var is_submit = false;
		$("#submit_cz").on("click",function(){

			if($("#buy_time").val() == ''){
				alert('请填写购买小时数量');
				return;
			}
			if($("#buy_time").val() < 1){
				alert('购买数量最少为1小时');
				return;
			}

			var re = /^[1-9]{1}\d{0,7}$/
			if(!re.test($("#buy_time").val())){
				alert('输入格式错误');
				$("#buy_time").val('');
				return;
			}

			if(!is_submit){
				$("#form_cz").submit();
				is_submit = true;
			}
		});

	});
</script>
@endsection


