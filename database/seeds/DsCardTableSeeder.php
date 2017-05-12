<?php

use Illuminate\Database\Seeder;

class DsCardTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ds_card')->delete();
        
        \DB::table('ds_card')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 58,
                'card_num' => '170424149301644461174457',
                'is_del' => 1,
                'create_by' => 55,
                'updated_at' => '2017-04-24 15:00:21',
                'created_at' => '2017-04-24 15:00:21',
            ),
            1 => 
            array (
                'id' => 57,
                'user_id' => 114,
                'card_num' => '',
                'is_del' => 1,
                'create_by' => 55,
                'updated_at' => '2017-04-24 17:12:47',
                'created_at' => '2017-04-24 17:12:47',
            ),
            2 => 
            array (
                'id' => 59,
                'user_id' => 55,
                'card_num' => '170418149248174022171853',
                'is_del' => 0,
                'create_by' => 55,
                'updated_at' => '2017-05-08 17:01:46',
                'created_at' => '2017-04-25 10:55:12',
            ),
            3 => 
            array (
                'id' => 60,
                'user_id' => 117,
                'card_num' => '',
                'is_del' => 1,
                'create_by' => 55,
                'updated_at' => '2017-04-25 10:55:53',
                'created_at' => '2017-04-25 10:55:53',
            ),
            4 => 
            array (
                'id' => 62,
                'user_id' => 119,
                'card_num' => '',
                'is_del' => 1,
                'create_by' => 55,
                'updated_at' => '2017-04-25 10:59:06',
                'created_at' => '2017-04-25 10:59:06',
            ),
            5 => 
            array (
                'id' => 63,
                'user_id' => 120,
                'card_num' => '',
                'is_del' => 1,
                'create_by' => 55,
                'updated_at' => '2017-04-25 10:59:40',
                'created_at' => '2017-04-25 10:59:40',
            ),
            6 => 
            array (
                'id' => 74,
                'user_id' => 131,
                'card_num' => '',
                'is_del' => 1,
                'create_by' => 55,
                'updated_at' => '2017-04-25 14:25:45',
                'created_at' => '2017-04-25 14:25:45',
            ),
            7 => 
            array (
                'id' => 75,
                'user_id' => 132,
                'card_num' => '',
                'is_del' => 1,
                'create_by' => 55,
                'updated_at' => '2017-04-25 14:30:56',
                'created_at' => '2017-04-25 14:30:56',
            ),
            8 => 
            array (
                'id' => 82,
                'user_id' => 46,
                'card_num' => '170412149196658847405669',
                'is_del' => 1,
                'create_by' => 55,
                'updated_at' => '2017-05-02 13:37:29',
                'created_at' => '0000-00-00 00:00:00',
            ),
            9 => 
            array (
                'id' => 87,
                'user_id' => 55,
                'card_num' => '170502149371485681563517',
                'is_del' => 0,
                'create_by' => 46,
                'updated_at' => '2017-05-08 17:01:46',
                'created_at' => '2017-05-02 16:47:37',
            ),
            10 => 
            array (
                'id' => 88,
                'user_id' => 55,
                'card_num' => '170502149371509321720801',
                'is_del' => 0,
                'create_by' => 46,
                'updated_at' => '2017-05-08 17:01:46',
                'created_at' => '2017-05-02 16:51:34',
            ),
            11 => 
            array (
                'id' => 92,
                'user_id' => 142,
                'card_num' => '170504149388928759278840',
                'is_del' => 1,
                'create_by' => 46,
                'updated_at' => '2017-05-04 17:14:48',
                'created_at' => '2017-05-04 17:14:48',
            ),
            12 => 
            array (
                'id' => 103,
                'user_id' => 55,
                'card_num' => '170508149423410591663410',
                'is_del' => 1,
                'create_by' => 46,
                'updated_at' => '2017-05-08 17:01:46',
                'created_at' => '2017-05-08 17:01:46',
            ),
            13 => 
            array (
                'id' => 104,
                'user_id' => 143,
                'card_num' => '170508149423662836780240',
                'is_del' => 1,
                'create_by' => 46,
                'updated_at' => '2017-05-08 17:43:49',
                'created_at' => '2017-05-08 17:43:49',
            ),
            14 => 
            array (
                'id' => 105,
                'user_id' => 2,
                'card_num' => '88888888',
                'is_del' => 1,
                'create_by' => 46,
                'updated_at' => '2017-05-11 15:02:52',
                'created_at' => '2017-05-11 15:02:54',
            ),
            15 => 
            array (
                'id' => 106,
                'user_id' => 8,
                'card_num' => '6666666666',
                'is_del' => 1,
                'create_by' => 46,
                'updated_at' => '2017-05-11 15:04:44',
                'created_at' => '2017-05-11 15:04:46',
            ),
        ));
        
        
    }
}
