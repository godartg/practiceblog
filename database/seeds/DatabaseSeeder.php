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
        DB::statement('ALTER roles DISABLE TRIGGER ALL;');
        $this->call(UserTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        DB::statement('ALTER roles ENABLE TRIGGER ALL;');
    }
}
