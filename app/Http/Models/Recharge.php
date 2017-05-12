<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Models\UserExt;

class Recharge extends Model{

    protected $table = "recharge";

    /*
		更新充值记录状态
		1.更新充值记录状态  2.更新扩展表
		
		@param $where条件 $where['order_num']必传 ；
		$data要更新的数据  $data['recharge']
		$data['recharge']=array(
			'money'=>$money,//金额必传
			'serial_num'=>$serial_num,//交易号,流水号必传
			'response_content'=>$response_content,//第三方返回信息必传
			'flag'=>$flag,//支付状态必传
		)
		
		@return array

    */
    public function edit(array $where,array $data){

    	if(!isset($where['order_num']) || !isset($data['recharge'])){
    		return returnRes('error','参数错误');
    	}

    	$fields = array('money' => true,'serial_num' => true,'response_content' => true,'flag' => true);
    	if (!checkData($fields, $data['recharge'])) {
            return returnRes('error', '参数错误');
        }

    	$info_recharge = DB::table('recharge')->where('order_num',$where['order_num'])->first();
    	if(empty($info_recharge)){
    		return returnRes('error','订单号'.$where['order_num'].'记录不存在');
    	}

        //dump($data);
    	//return $info_recharge;

    	$response_content = $data['recharge']['response_content'];
    	$serial_num = $data['recharge']['serial_num'];
    	$flag = $data['recharge']['flag'];
    	$money = $data['recharge']['money'];
    	$time = $money*config('other.MONEY_TO_TIME');


    	$update_recharge_data = array(
    		'flag'=>$flag,
    		'money'=>$money,
    		'time'=>$time,
    		'response_content'=>$response_content,
    		'serial_num'=>$serial_num,
    	);

    	DB::beginTransaction();//开启事务
    	//实例化模型
    	$m_recharge = new self;
    	$m_user_ext = new UserExt();

    	$res = $m_recharge
    		->where(array('order_num'=>$where['order_num']))
    		->update($update_recharge_data);
    	if($res < 1){
    		DB::rollBack();//事务回滚
    		return returnRes('error','充值记录表',array('rows'=>$res));
    	}

    	//更新用户附加表
    	$res = $m_user_ext
    		->where(array('user_id'=>$info_recharge['user_id']))
    		->update([
    			'used_recharge_time'=>DB::raw('used_recharge_time+'.$time),
                'used_recharge_money'=>DB::raw('used_recharge_money+'.$money),
    			'remaining_time'=>DB::raw('remaining_time+'.$time),
    		]);

    	if($res < 1){
    		DB::rollBack();//事务回滚
    		return returnRes('error','充值记录表',array('row'=>$res));
    	}
    	DB::commit();//事务提交

        Cache::put(config('other.RECHARGE_USER_RID').$info_recharge['id'],1,15);//支付的业务逻辑处理完成设置缓存,值为1时说明支付成功且已更新剩余时间  

    	return returnRes('success','更新成功');

    }


}
