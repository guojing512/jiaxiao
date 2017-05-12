<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Common\Extend\Alipay\Alipay;
use App\Http\Common\Extend\Weixin\WeixinPay;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Models\Recharge;


class RechargeController extends Controller
{

	public function __construct(){

		$this->model = new Recharge();

		session()->put(config('other.HOME_SESSION_USER_NAME'),array('user_id'=>8));

	}

	//充值详情页
	public function index(Request $request)
	{

		$info = $this->getUserinfo();

		return view('home.recharge.index')->with('info',$info);
		
	}

	//生成二维码
	public function createQrCode(Request $request)
	{


		$s_user = session()->get(config('other.HOME_SESSION_USER_NAME'));

		$money = $request->input('money');
		$pay_type = $request->input('pay_type');
		$group_id = $request->input('group_id');

		$recharge_time = $money*config('other.MONEY_TO_TIME');//秒

		//测试
		$money = 0.01;
		$recharge_time = 60;

		$order_num = getTransNum();
		//如果是学员充值group_id=3
		if($group_id == config('other.GROUP_ID_SCHOOL_USER')){
			$this->model->user_id = $s_user['user_id'];
			$this->model->money = $money;
			$this->model->time = $recharge_time;
			$this->model->pay_type = $pay_type;
			$this->model->order_num = $order_num;
			$this->model->flag = 0;
			$pay_content = json_encode($this->model['attributes']);
			$this->model->pay_content = $pay_content;

			$res = $this->model->save();//返回布尔值
			$recharge_id = $this->model->id;

		}else{
			return returnRes('error','学员充值-用户组错误');
		}

		if(!$res){
			return returnRes('error','充值表(学员充值)-添加充值记录失败');
		}

		//支付宝支付
		if($pay_type == 1){
			$data = array(
				'order_num'=>$order_num,
				'subject'=>'充值',
				'money'=>$money,
				'notify_url'=>config('alipay.ALIPAY.notify_url_user_recharge'),
			);

		    $alipay = new Alipay();
		    $return = $alipay->createAliOrder($data);
		    if($return['flag'] == 'success'){
		    	$img = create_erweima($return['data']["qr_code"]);
		    }else{
		    	return returnRes('error','请求接口失败(支付宝)-'.$return['msg'],$return['data']);
		    }
		}
		if($pay_type == 2){
			//微信支付
			$data = array(
				'order_num'=>$order_num,
				'subject'=>'充值',
				'money'=>$money,
				'body'=>'充值',
				'product_id'=>$recharge_id,
				'notify_url'=>config('wxpay.WEIXIN.notify_url_user_recharge'),
			);
			$wxpay = new WeixinPay();
			$return = $wxpay->createWeixinOrder($data);
			if($return['flag'] == 'success'){
		    	$img = create_erweima($return['data']["code_url"]);
		    }else{
		    	return returnRes('error','请求接口失败(微信)',$return['data']);
		    }
		}

		$info = $this->getUserinfo();
		$info['ewm'] = $img;
		$info['recharge_time'] = $recharge_time;
		$info['recharge_money'] = $money;
		$info['rid'] = $recharge_id;
		$info['pay_type'] = $pay_type;

	    return view('home.recharge.ewm')->with('info',$info);

	}

	/*
		return array 用户证件号码 用户称呼 剩余时间
	*/
	public function getUserinfo(){

		$s_user = session()->get(config('other.HOME_SESSION_USER_NAME'));
		
		$info_user = DB::table('admin_user')->where(['id'=>$s_user['user_id']])->first();
		$info_user_ext = DB::table('user_ext')->select('remaining_time')->where(['user_id'=>$s_user['user_id']])->first();
		//$identity_num =  IDNumReplace($info_user['identity_num']);//号码隐藏中间几位
		$identity_num =  $info_user['identity_num'];
		$nickname =  getNickname($info_user['real_name'],$info_user['sex']);
		$data = array(
			'identity_num'=>$identity_num,
			'nickname'=>$nickname,
			'remaining_time'=>$info_user_ext['remaining_time'],
		);

		return $data;
	}



    //查询订单状态
    public function rechStatus(Request $request){

    	$rid = $request->input('rid');
        if(empty($rid)){
        	echo  'error';//参数错误
        	exit;
        }

        if(Cache::get(config('other.RECHARGE_USER_RID').$rid) == 1){
        	echo '1';//支付状态修改成功
        	exit;
        }else{
        	echo '0';//支付状态还未修改
        	exit;
        }

    }


}
