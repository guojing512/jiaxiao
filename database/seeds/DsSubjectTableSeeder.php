<?php

use Illuminate\Database\Seeder;

class DsSubjectTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ds_subject')->delete();
        
        \DB::table('ds_subject')->insert(array (
            0 => 
            array (
                'id' => 2,
                'subject_name' => '科目二',
                'subject_desc' => '',
                'sort_num' => 0,
                'updated_at' => '0000-00-00 00:00:00',
                'created_at' => '2017-03-24 17:26:59',
            ),
            1 => 
            array (
                'id' => 3,
                'subject_name' => '科目三',
                'subject_desc' => '',
                'sort_num' => 0,
                'updated_at' => '0000-00-00 00:00:00',
                'created_at' => '2017-03-24 17:27:23',
            ),
            2 => 
            array (
                'id' => 4,
                'subject_name' => '123',
                'subject_desc' => '123',
                'sort_num' => 0,
                'updated_at' => '2017-04-27 15:01:34',
                'created_at' => '2017-04-27 15:01:34',
            ),
        ));
        
        
    }
}
