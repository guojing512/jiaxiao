<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDsCityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ds_city', function(Blueprint $table)
		{
			$table->increments('id')->comment('自增id');
			$table->char('city_name', 60)->default('')->comment('地区名称');
			$table->char('first_name', 1)->comment('首字母');
			$table->boolean('is_hot')->default(0)->comment('是否为热门城市，默认0为否，1为是');
			$table->smallInteger('parent_id')->default(0)->comment('父id');
			$table->boolean('flag')->default(1)->comment('是否开启，默认1为开启，0表示城市关闭');
			$table->string('city_desc', 200)->default('')->comment('城市描述');
			$table->dateTime('created_at')->comment('添加时间');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ds_city');
	}

}
