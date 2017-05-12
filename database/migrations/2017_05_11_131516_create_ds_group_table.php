<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDsGroupTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ds_group', function(Blueprint $table)
		{
			$table->increments('id')->comment('自增id');
			$table->string('group_name', 50)->default('')->comment('用户组名');
			$table->string('group_desc')->default('')->comment('用户组描述');
			$table->boolean('flag')->default(1)->comment('是否禁用，默认1表示可以用，0表示禁止');
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
		Schema::drop('ds_group');
	}

}
