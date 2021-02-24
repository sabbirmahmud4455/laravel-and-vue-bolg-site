<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class userSeeder extends Seeder
{ 
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'full_name' => 'sabbir',
            'email' => 'sabbir@gmail.com',
            'role_id'=>1,
            'password' =>bcrypt('12345678'),
        ]);
        DB::table('roles')->insert([
            'role_name' => 'Admin',
            'permission' => '[{"permissionName":"Category","read":true,"write":true,"update":true,"delete":true},{"permissionName":"Tag","read":true,"write":true,"update":true,"delete":true},{"permissionName":"User","read":true,"write":true,"update":true,"delete":true},{"permissionName":"User Role","read":true,"write":true,"update":true,"delete":true},{"permissionName":"Role Permission","read":true,"update":true,"write":true,"delete":true}]',
        ]);

    }
}
