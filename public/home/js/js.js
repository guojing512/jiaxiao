
//跑马灯
$(function(){
	var lf_con = $(".l_f1_1").html();
	$(".l_f1_1").append(lf_con);
});
function login_gundong(){
	var curr_width = $(".l_f1_1 p").width();
	//alert(curr_width);
	if($(".l_f1").scrollLeft() >= curr_width){
		$(".l_f1").scrollLeft(0);
	}else{
		$
		var curr_scroll = $(".l_f1").scrollLeft();
		curr_scroll = curr_scroll + 1;
		$(".l_f1").scrollLeft(curr_scroll)
	}
}
//跑马灯end


//登录界面
$(function(){
	//活动展示效果
	if($("div").hasClass("login_top1")){
		
		$(".login_top1").on("click",function(){
			//$(this).css({"display":"none"});
			$(".login_top2").slideDown(500);
		});

		$(".lg_slide_up").on("click",function(){
			$(".login_top2").slideUp(500);
			//$(".login_top1").css({"display":"block"});
		});
	}

	//刷卡登录提示显示
	$("#card_entry").on("click",function(){
		$(".lg_msg").css({"display":"block"});
		$(".fugaiqu").css({"display":"block"});
	});
	//刷卡登录提示隐藏
	$(".fugaiqu").on("click",function(){
		$(".lg_msg").css({"display":"none"});
		$(".fugaiqu").css({"display":"none"});
	});

});


//课程展示页
$(function(){

	// 科目三点击进入
	// 滑动效果
	$(".course3_info ul li a span").hover(function(){
		var replace_src = $(this).find("img").attr("src_2");
		$(this).find("img").attr("src",replace_src);
		$(this).css({"color":"#236098"});

	},function(){
		var curr_src = $(this).find("img").attr("src_1");
		$(this).find("img").attr("src",curr_src);
		$(this).css({"color":"#3393ed"});
	});

	//触控效果
	$(".a_p_li a img").on("touchstart",function(){
		var replace_src = $(this).find("img").attr("src_2");
		$(this).find("img").attr("src",replace_src);
		$(this).css({"color":"#236098"});
	});
	$(".a_p_li a img").on("touchend",function(){
		var curr_src = $(this).find("img").attr("src_1");
		$(this).find("img").attr("src",curr_src);
		$(this).css({"color":"#3393ed"});
	});

});


/*
	滑动滑出效果
	@param obj 触控区域节点元素 在改节点元素上需要设置属性src_1,src_2用于切换的图片路径
	@param color1 color2都传入的话并且是色标如（#fff），默认改的是节点元素的背景颜色，也可以是对象.1为初始颜色 2改变效果颜色
*/
function myself_hover(obj,color1,color2){

	$(obj).hover(function()
	{

		if(color2){
			if(typeof color2 == 'object'){
				str =  JSON.parse(color2[0]);
				$(this).css(str);//css里面必须是对象格式，字符串格式不行
			}else{
				$(this).css({"background":color2});
			}
		}else{
			var replace_src = $(this).attr("src_2");
			$(this).attr("src",replace_src);
		}
		
	},function()
	{
		if(color1){
			if(typeof color1 == 'object'){
				str =  JSON.parse(color1[0]);
				$(this).css(str);
			}else{
				$(this).css({"background":color1});
			}
		}else{
			var curr_src = $(this).attr("src_1");
			$(this).attr("src",curr_src);
		}
		
	});
	
}

/*
	触控效果
	@param obj 触控区域节点元素 在改节点元素上需要设置属性src_1,src_2用于切换的图片路径
*/
function myself_touch(obj,color1,color2){

	$(obj).on("touchstart",function(){
		if(color2){
			if(typeof color2 == 'object'){
				str =  JSON.parse(color2[0]);
				$(this).css(str);//css里面必须是对象格式，字符串格式不行
			}else{
				$(this).css({"background":color2});
			}
		}else{
			var replace_src = $(this).attr("src_2");
			$(this).attr("src",replace_src);
		}

	});

	$(obj).on("touchend",function(){
		if(color1){
			if(typeof color1 == 'object'){
				str =  JSON.parse(color1[0]);
				$(this).css(str);
			}else{
				$(this).css({"background":color1});
			}
		}else{
			var curr_src = $(this).attr("src_1");
			$(this).attr("src",curr_src);
		}

	});
}




function goUrl(url){
	if(url){
		window.open(url);
		return false;
	}
	window.open($(this).attr("href"));
}

//无卡查询用户登录
$(function(){
	$(".user_sel_submit").on("click",function(){

		$(".progress_bar").css({"display":"block"});
	});

});

//倒计时
function countdown(obj,second,callback){
	if(!second){
		return false;
	}

	if(second <= 0){
		return false;
	}

	var init;
	init = setInterval(function(){
		if(second < 0){
			clearInterval(init);
            if(typeof(callback) == 'function'){
                callback();
            }
		}else{
			$(obj).html(second+'s');
			second = second-1;
		}
		
	},1000);

}


//屏保效果
//$(function(){
//
//	setTimeout(function(){
//		var html = '<div onclick="pingbao()" style="position:fixed;top:50%;left:50%;margin-left:-840px;margin-top:-535px;width:1680px;height:1050px;"><img src="images/activity2.png"  width="1680" height="1050" /></div>';
//		$("body").append(html);
//		
//	},20000);
//});
//
//function pingbao(){
//	$("#pingbao").css({"display":"none"});
//	window.location.href='login.html';
//}













