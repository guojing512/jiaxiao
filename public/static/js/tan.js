// JavaScript Document
$(document).ready(function($){
	$(".vr_tj").click(function(event){
		$(".vr_hei").show();
		$(".vr_tian").show();
	});
	$(".close").click(function(event) {
		$(".vr_hei").hide();
		$(".vr_tian").hide();
	});
	
	$(".vr_cs").click(function(event){
		$(".vr_hei").show();
		$(".vr_xiu").hide();
		$(".vr_tian").show();
	});


	$(".vr_cz").click(function(event){
		$(".vr_hei").show();
		$(".vr_tian").hide();
		$(".vr_tian_").show();
	});
});



$(document).ready(function($){
	$(".vr_gai").click(function(event){
		$(".vr_hei").show();
		$(".vr_xiu").show();
	});
	$(".close").click(function(event) {
		$(".vr_hei").hide();
		$(".vr_xiu").hide();
		$(".vr_tian_").hide();
	});
});


$(document).ready(function($){
	$(".vr_cheng").click(function(event){
		$(".vr_hei").show();
		$(".vr_tiann").show();
	});
	$(".close").click(function(event) {
		$(".vr_hei").hide();
		$(".vr_tiann").hide();
	});
	$(".huiyuan").click(function(event){
		$(".caidan").show();
	});
	
	$(".hei_1,.caidan").click(function(event){
		$(".caidan").hide();
	});
	
});

$(document).ready(function($){
	$(".shen").click(function(event){
		$(".vr_hei").show();
		$(".vr_xt").show();
	});
	$(".close").click(function(event) {
		$(".vr_hei").hide();
		$(".vr_xt").hide();
	});
});


