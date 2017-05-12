<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDsGroupRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ds_group_role', function(Blueprint $table)
		{
			$table->increments('id')->comment('主键');
			$table->integer('group_id')->unsigned()->default(0)->comment('用户组ID');
			$table->integer('menu_id')->default(0)->comment('菜单ID');
			$table->index(['group_id','menu_id'], 'roleid');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ds_group_role');
	}

}
