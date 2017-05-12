<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDsDataSubject3LogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ds_data_subject3_log', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('run_id')->unsigned()->comment('设备开启运行的识别标识，必填,唯一');
			$table->string('machine_num', 50)->comment('设备编号');
			$table->integer('user_id')->unsigned()->default(0)->comment('用户id');
			$table->integer('subject_id')->unsigned()->default(3)->comment('科目id');
			$table->integer('course_id')->unsigned()->default(0)->comment('课程id');
			$table->integer('start_time')->unsigned()->default(0)->comment('C端上报的当前时间');
			$table->integer('end_time')->default(0)->comment('课程练习结束时的用时长度,只在课程结束时计算');
			$table->integer('course_num')->default(0)->comment('本次练习本课程的次数。即：同一run_id下练习课程的次数');
			$table->integer('error_type')->unsigned()->comment('错误类型 0为正常 错误关闭关联课程建议表ds_course_advice');
			$table->boolean('log_type')->default(1)->comment('日志类型：1是科三开始（即选中科三训练开始,开始时就同步更新科目三的训练次数）；2是本科目结束时间；3是训练出错（为3时error_type需要对应错误id）;');
			$table->boolean('src_type')->comment('数据来源类型，1为设备上报  2为测试数据');
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
		Schema::drop('ds_data_subject3_log');
	}

}
