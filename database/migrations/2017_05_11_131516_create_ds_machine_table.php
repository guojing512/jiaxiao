<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDsMachineTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ds_machine', function(Blueprint $table)
		{
			$table->increments('id');
			$table->boolean('machine_type')->comment('设备类型 1为汽车');
			$table->string('machine_num', 50)->comment('设备编号');
			$table->integer('company_id')->comment('所属机构Id');
			$table->integer('total_run_time')->unsigned()->default(0)->comment('设备总运营时间');
			$table->integer('total_start_num')->unsigned()->default(0)->comment('设备总开启次数');
			$table->integer('total_train_num')->unsigned()->default(0)->comment('设备总训练次数');
			$table->integer('total_login_num')->default(0)->comment('此台设备学员刷卡登陆次数');
			$table->string('mac', 50)->default('')->comment('物理地址');
			$table->boolean('flag')->default(1)->comment('设备状态 1为正常 2设为维护中');
			$table->timestamps();
			$table->boolean('is_del')->default(1)->comment('0为删除 1为正常');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ds_machine');
	}

}
