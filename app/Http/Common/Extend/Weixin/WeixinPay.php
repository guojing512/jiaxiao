<?php
/***
    微信支付

***/
namespace App\Http\Common\Extend\Weixin;
use App\Http\Common\Extend\Weixin\lib\CommWeixin;

class WeixinPay extends CommWeixin{


    //读取配置文件里面的内容
    protected $config;

	public function __construct(){

        parent::__construct();

		$this->config = config('wxpay.WEIXIN');
        // 统一下单请求地址
        $this->url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        // 超时时间
        $this->curl_timeout = 30;
        $this->qrcode_end_time = 10*60;//二维码有效时间 10分钟

    }


    /**
     * 创建一个微信的 支付订单  （微信统一下单  支付的第一步）
     * @return [type] [description]
     */
    public function createWeixinOrder($data){
        /*
            必传参数验证
            order_num订单号必传
            money订单金额必传(单位为元)
            body商品描述必传
            product_id商品id必传
        */
        $fields = array('order_num' => true,'money' => true,'body' => true,'product_id' => true,'notify_url' => true);
        if (!checkData($fields, $data)) {
            return returnRes('error', '参数错误(微信统一订单)');
        }

        $params = array();
        $params['notify_url'] = $data['notify_url'];//异步通知地址
        $params['appid'] = $this->config['app_weixin_appid'];//公众账号ID
        $params['mch_id'] = $this->config['weixin_merchant_id'];//商户号
        $params['nonce_str'] = $this->createNoncestr();//随机字符串

        $params['body'] = config('other.TITLE_PREFIX') . $data['body'];//商品描述
        // 附加数据，在查询API和支付通知中原样返回，该字段主要用于商户携带订单的自定义数据
        if(!empty($data['attach'])){
            $this->parameters["attach"] = $data['attach'];
        }
        $params['out_trade_no'] = (string)$data['order_num'];//商户订单号
        $params['total_fee'] = $data['money']*100;//金额，单位为分,传过来的是元
        $params['spbill_create_ip'] = $_SERVER['REMOTE_ADDR'];//终端IP
        $params['time_expire'] = date('YmdHis',time()+$this->qrcode_end_time);//二维码有效期
        $params['trade_type'] = 'NATIVE';//交易类型
        $params['product_id'] = $data['product_id'];//扫码支付时，此参数必传，可以把充值记录id传过来

        $xml = $this->arrayToXml($params);//数组转化为xml字符串
        $signValue = $this->getSign($params);//获取签名
        $params["sign"] = $signValue;

        $xml = $this->arrayToXml($params);//数组转化为xml对象
        $responseXml = $this->postXmlCurl($xml,$this->url);// 发送请求
        $res = $this->xmlToArray($responseXml);


        if(strtolower($res['return_code']) === 'success' && 
            strtolower($res['result_code']) === 'success' ){
            return returnRes('success','ok',$res);
        }else{
            return returnRes('error','请求失败',$res);
        }

    }


}
