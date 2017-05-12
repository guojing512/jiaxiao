<?php


/**
 * 返回二维数组中指定的一列
 * @param array $array 二维数组
 * @param string or array $key 键名
 * @param return array()
 */
function return_array_column($array, $key) {
    if (empty($array)) {
        return array();
    }

    if (function_exists('array_column')) {
        return array_column($array, $key);
    }

    $list = array();
    foreach ($array as $value) {
        if (array_key_exists($key, $value) and !empty($value[$key])) {
            $list[] = $value[$key];
        }
    }
    return $list;
}

/**
 * 返回分页的html代码
 * @param array $array Eloquent查询出来的数据
 * @param return strng
 */
function get_pages_html($array)
{
    $html_str = '';
    if (isset($array['last_page'])) {
        $url = '';
        if ($array['next_page_url'] != '') {
            $url = substr($array['next_page_url'], 0, strlen($array['next_page_url']) - 1);
        }
        if ($array['prev_page_url'] != '') {
            $url = substr($array['prev_page_url'], 0, strlen($array['prev_page_url']) - 1);
        }
        $xiangcha = $array['last_page'] - $array['current_page'];
        if ($array['last_page'] > 0 && $xiangcha < 4) {
            $firstPage = "";
            $lastPage = "";
            if($url != ""){
                $firstPage = $url."1";
                $lastPage = $url.$array['last_page'];
            }
            $middle_html = '';
            for ($i = $array['last_page'] - 3; $i <= $array['last_page']; $i++) {
                if ($i > 0) {
                    if ($i == $array['current_page']) {
                        $middle_html .= '<span>' . ($i) . '</span>';
                    } else {
                        $middle_html .= '<a href="' . $url . ($i) . '">' . ($i) . '</a>';
                    }
                }
            }
            $html_str = '<div class="vr_fen">' .
                '<a href="' . $firstPage .'">首页</a>' .
                '<a href="' . $array['prev_page_url'] . '" class="a1">上一页</a>' .
                $middle_html .
                '<a href="' . $array['next_page_url'] . '" class="a1">下一页</a>' .
                '<a href="' . $lastPage . '" class="a1">尾页</a>' .
                '</div>';
        } elseif ($array['last_page'] > 0 && $array['last_page'] - $array['current_page'] >= 4) {
            $html_str = '<div class="vr_fen">' .
                '<a href="' . $url . '1">首页</a>' .
                '<a href="' . $array['prev_page_url'] . '" class="a1">上一页</a>' .
                '<span>' . $array['current_page'] . '</span>' .
                '<a href="' . $url . ($array['current_page'] + 1) . '">' . ($array['current_page'] + 1) . '</a>' .
                '<a href="' . $url . ($array['current_page'] + 2) . '">' . ($array['current_page'] + 2) . '</a>..' .
                '<a href="' . $url . $array['last_page'] . '">' . $array['last_page'] . '</a>' .
                '<a href="' . $array['next_page_url'] . '" class="a1">下一页</a>' .
                '<a href="' . $url . $array['last_page'] . '" class="a1">尾页</a>' .
                '</div>';
        } else {
            $html_str = '<div class="vr_fen">' .
                '<a href="">首页</a>' .
                '<a href="' . $array['prev_page_url'] . '" class="a1">上一页</a>' .
                '<a href="" class="a1">下一页</a>' .
                '<a href="" class="a1">尾页</a>' .
                '</div>';
        }
    }
    return $html_str;
}

/**
 * 对用户的密码进行加密
 * @param $password
 * @param $encrypt //传入加密串toekn，在修改密码时做认证
 * @return array/password
 */
function password($password, $encrypt = '') {
    $pwd = array();
    $pwd['encrypt'] = $encrypt ? $encrypt : create_randomstr();
    $pwd['password'] = md5(md5(trim($password)) . $pwd['encrypt']);
    return $encrypt ? $pwd['password'] : $pwd;
}

/**
 * 生成随机字符串
 * @param string $lenth 长度
 * @return string 字符串
 */
function create_randomstr($lenth = 8) {
    return random($lenth, '0123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ');
}

