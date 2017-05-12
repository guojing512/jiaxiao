<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDsMenuTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ds_menu', function(Blueprint $table)
		{
			$table->increments('id')->comment('自增id');
			$table->string('menu_name', 50)->default('')->comment('菜单名称');
			$table->smallInteger('parent_id')->default(0)->comment('父级ID');
			$table->string('route', 200)->unique('route')->comment('路由');
			$table->string('m_name', 30)->default('')->comment('模块名');
			$table->string('c_name', 30)->default('')->comment('控制器名');
			$table->string('a_name', 30)->default('')->comment('方法名');
			$table->smallInteger('sort_num')->default(0)->comment('排序值');
			$table->boolean('is_show')->default(1)->comment('是否显示,默认1显示，0为不显示');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ds_menu');
	}

}
