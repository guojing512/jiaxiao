<?php
/*
    支付宝文档：
    签名规则:https://doc.open.alipay.com/docs/doc.htm?docType=1&articleId=106118
    扫码支付:https://doc.open.alipay.com/doc2/apiDetail.htm?spm=a219a.7629065.0.0.PlTwKb&apiId=862&docType=4
*/
namespace App\Http\Common\Extend\Alipay;
use App\Http\Common\Extend\Alipay\lib\CommAli;
use App\Http\Common\Log;
class Alipay extends CommAli{

    //const ALIPAY_GATEWAY = 'https://openapi.alipaydev.com/gateway.do?';
    protected $config_alipay;//支付宝的配置文件

	private $params = array();//请求网关的所有配置参数，用于代签名数据
	public $charset = "UTF-8";// 表单提交字符集编码

	public function __construct(){

        parent::__construct();

		$this->config_alipay = config('alipay.ALIPAY');
        $this->params = array();
        //基础参数（公共参数和请求参数） 以下是公共参数
		$this->params['app_id'] = $this->config_alipay['app_id'];
		$this->params['method'] = $this->config_alipay['method'];
		$this->params['format'] = $this->config_alipay['format'];
		$this->params['charset'] = $this->config_alipay['charset'];
		$this->params['sign_type'] = $this->config_alipay['sign_type'];
		$this->params['timestamp'] = date('Y-m-d H:i:s',time());
		$this->params['version'] = $this->config_alipay['version'];
		$this->params['timeout_express'] = '1m';

	}

    /*
        预创建订单请求接口
        @params $data 必传参数
            $data = array(
                'order_num'=>,//订单号
                'subject'=>,//标题
                'money'=>,//金额
                'notify_url'=>,//通知地址
            )
        @return array method@returnRes
    */
	public function createAliOrder($data){

        $fields = array('order_num' => true, 'money' => true, 'subject' => true, 'notify_url' => true);
        if (!checkData($fields, $data)) {
            return returnRes('error', '参数错误(支付宝预创建订单)');
        }

		$biz_content = array();//请求参数集合
		$biz_content['out_trade_no'] = $data['order_num'];//订单号
		$biz_content['total_amount'] = $data['money'];//金额
		$biz_content['subject'] = config('other.TITLE_PREFIX').$data['subject'];//标题
        $this->params['notify_url'] = $data['notify_url'];//异步通知

		$biz_content = json_encode($biz_content);//请求参数集合转json数据

        //组合请求参数
		$this->params = array_merge($this->params,array('biz_content'=>$biz_content));
		$url = $this->buildRequest($this->params);

		$response = $this->getCurl($url);
        $response = json_decode($response,true);

        $res = $response['alipay_trade_precreate_response'];

        if($res['code'] == '10000'){
            return returnRes('success','ok',$res);
        }else{
            Log::write('[method:'.__METHOD__.']'.json_encode($res),'alipay');
            return returnRes('error','请求失败',$res);
        }

	}

    /*
        异步通知验证签名(异步验签用的是rsa(SHA1)加密方式，跟预创建订单时不一样)
        @params array $data nitify_url接受的数组

        详情：https://doc.open.alipay.com/docs/doc.htm?spm=a219a.7629140.0.0.q5C3nY&treeId=194&articleId=103296&docType=1
    */
    public function checkSignRsa2($data){

        if(empty($data)){
            return returnRes('error','参数错误');
        }

        //剔除sign和sign_type
        $arr_filter = array();
        foreach($data as $key => $value){
            if($key == "sign" || $key == "sign_type"){
                continue;
            }else{
                $arr_filter[$key] = $value;
            }
        }

        //字典排序 
        ksort($arr_filter);
        reset($arr_filter);

        //拼接字符串，得到待验签字符串
        $str_be_sign = $this->createQueryString($arr_filter,false);//待签名字符串,不需要urlencode
        $pubKey= $this->config['alipay_public_key'];//支付宝公钥字符串
        $res = "-----BEGIN PUBLIC KEY-----\n" .
            wordwrap($pubKey, 64, "\n", true) .
            "\n-----END PUBLIC KEY-----";

        $sign = $data['sign'];
        $verify = openssl_verify($str_be_sign, base64_decode($sign), $res,OPENSSL_ALGO_SHA256); 
        if($verify == 1){
            return true;
        }else{
            return false;
        }
    }


} 