<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDsRechargeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ds_recharge', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned()->comment('学员用户id');
			$table->string('order_num', 20)->comment('订单号，自己生成的');
			$table->decimal('money', 10)->unsigned()->comment('充值金额 ');
			$table->integer('time')->unsigned()->default(0)->comment('充值时长,根据金额和换算比率获取');
			$table->boolean('pay_type')->default(1)->comment('支付方式，1为支付宝，2微信');
			$table->string('pay_content', 2000)->default('')->comment('支付内容 账号信息等 json_encode');
			$table->string('serial_num', 30)->default('')->comment('流水号');
			$table->string('response_content', 4000)->default('')->comment('第三方返回详情 json_encode');
			$table->boolean('flag')->default(0)->comment('状态 0 待付款 1已付款 2 付款失败');
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ds_recharge');
	}

}
