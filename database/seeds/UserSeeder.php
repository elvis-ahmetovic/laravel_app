<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'super',
            'lastname' => 'administrator',
            'username' => 'admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('password'),
            'city' => 'Super City',
            'role' => 'superadmin',
            'admin_status' => 1
        ]);

        factory(App\User::class, 10)->create();
    }
}
