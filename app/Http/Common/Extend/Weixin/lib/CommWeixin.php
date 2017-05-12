<?php

/***
    接口基类
****/


namespace App\Http\Common\Extend\Weixin\lib;
use App\Http\Common\Log;
class CommWeixin {


    protected $config;//配置文件的数据

    public function __construct(){

        $this->config = config('wxpay.WEIXIN');
    }

    /**
     * 产生随机字符串，不长于32位
     * @param int $length 随机字符串长度
     */
    public function createNoncestr($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str.= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    /**
     * 格式化参数，签名过程需要使用
     * @param array $paraMap  参数数组
     * @param type  $urlencode  true or false
     */
    public function formatBizQueryParaMap($paraMap, $urlencode) {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar = '';
        if (strlen($buff) > 0)
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        return $reqPar;
    }

    /**
     * 生成签名
     * @param array $obj  生成签名需要的参数数组
     * 详情可查：https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=4_3
     * 签名测试：https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=20_1
     */
    public function getSign($obj) {

        foreach ($obj as $k => $v) {
            if ($k != "sign" && $v != "" && !is_array($v)) {
                $Parameters[$k] = $v;
            }
        }
        ksort($Parameters); //按字典序排序参数
        $String = $this->formatBizQueryParaMap($Parameters, false);
        $params = $String . "&key=" . $this->config['api_key']; //在string后加入KEY
        $String = md5($params); //MD5加密
        $result = strtoupper($String); //所有字符转为大写
        return $result;
    }

    /**
     * array转xml
     * @param array $arr 被转化的数组
     */
    public function arrayToXml($arr) {

        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml.="<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml.="<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    /**
     * 将xml转为array
     * @param xml $xml 被转化的xml
     */
    public function xmlToArray($xml) {
        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $array_data;
    }

    /**
     * 以post方式提交xml到对应的接口url（不使用证书）
     */
    public function postXmlCurl($xml, $url, $second = 30) {

        $ch = curl_init(); //初始化curl  
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);  //设置超时
        /* 这里设置代理，如果有的话 */
        //curl_setopt($ch,CURLOPT_PROXY, '8.8.8.8');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//禁用后cURL将终止从服务端进行验证。
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_HEADER, FALSE); //设置头文件信息不显示
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //要求结果为字符串文件流传输不是直接输出
        
        curl_setopt($ch, CURLOPT_POST, TRUE); //post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

        $data = curl_exec($ch); //运行curl
        //返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {  //暂时直接输出
            $error = curl_error($ch);
            curl_close($ch);
            Log::write('[method:'.__METHOD__.']'.$error,'wxpay');
            return false;
        }
    }

    


}
