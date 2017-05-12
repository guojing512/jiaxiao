<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDsDataMachineRunTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ds_data_machine_run', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('run_id')->unsigned()->unique('run_id')->comment('设备开启运行的识别标识，必填,唯一');
			$table->string('machine_num', 50)->comment('设备编号');
			$table->integer('user_id')->default(0)->comment('用户id');
			$table->integer('start_time')->unsigned()->default(0)->comment('设备开启时间（本次训练开始）');
			$table->integer('end_time')->unsigned()->default(0)->comment('设备结束时间（结束本次训练时间）');
			$table->string('mac', 50)->default('0')->comment('物理地址');
			$table->boolean('end_mode')->default(1)->comment('结束方式，1为正常 2为异常');
			$table->boolean('src_type')->comment('数据来源类型，1为设备上报  2为测试数据');
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
		Schema::drop('ds_data_machine_run');
	}

}
