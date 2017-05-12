<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDsSubjectTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ds_subject', function(Blueprint $table)
		{
			$table->increments('id')->comment('自增id');
			$table->string('subject_name', 20)->default('')->comment('科目名称');
			$table->string('subject_desc', 2000)->default('')->comment('科目简介');
			$table->smallInteger('sort_num')->default(0)->comment('排序值');
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
		Schema::drop('ds_subject');
	}

}
