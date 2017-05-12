<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Common\Extend\Alipay\Alipay;
use App\Http\Common\Extend\Weixin\WeixinPay;
use App\Http\Models\Recharge;
use App\Http\Models\CompanyRecharge;
use App\Http\Common\Log;

class PayCallBackController extends Controller
{

	public function __construct(){

		$this->wxpay = new WeixinPay();
		$this->alipay = new Alipay();
		$this->m_recharge = new Recharge();
		$this->m_company_recharge = new CompanyRecharge();
	}

	//支付宝通知-学员充值
	public function aliRecharge(Request $request)
	{

		if(!$request->isMethod('POST')){
			exit;
		}

		$post = $request->input();

		$this->backData($post,'ali');//回调数据，可删除

		//验证回调
		$return = $this->aliCheckBackData($post,'recharge');
		if($return['flag'] == 'success' && isset($return['data']['flag']) &&$return['data']['flag'] == 1){
			Log::write($post['out_trade_no'].'-'.$return['msg'],'alipay');
			echo 'success';
			exit;
		}
		if($return['flag'] == 'error'){
			Log::write($post['out_trade_no'].'-'.$return['msg'],'alipay');
			exit;
		}

		$response_str = json_encode($post);
		
		$where['order_num'] = $post['out_trade_no'];
		$data['recharge'] = array(
			'money'=>$post['total_amount'],
			'flag'=>1,
			'response_content'=>$response_str,
			'serial_num'=>$post['trade_no'],
		);

		//更新数据库相关数据
		$return = $this->m_recharge->edit($where,$data);
		if($return['flag'] != 'success'){
			return returnRes('error',$return['msg']);
		}else{
			echo 'success';//处理完业务逻辑 返回success(必须是这个)
		}

	}

	//支付宝通知-【管理员充值】
	public function aliRechAdmin(Request $request)
	{

		if(!$request->isMethod('POST')){
			exit;
		}
		$post = $request->input();

		$this->backData($post,'ali-admin');//回调数据，可删除
		//验证回调
		$return = $this->aliCheckBackData($post,'company_recharge');

		if($return['flag'] == 'success' && isset($return['data']['flag']) && $return['data']['flag'] == 1){
			Log::write($post['out_trade_no'].'-'.$return['msg'],'alipay');
			echo 'success';
			exit;
		}
		//验证报错日志
		if($return['flag'] == 'error'){
			Log::write($post['out_trade_no'].'-'.$return['msg'],'alipay');
			exit;
		}

		$response_str = json_encode($post);
		$where['order_num'] = $post['out_trade_no'];
		$data['recharge'] = array(
			'money'=>$post['total_amount'],
			'flag'=>1,
			'response_content'=>$response_str,
			'serial_num'=>$post['trade_no'],
		);

		//更新数据库相关数据
		$return = $this->m_company_recharge->edit($where,$data);
		echo json_decode($return);exit;
		if($return['flag'] != 'success'){
			//return returnRes('error',$return['msg']);
		}else{
			echo 'success';//处理完业务逻辑 返回success(必须是这个)
		}

	}

	//微信通知-学员充值
	public function wxRecharge(Request $request){

		//接受数据
		$xml_str = file_get_contents("php://input"); //接收post数据
		$arr_data = $this->wxpay->xmlToArray($xml_str);

		$this->backData(json_encode($arr_data),'weixin');//回调数据，可删除

		//验证签名和回调数据状态判断
		$return = $this->wxCheckReturnData($arr_data);
		if($return !== true){
			$st = $this->wxpay->arrayToXml($return['data']);
			echo $st;
			exit;
		}

		//查询充值表
		$info_recharge = DB::table('recharge')->select('flag','money')->where('order_num',$arr_data['out_trade_no'])->first();

		//如果支付状态已改变，则告知微信支付系统业务逻辑处理完成
		if($info_recharge['flag'] == 1){
			$this->wxReturnSuccess();
			exit;
		}

		$back_money = $arr_data['total_fee']/100;
		if($info_recharge['money'] != $back_money){
			$msg = '和记录表金额不等(学员充值)';
			$this->wxReturnFail($msg);
			exit;
		}

		//业务逻辑处理
		$where['order_num'] = $arr_data['out_trade_no'];
		$data['recharge'] = array(
			'flag'=>1,
			'money'=>$back_money,
			'response_content'=>json_encode($arr_data),
			'serial_num'=>$arr_data['transaction_id']
		);

		$return = $this->m_recharge->edit($where,$data);
		if($return['flag'] != 'success'){
			$this->wxReturnFail($return['msg']);
			exit;
		}else{
			$this->wxReturnSuccess();
			exit;
		}
	}


