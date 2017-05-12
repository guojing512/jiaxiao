<?php
/*
    其他配置信息
*/
return [
    //这两个钱与时间的换算必须一致
    //'MONEY_TO_TIME'=>60,//元对秒 1元=60秒
	//'TIME_HOUR_TO_MONEY'=>60,//小时对元  1小时对应60元      60元=3600秒=1小时

    //这两个换算必须一致
    'MONEY_TO_TIME'=>6000,//测试 元对秒 即1分钱=60秒  
	'TIME_HOUR_TO_MONEY'=>0.6,//测试 小时对元  0.6元=60分钱=3600秒=1小时 

    'GROUP_ID_ADMIN'=>1, //超级管理员
    'GROUP_ID_SCHOOL_ADMIN'=>2,//驾校管理员
    'GROUP_ID_SCHOOL_USER'=>3, //驾校普通学院
    'HOME_LOGIN_TYPE_CARD'=>1, //正常刷卡登陆
    'HOME_LOGIN_TYPE_PHONE'=>2, //无卡查询登陆,即手机号，证件号登陆
    'HOME_SESSION_USER_NAME'=>'user_home',//前台用户session名
    'COURSE_ADVICE_SCORE_LIST'=>'course_advice_score_list',//缓存错误分值列表，缓存名称

    'RECHARGE_USER_RID'=>'recharge_user_rid_',//充值成功且已更新剩余时间 设置一个缓存，用于查询支付状态 rid为充值记录表的id
	'RECHARGE_ADMIN_RID'=>'recharge_admin_rid_',//充值成功且已更新剩余时间 设置一个缓存，用于查询支付状态 rid为充值记录表的id

    'TITLE_PREFIX'=>'驾校VR管理系统-',//商品描述前缀

];
