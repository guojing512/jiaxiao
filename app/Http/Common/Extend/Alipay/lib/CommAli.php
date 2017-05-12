<?php

/*

    支付宝支付基础接口

*/
namespace App\Http\Common\Extend\Alipay\lib;
use App\Http\Common\Log;

class CommAli{

    protected $config;//支付宝的配置文件
    public $charset = 'UTF-8';

    public function __construct(){

        //读取配置文件
        $this->config = config('alipay.ALIPAY');

    } 

    /*
        创建请求链接
        @param $data 待签名数据  $this->config['sign']是签名数据
        @return string 请求链接

    */
	public function buildRequest($data,$is_encode = true) {
        $param = $data;
        $param['sign'] = $this->getSign($data);
        return $this->config['gatewayUrl'] . $this->createQueryString($param, true);        
    }

	/**
     * 获取签名数据
     * 签名规则:https://doc.open.alipay.com/docs/doc.htm?docType=1&articleId=106118
     *     sign和空值不参加签名，需要去掉
     *     对参数数组依据键名按照字母顺序升序排序
     *     排序完成之后键值对用&字符连接，组成URL的查询字符串形式待签名字符串，待签名数据不需用url encoding
     *     MD5签名：私钥拼接到待签名字符串的后面，然后用md5对字符串运算，得到32位签名结果
     * @param  array $data 待签名数据()    
     * @return string 已签名数据
     */
    public function getSign($data) {
        $param_tmp = $this->getSignString($data); //待签名字符串
        $sign = '';
        //签名数据
        switch ($this->config['sign_type']) {
            case 'RSA2':
                $sign = $this->rsa2Sign($param_tmp);
                break;
            case 'DES':
                break;
            default:
                $sign = $this->md5Sign($param_tmp);
        }
        return $sign;
    }


    /**
     * 获得待签名数据
     * 
     * @access private
     * @param  array $data
     * @return string
     */
    public function getSignString($data) {

        $param_tmp = $this->filter($data); //过滤待签名数据
        //排序
        ksort($param_tmp);
        reset($param_tmp);

        //创建查询字符串形式的待签名数据
        return $this->createQueryString($param_tmp);
    }
     
    /**
     * 过滤待签名数据，去掉sign字段及空值
     * 
     * @access private
     * @param  array $data
     * @return array
     */
    private function filter($data) {
        $para_filter = array();
        foreach($data as $key => $value){
            if($key == "sign" || empty($value)){
            	continue;
            }else{
            	$para_filter[$key] = $value;
            }
        }
        return $para_filter;
    }


    /**
     * 用&拼接字符串,形成URL查询字符串
     * http_build_query — 生成 URL-encode 之后的请求字符串,这个内置函数可直接转换
     * @access public
     * @param array $data
     * @param boolean $is_encode 是否对值做urlencode
     * @return string
     */
    public function createQueryString($data, $is_encode=false ) {

        $arr = $data;
        $arg = '';
        foreach( $arr as $key => $value ) {
            if($is_encode) {
                $key = urlencode($key);
                $value = urlencode($value);
            }
            $arg .= $key . '=' . $value . '&';
        }
        $arg = substr($arg, 0, strlen($arg)-1); //去掉最后一个&
        //如果存在转义字符，那么去掉转义
        if(get_magic_quotes_gpc()) {
        	$arg = stripslashes($arg);
        }
        return $arg;
    }

    /**
     * MD5加密字符串
     * 
     * @access private
     * @param string $data 待加密字符串
     * @return string
     */
    private function md5Sign( $data ) {
        //return md5($data . $this->key);
    }
     
    /**
     * RSA2 加密字符串
     * 
     * @param string $data 待加密字符串
     * @return string
     */
    private function rsa2Sign( $data ) {

    	$priKey = $this->config['merchant_private_key'];

    	$res = "-----BEGIN RSA PRIVATE KEY-----\n" .
			wordwrap($priKey, 64, "\n", true) .
			"\n-----END RSA PRIVATE KEY-----";
        openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        $sign = base64_encode($sign);
		return $sign;
    }

    /**
     * 以get方式发送请求到对应的接口url（不使用证书）
     */
    public function getCurl($url, $second = 30) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $headers = array('content-type: application/x-www-form-urlencoded;charset=' . $this->charset);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch); //运行curl
        //返回结果
        if ($response) {
            curl_close($ch);
            return $response;
        } else {  //暂时直接输出
            $error = curl_error($ch);
            curl_close($ch);
            Log::write('[method:'.__METHOD__.']'.$error,'wxpay');
            return false;
        }
    }


    /**
     * 以get方式发送请求到对应的接口url（不使用证书）
     */
    public function postCurl($url, $data, $second = 30) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POST, 1);//发送请求设置为post
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//表单数据
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded','Content-Length: '.strlen($data)));//设置HTTP头字段的数组

        $response = curl_exec($ch); //运行curl
        //返回结果
        if ($response) {
            curl_close($ch);
            return $response;
        } else {  //暂时直接输出
            $error = curl_error($ch);
            curl_close($ch);
            Log::write('[method:'.__METHOD__.']'.$error,'wxpay');
            return false;
        }
    }
    

} 