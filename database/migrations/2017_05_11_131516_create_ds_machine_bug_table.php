<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDsMachineBugTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ds_machine_bug', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('machine_id')->comment('设备ID');
			$table->string('machine_num', 50)->default('')->comment('设备编号');
			$table->string('bug_type', 50)->default('0')->comment('设备bug类型,存字符串，如（1,2,3,5）');
			$table->string('message', 500)->default('')->comment('报修时留言');
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
		Schema::drop('ds_machine_bug');
	}

}
