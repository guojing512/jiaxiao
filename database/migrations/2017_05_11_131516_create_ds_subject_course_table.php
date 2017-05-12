<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDsSubjectCourseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ds_subject_course', function(Blueprint $table)
		{
			$table->increments('id')->comment('自增id');
			$table->integer('subject_id')->unsigned()->comment('科目id');
			$table->string('course_name', 20)->default('')->comment('课程名称');
			$table->string('pic_cover', 200)->default('')->comment('课程封面图');
			$table->string('pic_detail', 200)->default('')->comment('课程详情图');
			$table->integer('score')->unsigned()->default(0)->comment('课程分数');
			$table->text('content', 65535)->comment('课程内容');
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
		Schema::drop('ds_subject_course');
	}

}
