<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDsCourseAdviceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ds_course_advice', function(Blueprint $table)
		{
			$table->increments('id')->comment('自增id');
			$table->integer('course_id')->unsigned()->comment('课程id');
			$table->integer('advice_score')->default(0)->comment('当为0时表示不合格，当为具体数值时，为分值。');
			$table->string('advice_title', 50)->comment('标题');
			$table->string('advice_content', 1000)->default('')->comment('建议内容');
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
		Schema::drop('ds_course_advice');
	}

}
