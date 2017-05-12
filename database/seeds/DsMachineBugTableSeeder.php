<?php

use Illuminate\Database\Seeder;

class DsMachineBugTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ds_machine_bug')->delete();
        
        \DB::table('ds_machine_bug')->insert(array (
            0 => 
            array (
                'id' => 1,
                'machine_id' => 1,
                'machine_num' => '1234',
                'bug_type' => '1',
                'message' => '0',
                'updated_at' => '2017-03-28 14:10:34',
                'created_at' => '2017-03-28 14:10:49',
            ),
            1 => 
            array (
                'id' => 2,
                'machine_id' => 2,
                'machine_num' => '123456',
                'bug_type' => '2',
                'message' => '0',
                'updated_at' => '2017-03-28 14:11:21',
                'created_at' => '2017-03-28 14:11:24',
            ),
            2 => 
            array (
                'id' => 3,
                'machine_id' => 0,
                'machine_num' => '',
                'bug_type' => '5,6,7',
                'message' => '',
                'updated_at' => '2017-05-08 11:56:29',
                'created_at' => '2017-05-08 11:56:29',
            ),
            3 => 
            array (
                'id' => 4,
                'machine_id' => 1,
                'machine_num' => '1234',
                'bug_type' => '4,5,6',
                'message' => '士大夫士大夫',
                'updated_at' => '2017-05-08 13:36:28',
                'created_at' => '2017-05-08 13:36:28',
            ),
            4 => 
            array (
                'id' => 5,
                'machine_id' => 1,
                'machine_num' => '1234',
                'bug_type' => '1,2,3',
                'message' => '幅度分割',
                'updated_at' => '2017-05-08 13:38:53',
                'created_at' => '2017-05-08 13:38:53',
            ),
            5 => 
            array (
                'id' => 6,
                'machine_id' => 1,
                'machine_num' => '1234',
                'bug_type' => '1,2',
                'message' => '杀杀杀',
                'updated_at' => '2017-05-08 13:40:41',
                'created_at' => '2017-05-08 13:40:41',
            ),
        ));
        
        
    }
}
