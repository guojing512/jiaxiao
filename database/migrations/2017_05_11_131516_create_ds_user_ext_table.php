<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDsUserExtTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ds_user_ext', function(Blueprint $table)
		{
			$table->increments('id')->comment('id');
			$table->integer('user_id')->unsigned()->comment('学员用户id');
			$table->integer('remaining_time')->unsigned()->default(0)->comment('剩余时长');
			$table->integer('used_time')->unsigned()->default(0)->comment('已用时长');
			$table->integer('used_recharge_time')->default(0)->comment('已充值时长');
			$table->decimal('used_recharge_money', 10)->unsigned()->default(0.00)->comment('已充值金额');
			$table->integer('card_login_num')->unsigned()->default(0)->comment('刷卡次数即用户刷卡登录次数');
			$table->timestamps();
			$table->primary(['id','user_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ds_user_ext');
	}

}
