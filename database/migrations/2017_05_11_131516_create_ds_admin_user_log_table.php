<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDsAdminUserLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ds_admin_user_log', function(Blueprint $table)
		{
			$table->increments('id')->comment('logid');
			$table->integer('user_id')->comment('用户id');
			$table->string('user_name', 50)->comment('登录用户名');
			$table->string('real_name', 20)->comment('真实姓名');
			$table->integer('log_type')->default(1)->comment('日志类型，1表示登录');
			$table->string('log_content', 1000)->default('')->comment('日志内容');
			$table->string('login_ip', 15)->default('')->comment('登录客户端ip');
			$table->dateTime('created_at')->comment('创建时间');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ds_admin_user_log');
	}

}
