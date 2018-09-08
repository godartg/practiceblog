<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("TRUNCATE TABLE roles RESTART IDENTITY CASCADE");
        $this->call(UserTableSeeder::class);
        $this->call(PostsTableSeeder::class);

    }
}
