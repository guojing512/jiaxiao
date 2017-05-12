<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDsDataMachineRunLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ds_data_machine_run_log', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('run_id')->unsigned()->comment('设备开启运行的识别标识，必填,唯一');
			$table->string('machine_num', 50)->comment('设备编号');
			$table->integer('user_id')->unsigned()->default(0)->comment('用户id');
			$table->integer('subject_id')->unsigned()->default(0)->comment('科目id');
			$table->integer('course_id')->unsigned()->default(0)->comment('课程id');
			$table->integer('start_time')->unsigned()->default(0)->comment('课程练习开启时间');
			$table->integer('end_time')->unsigned()->default(0)->comment('课程练习结束时的用时长度,只在课程结束时计算');
			$table->integer('course_num')->default(0)->comment('本次练习本课程的次数。即：同一run_id下练习课程的次数');
			$table->boolean('error_num')->default(0)->comment('本次开启本用户本课程的错误次数：0代表上次通过；1代表错误1次；2代表错误2次;,,,;,,,');
			$table->integer('error_type')->unsigned()->comment('错误类型 0为正常 错误关闭关联课程建议表ds_course_advice');
			$table->boolean('log_type')->default(1)->comment('日志类型：1为设备开启(开始训练)；  2为设备关闭（结束训练）； 3为课程完美通过；  4为一次错误通过；5为多次错误通过；6为放弃；7为错误；8为通过；9为科目二训练开始；10为科目二训练结束');
			$table->boolean('src_type')->default(1)->comment('数据来源：1为数据上报；2为数据测试');
			$table->dateTime('created_at')->comment('创建时间');
			$table->boolean('is_del')->default(0)->comment('1为删除； 0为正常');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ds_data_machine_run_log');
	}

}
