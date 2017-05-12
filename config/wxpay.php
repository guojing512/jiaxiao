<?php
/*
    微信支付配置文件
*/
return [

	'WEIXIN'=>[

		'app_weixin_appid' => "wx7066d4178d6d1f94",//公众账号ID
		'weixin_merchant_id' => "1460066702",//微信商户号
		'api_key'=>'8RPN9ndy2n8RNGQfpmpHANUD0y6A16W0',//apikey 用于签名

		//异步通知地址-用户充值通知地址
		'notify_url_user_recharge' => "http://101.254.185.238:9955/wxRecharge",
		//异步通知地址-管理员充值通知地址
		'notify_url_admin_recharge' => "http://101.254.185.238:9955/wxRechAdmin",

	]
];


