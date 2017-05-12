<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDsCompanyConsumeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ds_company_consume', function(Blueprint $table)
		{
			$table->increments('id')->comment('id');
			$table->integer('user_id')->unsigned()->comment('用户id');
			$table->integer('company_id')->unsigned()->comment('机构id');
			$table->integer('give_time')->default(0)->comment('充值时长');
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
		Schema::drop('ds_company_consume');
	}

}
