<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDsDataUserSubject2Table extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ds_data_user_subject2', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned()->primary()->comment('学员用户id');
			$table->integer('company_id')->unsigned()->comment('组织id(驾校id)');
			$table->integer('course_id_1')->unsigned()->default(1)->comment('课程id');
			$table->integer('perfect_pass_num_1')->unsigned()->comment('完美通过次数');
			$table->integer('error_one_pass_num_1')->unsigned()->default(0)->comment('失误一次通过次数');
			$table->integer('error_more_pass_num_1')->unsigned()->default(0)->comment('失误多次通过次数');
			$table->integer('error_num_1')->unsigned()->default(0)->comment('错误次数');
			$table->integer('train_time_1')->unsigned()->default(0)->comment('练习时间');
			$table->integer('give_up_num_1')->default(0)->comment('放弃次数');
			$table->integer('course_id_2')->unsigned()->default(2)->comment('课程id');
			$table->integer('perfect_pass_num_2')->unsigned()->default(0)->comment('完美通过次数');
			$table->integer('error_one_pass_num_2')->unsigned()->default(0)->comment('失误一次通过次数');
			$table->integer('error_more_pass_num_2')->unsigned()->default(0)->comment('失误多次通过次数');
			$table->integer('error_num_2')->unsigned()->default(0)->comment('错误次数');
			$table->integer('train_time_2')->unsigned()->default(0)->comment('练习时间');
			$table->integer('give_up_num_2')->default(0)->comment('放弃次数');
			$table->integer('course_id_3')->unsigned()->default(3)->comment('课程id');
			$table->integer('perfect_pass_num_3')->unsigned()->default(0)->comment('完美通过次数');
			$table->integer('error_one_pass_num_3')->unsigned()->default(0)->comment('失误一次通过次数');
			$table->integer('error_more_pass_num_3')->unsigned()->default(0)->comment('失误多次通过次数');
			$table->integer('error_num_3')->unsigned()->default(0)->comment('错误次数');
			$table->integer('train_time_3')->unsigned()->default(0)->comment('练习时间');
			$table->integer('give_up_num_3')->default(0)->comment('放弃次数');
			$table->integer('course_id_4')->unsigned()->default(4)->comment('课程id');
			$table->integer('perfect_pass_num_4')->unsigned()->default(0)->comment('完美通过次数');
			$table->integer('error_one_pass_num_4')->unsigned()->default(0)->comment('失误一次通过次数');
			$table->integer('error_more_pass_num_4')->unsigned()->default(0)->comment('失误多次通过次数');
			$table->integer('error_num_4')->unsigned()->default(0)->comment('错误次数');
			$table->integer('train_time_4')->unsigned()->default(0)->comment('练习时间');
			$table->integer('give_up_num_4')->default(0)->comment('放弃次数');
			$table->integer('course_id_5')->unsigned()->default(5)->comment('课程id');
			$table->integer('perfect_pass_num_5')->unsigned()->default(0)->comment('完美通过次数');
			$table->integer('error_one_pass_num_5')->unsigned()->default(0)->comment('失误一次通过次数');
			$table->integer('error_more_pass_num_5')->unsigned()->default(0)->comment('失误多次通过次数');
			$table->integer('error_num_5')->unsigned()->default(0)->comment('错误次数');
			$table->integer('train_time_5')->unsigned()->default(0)->comment('练习时间');
			$table->integer('give_up_num_5')->default(0)->comment('放弃次数');
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
		Schema::drop('ds_data_user_subject2');
	}

}
