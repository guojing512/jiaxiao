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
    flag作为标识success or error

*/
function returnRes($flag, $msg, $data = array()) {
    return array('flag' => $flag, 'msg' => $msg, 'data' => $data);
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


