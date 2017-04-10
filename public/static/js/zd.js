// JavaScript Document
$(document).ready(function() {

	//根据路由默认选中菜单
	var curr_menu_ids = $(".position").attr("curr_menu_ids");
	$(".inactive").removeClass('inactives');
    $(".inactive").siblings('ul').css({"display":"none"});

	var arr_curr_menu_ids = curr_menu_ids.split(',');
	//console.log(arr_curr_menu_ids);
	var len = $(".curr_menu_id").length;
	for(var i = 0;i < len; i++){
		var menu_id = $(".curr_menu_id:eq("+i+")").attr("menu_id");
		//console.log(menu_id);
		//console.log($.inArray(menu_id, arr_curr_menu_ids));
		if($.inArray(menu_id, arr_curr_menu_ids) >= 0){
			$(".curr_menu_id:eq("+i+")").children("a").addClass('inactives');
			$(".curr_menu_id:eq("+i+")").children("ul").css({"display":"block"});
		}
	}

	//点击一级菜单显示和隐藏及图表样式
	$(".inactive").click(function(){
		$("#left_menu li ul").slideUp(100);
		$(".inactive").removeClass('inactives');

		if($(this).siblings('ul').css('display')=='none'){
			$(this).addClass('inactives');
			$(this).siblings('ul').slideDown(100);	
		}else{
			$(this).removeClass('inactives');
			$(this).siblings('ul').slideUp(100);
		}
	});

});



// JavaScript Document
//jQuery(document).ready(function() {
//var _leftheight = jQuery(".vr_left").height();
//	_rightheight = jQuery(".vr_right").height();
//	if(_leftheight > _rightheight ) {
//		jQuery(".vr_right").height(_leftheight);
//	}
//	else {
//		jQuery(".vr_left").height(_rightheight);
//	}
//})