	//微信通知-管理员充值
	public function wxRechAdmin(Request $request){
		//接受数据
		$xml_str = file_get_contents("php://input"); //接收post数据
		$arr_data = $this->wxpay->xmlToArray($xml_str);

		$this->backData(json_encode($arr_data),'weixin-admin');//回调数据，可删除

		//验证签名和回调数据状态判断
		$return = $this->wxCheckReturnData($arr_data);
		if($return !== true){
			$st = $this->wxpay->arrayToXml($return['data']);
			echo $st;
			exit;
		}

		//查询充值表
		$info_recharge = DB::table('company_recharge')->select('flag','money')->where('order_num',$arr_data['out_trade_no'])->first();

		//如果支付状态已改变，则告知微信支付系统业务逻辑处理完成
		if($info_recharge['flag'] == 1){
			$this->wxReturnSuccess();
			exit;
		}

		$back_money = $arr_data['total_fee']/100;//通知中的金额分转换为元

		if($info_recharge['money'] != $back_money){
			$msg = '和记录表金额不等(管理员充值)';
			$this->wxReturnFail($msg);
			exit;
		}

		//业务逻辑处理
		$where['order_num'] = $arr_data['out_trade_no'];
		$data['recharge'] = array(
			'flag'=>1,
			'money'=>$back_money,
			'response_content'=>json_encode($arr_data),
			'serial_num'=>$arr_data['transaction_id']
		);
		$return = $this->m_company_recharge->edit($where,$data);
		if($return['flag'] != 'success'){
			$this->wxReturnFail($return['msg']);
			exit;
		}else{
			$this->wxReturnSuccess();
			exit;
		}
	}



	/*
        回调数据验证签名及返回数据的判断
        @params $data array or xml 异步通知接受来的xml或者已经转化为数组的数据
        @return 验证通过时返回true 否则返回array
    */
    public function wxCheckReturnData($data){

        if(!is_array($data)){
            $arr_data = $this->wxpay->xmlToArray($data);
        }else{
            $arr_data = $data;
        }

        //验证签名
        $callback_sign = $arr_data['sign'];
        $verify_sign = $this->wxpay->getSign($arr_data);

        if($verify_sign != $callback_sign){
            $return_arr = array(
                'return_code'=>'FAIL',
                'return_msg'=>'签名失败'
            );
            return returnRes('error','签名失败',$return_arr);
        }

        if(strtolower($arr_data['return_code']) !== 'success' || strtolower($arr_data["result_code"]) !== 'success'){
            $return_arr = array(
                'return_code'=>'FAIL',
                'return_msg'=>$arr_data['msg']
            );
            return returnRes('error',$arr_data['msg'],$return_arr);
        }

        return true;

    }

    //微信返回成功信息
    public function wxReturnSuccess(){
    	$return_arr = array(
			'return_code'=>'SUCCESS',
		);
		$return_xml = $this->wxpay->arrayToXml($return_arr);
		echo $return_xml;
    }

    //微信返回失败信息
    public function wxReturnFail($msg){
    	Log::write($msg,'wxpay');
    	$return_arr = array(
				'return_code'=>'FAIL ',
				'return_msg'=>$msg
			);
		$return_xml = $this->wxpay->arrayToXml($return_arr);
		echo $return_xml;
    }

    /*
		支付宝异步通知验证签名和验证订单号，商家号等信息
		@params array $data 返回的数据
    */
    public function aliCheckBackData($data,$table){

    	if(!is_array($data)){
			//return returnRes('error','参数错误');
    	}

    	//查询充值表
		$info_recharge = DB::table($table)->select('flag','money')->where('order_num',$data['out_trade_no'])->first();

		if(empty($info_recharge)){
			return returnRes('error','该订单号不存在');
		}

		if($info_recharge['flag'] == 1){
			return returnRes('success','ok',array('flag'=>1));
		}

    	$res = $this->alipay->checkSignRsa2($data);//验证签名
    	if(!$res){
    		return returnRes('error','验签失败');
    	}

		if($info_recharge['money'] != $data['total_amount']){
			return returnRes('error','金额不等');
		}

		//卖家支付宝账号暂不验证了
		// if(isset($data['seller_id']) && ($data['seller_id'] != )){
			
		// }
		return returnRes('success','ok');

    }


    public function backData($data,$type){
    	$response_str = json_encode($data);
		$method = $_SERVER['REQUEST_METHOD'];
		DB::table('test')->insert(['str'=>$response_str,'method'=>$method,'created_at'=>date('Y-m-d H:i:s'),'pay_type'=>$type]);
    }


}
