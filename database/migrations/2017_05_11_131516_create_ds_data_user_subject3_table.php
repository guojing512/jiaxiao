<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDsDataUserSubject3Table extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ds_data_user_subject3', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned()->primary()->comment('学员用户id');
			$table->integer('company_id')->unsigned()->comment('组织id(驾校id)');
			$table->integer('train_num')->default(0)->comment('练习总次数');
			$table->integer('pass_num')->unsigned()->default(0)->comment('通过次数（总分大于80分）');
			$table->integer('error_pass_num')->unsigned()->default(0)->comment('不合格次数（总分小于80分和直接不合格）');
			$table->integer('error_num')->unsigned()->default(0)->comment('错误次数（只要出错就记录）');
			$table->integer('score')->unsigned()->default(0)->comment('累计扣除分数');
			$table->integer('train_time')->unsigned()->default(0)->comment('练习时间');
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
		Schema::drop('ds_data_user_subject3');
	}

}
