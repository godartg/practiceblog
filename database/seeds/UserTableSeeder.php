<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456')
        ]);
        User::create([
        	'name' => 'admin2',
        	'email' => 'admin2@admin.com',
        	'password' => bcrypt('123456')
        ]);
    }
}
