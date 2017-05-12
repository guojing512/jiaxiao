<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LinksTableSeeder::class);
        $this->call('DsAdminUserTableSeeder');
        $this->call('DsUserExtTableSeeder');
        $this->call('DsCardTableSeeder');
        $this->call('DsCompanyTableSeeder');
        $this->call('DsCityTableSeeder');
        $this->call('DsSubjectTableSeeder');
        $this->call('DsSubjectCourseTableSeeder');
        $this->call('DsMenuTableSeeder');
        $this->call('DsMachineBugTableSeeder');
        $this->call('DsGroupTableSeeder');
        $this->call('DsGroupRoleTableSeeder');
        $this->call('DsCourseAdviceTableSeeder');
    }
}
