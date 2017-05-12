@extends('home.common.layout')
@section('title', '支付-管理员')
@section('content')
	<div id="main">
		<div class="cz_ewm">
			<div class="ewm_con">
				<div class="ewm_img">{!!$info['ewm']!!}</div>
				<div class="ewm_txt">
					<p class="ewmp1">
						<span style="display:block;width:112px;float:left;">证件号</span>{{$info['identity_num']}}<br/>
						<span style="display:block;width:150px;float:left;">剩余时长</span>{{getFriendTime($info['available_time'],'friend')}}
					</p>
					<p class="ewmp2">
						<span style="display:block;width:150px;float:left;">充值时长</span>{{getFriendTime($info['recharge_time'],'friend')}}<br/>
						<span style="display:block;width:150px;float:left;">充值金额</span><span style="color:#ff3a3a;">{{$info['recharge_money']}}</span>元
					</p>
				</div>
				<div class="btn_ewm">
					<h3><img src="{{@asset('home/images/cz_jt.png')}}" width="25" height="25" /><!-- 请扫描二维码 -->{{$info['pay_type'] == 1?'支付宝扫一扫':'微信扫一扫'}}</h3>
					<p><a href="{{url('rechAdmin')}}" ><img src="{{@asset('home/images/162_fan1.png')}}" src_1="{{@asset('home/images/162_fan1.png')}}" src_2="{{@asset('home/images/162_fan2.png')}}"/></a></p>
				</div>
			</div>
		</div>
		<input type="hidden" id="rid" name="rid" value="{{$info['rid']}}">
	</div>

	<script type="text/javascript">
		myself_hover(".btn_ewm p img");
		myself_touch(".btn_ewm p img");
	</script>

	<script type="text/javascript">
		setInterval(function(){
			var rid = $("#rid").val();
			$.post("{{url('rechStatueAdmin')}}",{rid:rid},function(data){
				//console.log(data);
				if(data == '1'){
					window.location.href = "{{url('rechAdmin')}}";
				}
			});

		},3000);
	</script>

@endsection



