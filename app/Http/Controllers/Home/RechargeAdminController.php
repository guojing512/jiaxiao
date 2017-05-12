<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Common\Extend\Alipay\Alipay;
use App\Http\Common\Extend\Weixin\WeixinPay;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Models\CompanyRecharge;


class RechargeAdminController extends Controller
{

	public function __construct(){

		$this->model = new CompanyRecharge();

		session()->put(config('other.HOME_SESSION_USER_NAME'),array('user_id'=>2));

	}

	//充值详情页
	public function index(Request $request)
	{

		$info = $this->getInfo();

		return view('home.rechargeAdmin.index')->with('info',$info);
		
	}

	//生成二维码
	public function createQrCode(Request $request)
	{

		$s_user = session()->get(config('other.HOME_SESSION_USER_NAME'));

		$buy_time = $request->input('buy_time');//充值时间/小时
		$pay_type = $request->input('pay_type');
		$group_id = $request->input('group_id');

		$validator = \Validator::make($request->input(),[
			'buy_time'=>'required|min:1|max:10',
		],[
			'buy_time'=>':attribute为必填项',
		],[
			'buy_time'=>'充值时间',
		]);

		if($validator->fails()){
			return redirect()->back()->withErrors($validator)->withInput();//withErrors把错误信息返回去   withInputs()是数据保持
		}

		$recharge_time = (int)$buy_time*3600;//秒
		$money = config('other.TIME_HOUR_TO_MONEY') * (int)$buy_time;//小时对应的金额

		//测试
		$money = 0.01;
		$recharge_time = 60;
		$order_num = getTransNum();//获取订单号
		//如果是驾校管理员充值group_id=2

		$info_user = DB::table('admin_user')->select('company_id')->where('id',$s_user['user_id'])->first();//返回name列的所有值
		if(empty($info_user['company_id'])){
			return returnRes('error','管理充值-用户表-组织机构company_id不存在');
		}

		if($group_id == config('other.GROUP_ID_SCHOOL_ADMIN')){
			$this->model->user_id = $s_user['user_id'];
			$this->model->company_id = $info_user['company_id'];
			$this->model->order_num = $order_num;
			$this->model->money = $money;
			$this->model->time = $recharge_time;
			$this->model->pay_type = $pay_type;
			$this->model->flag = 0;
			$pay_content = json_encode($this->model['attributes']);
			$this->model->pay_content = $pay_content;

			$res = $this->model->save();//返回布尔值
			$recharge_id = $this->model->id;

		}else{
			return returnRes('error','管理员充值-用户组错误');
		}

		if(!$res){
			return returnRes('error','(管理员充值表)-添加充值记录失败');
		}

		//支付宝支付
		if($pay_type == 1){
			$data = array(
				'order_num'=>$order_num,
				'subject'=>'充值',
				'money'=>$money,
				'notify_url'=>config('alipay.ALIPAY.notify_url_admin_recharge'),
			);

		    $alipay = new Alipay();
		    $return = $alipay->createAliOrder($data);
		    if($return['flag'] == 'success'){
		    	$img = create_erweima($return['data']["qr_code"]);
		    }else{
		    	return returnRes('error','请求接口失败(支付宝)',$return['data']);
		    }
		}else if($pay_type == 2){
			//微信支付
			$data = array(
				'order_num'=>$order_num,
				'subject'=>'充值',
				'money'=>$money,
				'body'=>'充值',
				'product_id'=>$recharge_id,
				'notify_url'=>config('wxpay.WEIXIN.notify_url_admin_recharge'),
			);
			$wxpay = new WeixinPay();
			$return = $wxpay->createWeixinOrder($data);
			if($return['flag'] == 'success'){
		    	$img = create_erweima($return['data']["code_url"]);
		    }else{
		    	return returnRes('error','请求接口失败(微信)',$return['data']);
		    }
		}else{
			return returnRes('error','支付方式错误(管理员充值)');
		}

		$info = $this->getInfo();
		$info['ewm'] = $img;
		$info['recharge_time'] = $recharge_time;
		$info['recharge_money'] = $money;
		$info['rid'] = $recharge_id;
		$info['pay_type'] = $pay_type;

	    return view('home.rechargeAdmin.ewm')->with('info',$info);

	}

	/*
		return array 用户证件号码 用户称呼 剩余时间
	*/
	public function getInfo(){

		$s_user = session()->get(config('other.HOME_SESSION_USER_NAME'));
		
		$info_user = DB::table('admin_user')->where(['id'=>$s_user['user_id']])->first();
		$info_company = DB::table('company')->where(['id'=>$info_user['company_id']])->first();
		$identity_num =  $info_user['identity_num'];
		$data = array(
			'identity_num'=>$identity_num,
			'available_time'=>$info_company['available_time'],
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

        if(Cache::get(config('other.RECHARGE_ADMIN_RID').$rid) == 1){
        	echo '1';//支付状态修改成功
        	exit;
        }else{
        	echo '0';//支付状态还未修改
        	exit;
        }

    }


}
