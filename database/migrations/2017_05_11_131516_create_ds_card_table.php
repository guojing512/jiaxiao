<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDsCardTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ds_card', function(Blueprint $table)
		{
			$table->increments('id')->comment('流水id');
			$table->integer('user_id')->unsigned()->comment('用户id');
			$table->string('card_num', 30)->default('')->comment('卡片id,唯一的,学员注册时必填');
			$table->boolean('is_del')->default(1)->comment('卡片状态，1可用，0为作废');
			$table->integer('create_by')->nullable()->comment('创建人/开卡人');
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
		Schema::drop('ds_card');
	}

}
