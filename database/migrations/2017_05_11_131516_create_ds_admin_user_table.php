<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDsAdminUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ds_admin_user', function(Blueprint $table)
		{
			$table->increments('id')->comment('用户id');
			$table->string('card_num', 30)->default('')->comment('卡片number,唯一的,学员注册时必填');
			$table->string('user_name', 20)->index('k_name')->comment('登录用户名');
			$table->string('password')->comment('登录密码,md5');
			$table->char('password_token', 8)->default('')->comment('密码token,必填');
			$table->string('real_name', 20)->default('')->comment('真实姓名');
			$table->string('phone_num', 15)->default('')->unique('k_phone')->comment('手机号码');
			$table->boolean('identity_type')->default(1)->comment('证件类型 1为身份证 2为军官证 3为护照');
			$table->string('identity_num', 20)->default('')->unique('k_identity')->comment('证件号码');
			$table->boolean('sex')->default(1)->comment('性别，1为男，2为女');
			$table->string('user_icon', 200)->default('')->comment('用户头像');
			$table->integer('company_id')->unsigned()->default(0)->comment('组织机构Id');
			$table->boolean('group_id')->default(1)->comment('用户类型，默认1为系统管理员，2位驾校管理员，3为学员用户');
			$table->boolean('user_status')->default(1)->comment('用户状态，默认1表示可以登录，0为不能登录');
			$table->dateTime('last_login_time')->nullable()->comment('登录时间');
			$table->string('last_login_ip', 15)->default('')->comment('最后登录ip');
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
		Schema::drop('ds_admin_user');
	}

}