/**
 * 产生随机字符串
 *
 * @param    int        $length  输出长度
 * @param    string     $chars   可选的 ，默认为 0123456789
 * @return   string     字符串
 */
function random($length, $chars = '0123456789') {
    $hash = '';
    $max = strlen($chars) - 1;
    for ($i = 0; $i < $length; $i++) {
        $hash .= $chars[mt_rand(0, $max)];
    }
    return $hash;
}

/*
    返回结果
    $param $flag作为标识值只能为success or error
    $data = array(
       'rows'=>,//影响的行数 
    )

*/
function returnRes($flag, $msg, $data = array()) {

    if($flag == 'error'){
        \App\Http\Common\Log::write($msg,'return');
    }

    return array('flag' => $flag, 'msg' => $msg, 'data' => $data);
}

/*
 * model 添加字段验证
 * return boolean;
 */
function checkData($fiedls = array(), $data = array()) {
    foreach ($fiedls as $k => $v) {
        if (!isset($data[$k]) || !empty($data[$k]) !== $v)
            return false;
    }
    return true;
}

/*
 * 获取交易号/订单号 16位 日期6位+5位当天时间戳+5位随机数
 * return string
 */

function getTransNum() {
    $time = time();
    $numQ = date('ymd', $time);
    $numZ = mt_rand(1000000, 9999999);
    $numH = $time - strtotime(date('Y-m-d', $time));
    $len = strlen($numH);
    if ($len < 5) {
        $numH = str_repeat('0', 5 - $len) . $numH;
    }
    return $numQ . $numZ . $numH;
}

/*
 * 获取卡片id 24位 日期6位+10位当前时间戳+8位随机数
 * return string
 */

function getCardNumber(){
    $time = time();
    $numQ = date('ymd', $time);
    $numZ = mt_rand(10000000, 99999999);
    return $numQ . time() . $numZ;
}

/*
    根据性别返回称呼
    @parms string $name真实姓名  
    @parms int $sex性别，1为男 2为女
    @return string  
**/
function getNickname($name,$sex){
    
    if(strlen($name) < 1){
        return false;
    }

    if($sex != '1' && $sex != '2'){
        return false;
    }
    return $sex==1?mb_substr($name,0,1).'先生':mb_substr($name,0,1).'女士';

}

/*
    证件号替换
    @params string $str证件号码
*/
function IDNumReplace($str,$mode = 1){
    
    $input = '*';
    $num = 8;

    if($mode = 1){
        return mb_substr($str, 0,3).str_repeat($input,$num).mb_substr($str, -3,3);
    }
    return false;

}

/*
    获取友好时间显示
    @params int $second时间秒
    @params $mode 当是h返回小时 当是m时返回分钟 【默认为false，友好返回带单位的时间，暂时不写】
    @params $roundingMode 取整方式，f为向下取整 c为向上取整 【默认为f，】
*/
function getFriendTime($second,$mode = 'm',$roundingMode = 'f'){
    if($second <= 0){
        return 0;
    }

    if($mode == 'friend'){
        if($second >= 3600){
            $s = $second%3600;
            if($s != 0){
                return floor($second/3600).'小时'.floor($s/60).'分钟';
            }
            return floor($second/3600).'小时';
        }else if($second >= 60 && $second < 3600){
            return floor($second/60).'分钟';
        }else{
            return $second.'秒';
        }

    }

    if($roundingMode == "f"){
        if($mode == 'm'){
            return floor($second/60);//舍零取整
        }
        if($mode == 'h'){
            return floor($second/3600);//舍零取整
        }
    }
    if($roundingMode == "c"){
        if($mode == 'm'){
            return ceil($second/60);//舍零取整
        }
        if($mode == 'h'){
            return ceil($second/3600);//舍零取整
        }
    }
    return false;
}
/*
    生成二维码
*/
function create_erweima($content,$width = '360',$height = '360') {
    $content = urlencode($content);
    $image = '<img src="http://pan.baidu.com/share/qrcode?w='.$width.'&amp;h='.$height.'&amp;url='.$content.'" />';
    return $image;
}
