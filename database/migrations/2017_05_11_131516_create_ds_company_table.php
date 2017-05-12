<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDsCompanyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ds_company', function(Blueprint $table)
		{
			$table->increments('id');
			$table->boolean('company_type')->comment('组织机构类型，1为驾校，后面待定');
			$table->string('company_name', 50)->comment('机构名称');
			$table->integer('province_id')->unsigned()->default(0)->comment('省份id');
			$table->integer('city_id')->unsigned()->default(0)->comment('城市id');
			$table->integer('county_id')->unsigned()->default(0)->comment('县或者区id');
			$table->string('address')->default('')->comment('详细地址');
			$table->decimal('used_recharge_money', 10)->unsigned()->default(0.00)->comment('已充值总金额');
			$table->integer('used_recharge_time')->unsigned()->default(0)->comment('已充值总时间');
			$table->integer('available_time')->unsigned()->default(0)->comment('可用时间');
			$table->timestamps();
			$table->boolean('is_del')->default(1)->comment('0为删除 1为正常');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ds_company');
	}

}
