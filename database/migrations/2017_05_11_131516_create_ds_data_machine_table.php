<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDsDataMachineTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ds_data_machine', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('machine_id')->unsigned()->comment('设备类型id');
			$table->integer('company_id')->comment('所属机构Id');
			$table->integer('total_run_time')->unsigned()->default(0)->comment('设备总运营时间');
			$table->integer('total_start_num')->unsigned()->default(0)->comment('设备总开启次数');
			$table->integer('total_train_num')->unsigned()->default(0)->comment('设备总训练次数');
			$table->integer('total_login_num')->default(0)->comment('此台设备学员刷卡登陆次数');
			$table->integer('train_num_1')->unsigned()->default(0)->comment('课程1训练次数');
			$table->integer('train_time_1')->unsigned()->default(0)->comment('课程1	训练时间');
			$table->integer('train_num_2')->unsigned()->default(0)->comment('课程2训练次数');
			$table->integer('train_time_2')->unsigned()->default(0)->comment('课程2训练时间');
			$table->integer('train_num_3')->unsigned()->default(0)->comment('课程3训练次数');
			$table->integer('train_time_3')->unsigned()->default(0)->comment('课程3训练时间');
			$table->integer('train_num_4')->unsigned()->default(0)->comment('课程4训练次数');
			$table->integer('train_time_4')->unsigned()->default(0)->comment('课程4训练时间');
			$table->integer('train_num_5')->unsigned()->default(0)->comment('课程5训练次数');
			$table->integer('train_time_5')->unsigned()->default(0)->comment('课程5训练时间');
			$table->integer('subject3_train_num')->default(0)->comment('科目三总训练次数');
			$table->decimal('subject3_pass_rate', 10, 4)->unsigned()->default(0.0000)->comment('科目三通过率');
			$table->decimal('subject3_average_score', 10, 4)->unsigned()->default(0.0000)->comment('科目三平均扣分');
			$table->integer('subject3_error_num')->unsigned()->default(0)->comment('科目三错误次数，即违规操作次数');
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
		Schema::drop('ds_data_machine');
	}

}
