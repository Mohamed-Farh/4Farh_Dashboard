<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql_file = public_path('4farh_ecom_world.sql');

        $db = [
            'host'      => '127.0.0.1',
            'database'  => '4farh_ecom',
            'username'  => 'root',
            'password'  =>  null,
        ];

        exec("mysql --user={$db['username']} --password={$db['password']} --host={$db['host']} --database={$db['database']} < $sql_file ");
    }
}
