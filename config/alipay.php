<?php
/*
    支付宝当面付配置信息
    沙箱测试账号
*/
return [

	'ALIPAY'=>[
		//签名方式,默认为RSA2(RSA2048)
		'sign_type' => "RSA2",
		'format' => "json",

		//支付宝公钥
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA1H+PYfas/6ov0d5E/7gSD1mT0XLxXpPi4R0Lv5rDztNLhTqv74xvFwdmlw+K9uJMMf43JVr5Szk3I+90WLm2AUqkIn/NnGt4q6dVt0v+0gcpu5rrmRauGNg1lBnyxEPpbzPw5KSY2VnNbq6zhotZd1U1yTyKSJ1S39R2dzz7kUCQLOfHXQKNFGkQqC9e9f6464+jy6qhCtAV4Oi0CPxbjJ3cx8zqzJhDPzBYb/ryZXlBm4FfBNHsG812dCAL0KNavXN89ZbCP8mS6ZzATY2mD/3wfUC6L8c+Vs/CEotvQjTn+7P/WaQkMcsKXjy6ekO8utrLHDWaVWDzt4bPdlY0xQIDAQAB",

		//商户私钥
		'merchant_private_key' => "MIIEowIBAAKCAQEAxXrUhVVTFTm5NwOLkLH1/NyUHqKEZ7d1ts7vn5aljDAhj90WSfy2BjDgnSP+hh8DN/U67CN8xLEZoKw5aumBIU67LlUQCCmoikceF44OmJyitgb3+AmkkDSQIgHd2hzsOAH2C504A4awm/WOn2AL32IQgI00ethMCeoUpjkkLMZNTHiyTFXBJLU4emRf5H4X5omVXyG3HCnFr0Y+sFyg/2n15bfoWGTN2FT4Gag5CreLMMIXLyWiw3URm2qSAHF7ptJxO9mFsHUD5dSuvetJsu1aTET5sFNDjdxggn9pVvEFX+TeXtE80D7l8Dcr+DLE9Cfc0Xpkz0PVevh9jrgQZQIDAQABAoIBAFhDqjFeDaBzCGGaaAroP7YhMOLwaJWi3i4zF88QmjWqXZXbj1bKaOEjf4E80UpJGjsslIVu5xlSvs2drJwoedrVQbxXsK61T+teFgkZKVT0zZTmUHbAeJkrpTBN/Ua7nqj512shfiO1U8KhYnnBiAzz28RZWJd/jZzwzwHskEqiHglnNZAxKQu+RsM0JV+8aDpWlScpbbt0umh9deUOtI4UkSszr9ILdT6/yp+DkHyRjjSQd/4hREKurP6akBCTgxW9vV/FDap74bxFavVx5tXUi2E3f4jq/Rx08e6DjkuLczGzBN9rwvmjkRxPqNkLQ89C+VoaQZEwhQ5khPX7Z5ECgYEA79G3HU7mYf4pUR2UNqvApbZmcCa9FjM3J4NW+cknXX7Fy2pVk5Hug1jIJBChWBFOFv4abqNBcd/Hb9s2ayhHDW1o2ISvHJ/8up13Rg4TkS6G8ubZxSxbGutZeGNClfYhCyKx4Qs8weWMAOd3G/+jVFDBA01rMJ/tig9BVitQtkMCgYEA0s3Oa7WbVqXV9WciqF2+z0sH2O0JB6USctj6yNlTCLsL/7HpYkEISIVy8nSBMrSqfLWM8gGVyyBFNs1RJNMH0yNYuCoxP+widir46RBa6sEysJ5XPMMVBD99yCzA5CqBwHFfZi4iUffkDpnJJDSnGW4Z1MCKb1bbU5NYLXvw+DcCgYEArwnol1GxQbDaw0PNnCG8GLeLCSydMojrJsHsR6CURN90ysWv9Ge9KM0yN3CT8s2eq5WIAVzTNaRZ0sCzdX8ObTSAJBikH0Z+lk68cbtweLT29m+cXxfC32EMCpyYSxA8if4mytUC4ZsDlt1ayGrL8YyHdDubkwAHxo7f517yKDUCgYBBc1zv3EcKtBqmQwtjsxeXTPh2xcHT+dCsj+ntimxZfZnQHfEUbJShz61M0hd7ItT8O3IzgYJ8utxCk6TqBgub5pGZPKBl9G8OuXDnDAjucmXGqKL1Xqyb0QrAqASL0xbOJWU1WIWXZZwNXHozH5XyM1kZ0V4qC5G1dT4fgSfkKQKBgDUJurhCQaQJzH5aWiSp6ZL4KojqnPWtkrTPN/rolqLQTOfEnpILkVcF+U/9UCHHRLnxaqmFdrSmgnYOX4IBhn1o9kuD8Qjiwebqzzu9OxRo3ygbfOvJ73HJiDZqMsVwaRs6F/78SpvqzafRuSc8+23W3QbLX6z+7lfp6o/EQVUC",

		//编码格式
		'charset' => "UTF-8",

		//支付宝网关
		//'gatewayUrl' => "https://openapi.alipay.com/gateway.do?",

		//支付宝沙箱测试网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do?",

		//应用ID
		'app_id' => "2016080300154332",

		//异步通知地址-用户充值通知地址
		'notify_url_user_recharge' => "http://101.254.185.238:9955/aliRecharge",
		//异步通知地址-管理员充值通知地址
		'notify_url_admin_recharge' => "http://101.254.185.238:9955/aliRechAdmin",

		//最大查询重试次数
		'MaxQueryRetry' => "10",

		//查询间隔
		'QueryDuration' => "3",

		//调用的接口版本，固定为：1.0
		'version'=>'1.0',
		'method'=>'alipay.trade.precreate',

	]
];
