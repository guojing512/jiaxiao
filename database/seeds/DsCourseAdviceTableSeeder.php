<?php

use Illuminate\Database\Seeder;

class DsCourseAdviceTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('ds_course_advice')->delete();
        
        \DB::table('ds_course_advice')->insert(array (
            0 => 
            array (
                'id' => 1,
                'course_id' => 11,
                'advice_score' => 5,
                'advice_title' => '调整座椅',
                'advice_content' => '上车前请调整好座椅，膝盖微曲，能轻松踩到踏板，手臂伸直腕部刚才搭在方向盘上，后背正好靠在座椅上。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:47',
                'created_at' => '2017-04-28 11:41:47',
            ),
            1 => 
            array (
                'id' => 2,
                'course_id' => 11,
                'advice_score' => 0,
                'advice_title' => '安全带',
                'advice_content' => '上车系安全带，可大幅提升安全系数。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:47',
                'created_at' => '2017-04-28 11:41:47',
            ),
            2 => 
            array (
                'id' => 3,
                'course_id' => 11,
                'advice_score' => 5,
                'advice_title' => '检查仪表盘',
                'advice_content' => '上车后需要确认车辆是否熄火状态，手刹是否拉上，踏离合器，检查是否空挡。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:47',
                'created_at' => '2017-04-28 11:41:47',
            ),
            3 => 
            array (
                'id' => 4,
                'course_id' => 11,
                'advice_score' => 10,
                'advice_title' => '启动确认',
                'advice_content' => '启动时，变速器需要至于空挡状态。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:47',
                'created_at' => '2017-04-28 11:41:47',
            ),
            4 => 
            array (
                'id' => 5,
                'course_id' => 12,
                'advice_score' => 0,
                'advice_title' => '转向灯',
                'advice_content' => '起步时需要打左转灯。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:47',
                'created_at' => '2017-04-28 11:41:47',
            ),
            5 => 
            array (
                'id' => 6,
                'course_id' => 12,
                'advice_score' => 0,
                'advice_title' => '刹车踏板',
                'advice_content' => '松手刹前，请先踩住刹车踏板，避免溜车。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:47',
                'created_at' => '2017-04-28 11:41:47',
            ),
            6 => 
            array (
                'id' => 7,
                'course_id' => 12,
                'advice_score' => 5,
                'advice_title' => '起步鸣笛',
                'advice_content' => '出发前需要鸣笛示意。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:47',
                'created_at' => '2017-04-28 11:41:47',
            ),
            7 => 
            array (
                'id' => 8,
                'course_id' => 12,
                'advice_score' => 0,
                'advice_title' => '观望',
                'advice_content' => '车辆启动前需观察左右后视镜与内置后视镜，确认周围安全后起步。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:47',
                'created_at' => '2017-04-28 11:41:47',
            ),
            8 => 
            array (
                'id' => 9,
                'course_id' => 12,
                'advice_score' => 20,
                'advice_title' => '手刹',
                'advice_content' => '起步前需要将手刹松开。注意手刹松到底。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:47',
                'created_at' => '2017-04-28 11:41:47',
            ),
            9 => 
            array (
                'id' => 10,
                'course_id' => 12,
                'advice_score' => 10,
                'advice_title' => '手刹起步',
                'advice_content' => '车辆需要在手刹松开后5面内起步。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:47',
                'created_at' => '2017-04-28 11:41:47',
            ),
            10 => 
            array (
                'id' => 11,
                'course_id' => 12,
                'advice_score' => 0,
                'advice_title' => '起步溜车',
                'advice_content' => '起步时车辆溜车应小于30cm。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:47',
                'created_at' => '2017-04-28 11:41:47',
            ),
            11 => 
            array (
                'id' => 12,
                'course_id' => 12,
                'advice_score' => 10,
                'advice_title' => '提前转向',
                'advice_content' => '在起步时车辆没有移动，不得转动方向盘。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:47',
                'created_at' => '2017-04-28 11:41:47',
            ),
            12 => 
            array (
                'id' => 13,
                'course_id' => 13,
                'advice_score' => 0,
                'advice_title' => '方向不稳',
                'advice_content' => '寻找行驶时要目视前方注意两旁，必须选定好参照物，保持直线行驶，及时修正方向，时刻注意前方各种交通情况，做到及时发现、及时处理。 左右偏移距离50cm之内。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:47',
                'created_at' => '2017-04-28 11:41:47',
            ),
            13 => 
            array (
                'id' => 14,
                'course_id' => 13,
                'advice_score' => 10,
                'advice_title' => '注意后方',
                'advice_content' => '在行驶中需要每过一段时间就要通过后视镜观察后方的交通情况。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:48',
                'created_at' => '2017-04-28 11:41:48',
            ),
            14 => 
            array (
                'id' => 15,
                'course_id' => 13,
                'advice_score' => 0,
                'advice_title' => '车速控制',
                'advice_content' => '通常情况下，应坚持中速行驶，车速不要超过警戒线，既能保证行车安全，又能节油，而考试时就要按照要求来进行加速或者减速。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:48',
                'created_at' => '2017-04-28 11:41:48',
            ),
            15 => 
            array (
                'id' => 16,
                'course_id' => 13,
                'advice_score' => 0,
                'advice_title' => '前车制动',
                'advice_content' => '前方车辆刹车时，需要进行减速保持车距。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:48',
                'created_at' => '2017-04-28 11:41:48',
            ),
            16 => 
            array (
                'id' => 17,
                'course_id' => 13,
                'advice_score' => 0,
                'advice_title' => '观察后视',
                'advice_content' => '正常行驶时观察内、外后视镜，视线不得离开行驶方向超过2秒。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:48',
                'created_at' => '2017-04-28 11:41:48',
            ),
            17 => 
            array (
                'id' => 18,
                'course_id' => 13,
                'advice_score' => 0,
                'advice_title' => '空挡滑行',
                'advice_content' => '在驾驶中，不得出现空挡滑行。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:48',
                'created_at' => '2017-04-28 11:41:48',
            ),
            18 => 
            array (
                'id' => 19,
                'course_id' => 13,
                'advice_score' => 0,
                'advice_title' => '道路实线',
                'advice_content' => '车辆在行驶中不得骑轧车道中心实线或车道边缘实线。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:48',
                'created_at' => '2017-04-28 11:41:48',
            ),
            19 => 
            array (
                'id' => 20,
                'course_id' => 13,
                'advice_score' => 0,
                'advice_title' => '低头看档',
                'advice_content' => '在行驶中不能低头看档或连续2次挂挡不进。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:48',
                'created_at' => '2017-04-28 11:41:48',
            ),
            20 => 
            array (
                'id' => 21,
                'course_id' => 14,
                'advice_score' => 10,
                'advice_title' => '提前打灯',
                'advice_content' => '变更车道前需要提前3秒打转向灯。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:48',
                'created_at' => '2017-04-28 11:41:48',
            ),
            21 => 
            array (
                'id' => 22,
                'course_id' => 14,
                'advice_score' => 10,
                'advice_title' => '转向灯方向',
                'advice_content' => '车辆变更车道方向需要与转向灯方向一致。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:48',
                'created_at' => '2017-04-28 11:41:48',
            ),
            22 => 
            array (
                'id' => 23,
                'course_id' => 14,
                'advice_score' => 10,
                'advice_title' => '关闭转向',
                'advice_content' => '变更完成后，如果转向灯没有自动跳转，要及时关闭转向灯。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:48',
                'created_at' => '2017-04-28 11:41:48',
            ),
            23 => 
            array (
                'id' => 24,
                'course_id' => 14,
                'advice_score' => 0,
                'advice_title' => '注意两侧',
                'advice_content' => '观察后方来车情况，确保安全，在开灯3秒后，向需要变更的车道平稳变更。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:48',
                'created_at' => '2017-04-28 11:41:48',
            ),
            24 => 
            array (
                'id' => 25,
                'course_id' => 14,
                'advice_score' => 0,
                'advice_title' => '安全距离',
                'advice_content' => '变更车道时，判断车辆安全距离，不妨碍其他车辆正常行驶。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:48',
                'created_at' => '2017-04-28 11:41:48',
            ),
            25 => 
            array (
                'id' => 26,
                'course_id' => 14,
                'advice_score' => 0,
                'advice_title' => '每次一道',
                'advice_content' => '变更车道时，不得变更两条或两条以上的车道。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:48',
                'created_at' => '2017-04-28 11:41:48',
            ),
            26 => 
            array (
                'id' => 27,
                'course_id' => 14,
                'advice_score' => 0,
                'advice_title' => '超长压线',
                'advice_content' => '变更车道时骑轧车道分界线行驶不能超过15秒。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:48',
                'created_at' => '2017-04-28 11:41:48',
            ),
            27 => 
            array (
                'id' => 28,
                'course_id' => 15,
                'advice_score' => 0,
                'advice_title' => '观察左右',
                'advice_content' => '直行通过路口时，需要观察左右交通情况，确保安全。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:48',
                'created_at' => '2017-04-28 11:41:48',
            ),
            28 => 
            array (
                'id' => 29,
                'course_id' => 15,
                'advice_score' => 0,
                'advice_title' => '优先他人',
                'advice_content' => '通过路口时，应按规定避让行人和优先通行的车辆。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:48',
                'created_at' => '2017-04-28 11:41:48',
            ),
            29 => 
            array (
                'id' => 30,
                'course_id' => 15,
                'advice_score' => 0,
                'advice_title' => '规定路口',
                'advice_content' => '通过路口时需要按照规定减速慢行或停车瞭望。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:48',
                'created_at' => '2017-04-28 11:41:48',
            ),
            30 => 
            array (
                'id' => 31,
                'course_id' => 15,
                'advice_score' => 0,
                'advice_title' => '转弯注意',
                'advice_content' => '转弯通过路口时需要观察侧前方与侧后方交通情况。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:48',
                'created_at' => '2017-04-28 11:41:48',
            ),
            31 => 
            array (
                'id' => 32,
                'course_id' => 15,
                'advice_score' => 0,
                'advice_title' => '转弯打灯',
                'advice_content' => '转弯通过路口，需要提前3秒打灯。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:48',
                'created_at' => '2017-04-28 11:41:48',
            ),
            32 => 
            array (
                'id' => 33,
                'course_id' => 15,
                'advice_score' => 10,
                'advice_title' => '左侧转弯',
                'advice_content' => '左转弯通过路口，需要靠路中心点左侧转弯，不得超过中心点。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:48',
                'created_at' => '2017-04-28 11:41:48',
            ),
            33 => 
            array (
                'id' => 34,
                'course_id' => 15,
                'advice_score' => 0,
                'advice_title' => '交通堵塞',
                'advice_content' => '在路口出现交通堵塞时，车辆需要在路口内等候，不得驶入已堵塞的交通路口。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:48',
                'created_at' => '2017-04-28 11:41:48',
            ),
            34 => 
            array (
                'id' => 35,
                'course_id' => 15,
                'advice_score' => 0,
                'advice_title' => '红灯事项',
                'advice_content' => '路口红灯亮时，必须在路口内等候，不得闯红灯直行或左转。右转弯第一辆车可不停车减速右转通过。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:48',
                'created_at' => '2017-04-28 11:41:48',
            ),
            35 => 
            array (
                'id' => 36,
                'course_id' => 15,
                'advice_score' => 0,
                'advice_title' => '路口时速',
                'advice_content' => '控制车速，控制在35km/h以下。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:49',
                'created_at' => '2017-04-28 11:41:49',
            ),
            36 => 
            array (
                'id' => 37,
                'course_id' => 15,
                'advice_score' => 0,
                'advice_title' => '黄灯事项',
                'advice_content' => '黄灯亮时，禁止通行，已经越过停车线的车辆可以继续通过。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:49',
                'created_at' => '2017-04-28 11:41:49',
            ),
            37 => 
            array (
                'id' => 38,
                'course_id' => 16,
                'advice_score' => 0,
                'advice_title' => '安全距离',
                'advice_content' => '没有中心隔离设施或中心线道路上会车，与其他车辆、行人、非机动车需要保持安全距离。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:49',
                'created_at' => '2017-04-28 11:41:49',
            ),
            38 => 
            array (
                'id' => 39,
                'course_id' => 16,
                'advice_score' => 0,
                'advice_title' => '预先准备',
                'advice_content' => '优先预留出横向安全距离，避免紧急转向来避让对方车辆。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:49',
                'created_at' => '2017-04-28 11:41:49',
            ),
            39 => 
            array (
                'id' => 40,
                'course_id' => 16,
                'advice_score' => 0,
                'advice_title' => '观察情况',
                'advice_content' => '超车前需要观察内、外后视镜和左侧交通情况。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:49',
                'created_at' => '2017-04-28 11:41:49',
            ),
            40 => 
            array (
                'id' => 41,
                'course_id' => 16,
                'advice_score' => 0,
                'advice_title' => '影响他人',
                'advice_content' => '超车时应选择合理的时机，不得影响其他车辆正常行驶。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:49',
                'created_at' => '2017-04-28 11:41:49',
            ),
            41 => 
            array (
                'id' => 42,
                'course_id' => 16,
                'advice_score' => 0,
                'advice_title' => '超后观察',
                'advice_content' => '超车后，应观察被超车辆动态，并做及时调整。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:49',
                'created_at' => '2017-04-28 11:41:49',
            ),
            42 => 
            array (
                'id' => 43,
                'course_id' => 16,
                'advice_score' => 0,
                'advice_title' => '超后距离',
                'advice_content' => '超车后，应与后车保持安全距离。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:49',
                'created_at' => '2017-04-28 11:41:49',
            ),
            43 => 
            array (
                'id' => 44,
                'course_id' => 16,
                'advice_score' => 0,
                'advice_title' => '急转回道',
                'advice_content' => '在超车成功后，车辆不得急转驶回原先车道，并妨碍被超车辆正常行驶。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:49',
                'created_at' => '2017-04-28 11:41:49',
            ),
            44 => 
            array (
                'id' => 45,
                'course_id' => 16,
                'advice_score' => 0,
                'advice_title' => '右侧超车',
                'advice_content' => '不得从右侧超车。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:49',
                'created_at' => '2017-04-28 11:41:49',
            ),
            45 => 
            array (
                'id' => 46,
                'course_id' => 16,
                'advice_score' => 10,
                'advice_title' => '礼貌让行',
                'advice_content' => '在行驶中，后车发出超车信号时，应在具备让车条件下减速靠右让行。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:49',
                'created_at' => '2017-04-28 11:41:49',
            ),
            46 => 
            array (
                'id' => 47,
                'course_id' => 17,
                'advice_score' => 0,
                'advice_title' => '道路情况',
                'advice_content' => '掉头时，应观察当时交通情况选择掉头时机。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:49',
                'created_at' => '2017-04-28 11:41:49',
            ),
            47 => 
            array (
                'id' => 48,
                'course_id' => 17,
                'advice_score' => 0,
                'advice_title' => '掉头地点',
                'advice_content' => '掉头地点选择有误。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:49',
                'created_at' => '2017-04-28 11:41:49',
            ),
            48 => 
            array (
                'id' => 49,
                'course_id' => 17,
                'advice_score' => 0,
                'advice_title' => '掉头信号',
                'advice_content' => '掉头前需要提前打左转灯，示意其他车辆。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:49',
                'created_at' => '2017-04-28 11:41:49',
            ),
            49 => 
            array (
                'id' => 50,
                'course_id' => 17,
                'advice_score' => 10,
                'advice_title' => '妨碍他人',
                'advice_content' => '掉头时，应避免妨碍正常行驶的其他车辆和行人通行。',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:49',
                'created_at' => '2017-04-28 11:41:49',
            ),
            50 => 
            array (
                'id' => 51,
                'course_id' => 18,
                'advice_score' => 0,
                'advice_title' => '靠边停车',
                'advice_content' => '停车前，需要通过内、外后视镜观察后方和右侧交通情况。不合格',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:49',
                'created_at' => '2017-04-28 11:41:49',
            ),
            51 => 
            array (
                'id' => 52,
                'course_id' => 18,
                'advice_score' => 10,
                'advice_title' => '规定距离',
                'advice_content' => '靠边停车需要车辆靠近道路右侧边缘或人行道边缘线不超过30cm。扣10分',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:49',
                'created_at' => '2017-04-28 11:41:49',
            ),
            52 => 
            array (
                'id' => 53,
                'course_id' => 18,
                'advice_score' => 0,
                'advice_title' => '停车位置',
                'advice_content' => '停车后，车身不能超过道路右侧边缘或人行道边缘线。不合格',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:49',
                'created_at' => '2017-04-28 11:41:49',
            ),
            53 => 
            array (
                'id' => 54,
                'course_id' => 18,
                'advice_score' => 10,
                'advice_title' => '停车手刹',
                'advice_content' => '停车后，车辆需要将手刹拉紧，避免溜车。扣10分',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:49',
                'created_at' => '2017-04-28 11:41:49',
            ),
            54 => 
            array (
                'id' => 55,
                'course_id' => 18,
                'advice_score' => 10,
                'advice_title' => '制动踏板',
                'advice_content' => '在手刹拉紧前请不要将制动踏板松开。扣10分',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:49',
                'created_at' => '2017-04-28 11:41:49',
            ),
            55 => 
            array (
                'id' => 56,
                'course_id' => 18,
                'advice_score' => 5,
                'advice_title' => '下车熄火',
                'advice_content' => '下车前，需要将发动机熄火。扣5分',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:50',
                'created_at' => '2017-04-28 11:41:50',
            ),
            56 => 
            array (
                'id' => 57,
                'course_id' => 19,
                'advice_score' => 0,
                'advice_title' => '通过慢行',
                'advice_content' => '通过人行横道、学校区域、公共汽车站时速应当减速慢行，控制车速在30km/h以下。不合格',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:50',
                'created_at' => '2017-04-28 11:41:50',
            ),
            57 => 
            array (
                'id' => 58,
                'course_id' => 19,
                'advice_score' => 0,
                'advice_title' => '礼貌让行',
                'advice_content' => '在通过人行横道、学校区域、公共汽车站时，应礼貌让行人先行，必要时应停车让行。不合格',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:50',
                'created_at' => '2017-04-28 11:41:50',
            ),
            58 => 
            array (
                'id' => 59,
                'course_id' => 19,
                'advice_score' => 0,
                'advice_title' => '观察周围',
                'advice_content' => '通过人行横道、学校区域、公共汽车站时，应道观察左右交通情况。不合格',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:50',
                'created_at' => '2017-04-28 11:41:50',
            ),
            59 => 
            array (
                'id' => 60,
                'course_id' => 19,
                'advice_score' => 0,
                'advice_title' => '禁止鸣笛',
                'advice_content' => '在车辆通过学校区域时不得鸣笛。不合格',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:50',
                'created_at' => '2017-04-28 11:41:50',
            ),
            60 => 
            array (
                'id' => 61,
                'course_id' => 21,
                'advice_score' => 0,
                'advice_title' => '夜间开灯',
                'advice_content' => '行驶前，需要正确开启灯光。不合格',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:50',
                'created_at' => '2017-04-28 11:41:50',
            ),
            61 => 
            array (
                'id' => 62,
                'course_id' => 21,
                'advice_score' => 0,
                'advice_title' => '同行远光',
                'advice_content' => '在同方向近距离跟车行驶中，不要使用远光灯。不合格',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:50',
                'created_at' => '2017-04-28 11:41:50',
            ),
            62 => 
            array (
                'id' => 63,
                'course_id' => 21,
                'advice_score' => 0,
                'advice_title' => '交替远近',
                'advice_content' => '在车辆通过急弯、破路、拱桥、人行横道或没有交通信号灯路口时，需要交替使用远、近光灯示意，确保行驶安全。不合格',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:50',
                'created_at' => '2017-04-28 11:41:50',
            ),
            63 => 
            array (
                'id' => 64,
                'course_id' => 21,
                'advice_score' => 0,
                'advice_title' => '通过路口',
                'advice_content' => '在通过路口时不能使用远光灯。不合格',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:50',
                'created_at' => '2017-04-28 11:41:50',
            ),
            64 => 
            array (
                'id' => 65,
                'course_id' => 21,
                'advice_score' => 0,
                'advice_title' => '夜间超车',
                'advice_content' => '夜间超车时，需要交替使用远、近光灯提醒被超越车辆。不合格',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:50',
                'created_at' => '2017-04-28 11:41:50',
            ),
            65 => 
            array (
                'id' => 66,
                'course_id' => 21,
                'advice_score' => 0,
                'advice_title' => '周围明亮',
                'advice_content' => '在有路灯、照明良好的道路上行驶时，不能使用远光灯。不合格',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:50',
                'created_at' => '2017-04-28 11:41:50',
            ),
            66 => 
            array (
                'id' => 67,
                'course_id' => 21,
                'advice_score' => 5,
                'advice_title' => '灯光昏暗',
                'advice_content' => '进入无照明、照明不良的道路行驶时需要开启远光灯，确保安全。扣5分',
                'sort_num' => 0,
                'updated_at' => '2017-04-28 11:41:50',
                'created_at' => '2017-04-28 11:41:50',
            ),
        ));
        
        
    }
}
