<?php

use Illuminate\Database\Seeder;

class DsGroupTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ds_group')->delete();
        
        \DB::table('ds_group')->insert(array (
            0 => 
            array (
                'id' => 1,
                'group_name' => '超级管理员',
                'group_desc' => '',
                'flag' => 1,
                'updated_at' => '0000-00-00 00:00:00',
                'created_at' => '0000-00-00 00:00:00',
            ),
            1 => 
            array (
                'id' => 2,
                'group_name' => '驾校管理员',
                'group_desc' => '驾校管理员',
                'flag' => 1,
                'updated_at' => '2017-03-27 14:35:59',
                'created_at' => '2017-03-22 03:35:12',
            ),
            2 => 
            array (
                'id' => 3,
                'group_name' => '普通用户',
                'group_desc' => '开车的练习者',
                'flag' => 1,
                'updated_at' => '2017-03-27 14:35:42',
                'created_at' => '0000-00-00 00:00:00',
            ),
        ));
        
        
    }
}
