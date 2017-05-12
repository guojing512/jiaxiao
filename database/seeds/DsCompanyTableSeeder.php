<?php

use Illuminate\Database\Seeder;

class DsCompanyTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ds_company')->delete();
        
        \DB::table('ds_company')->insert(array (
            0 => 
            array (
                'id' => 1,
                'company_type' => 1,
                'company_name' => '超弦驾校',
                'province_id' => 1,
                'city_id' => 35,
                'county_id' => 49,
                'address' => '来广营',
                'used_recharge_money' => '2.42',
                'used_recharge_time' => 14520,
                'available_time' => 14520,
                'updated_at' => '2017-05-11 11:42:42',
                'created_at' => '2017-03-21 13:30:53',
                'is_del' => 0,
            ),
            1 => 
            array (
                'id' => 2,
                'company_type' => 1,
                'company_name' => '北京东方时尚',
                'province_id' => 1,
                'city_id' => 35,
                'county_id' => 49,
                'address' => '',
                'used_recharge_money' => '0.00',
                'used_recharge_time' => 0,
                'available_time' => 36000000,
                'updated_at' => '2017-04-13 10:48:37',
                'created_at' => '2017-03-21 13:31:18',
                'is_del' => 0,
            ),
            2 => 
            array (
                'id' => 3,
                'company_type' => 1,
                'company_name' => '内江公交驾校',
                'province_id' => 23,
                'city_id' => 3247,
                'county_id' => 3248,
                'address' => '西林路',
                'used_recharge_money' => '0.00',
                'used_recharge_time' => 0,
                'available_time' => 32256000,
                'updated_at' => '2017-05-08 17:43:49',
                'created_at' => '2017-03-21 13:33:16',
                'is_del' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'company_type' => 1,
                'company_name' => '东方时尚驾校',
                'province_id' => 1,
                'city_id' => 35,
                'county_id' => 49,
                'address' => 'aaaaaaaaaaa',
                'used_recharge_money' => '0.00',
                'used_recharge_time' => 0,
                'available_time' => 36000000,
                'updated_at' => '2017-03-27 14:19:58',
                'created_at' => '2017-03-27 13:34:03',
                'is_del' => 0,
            ),
        ));
        
        
    }
}
