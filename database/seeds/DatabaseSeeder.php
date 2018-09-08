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
        // DB::statement('SET session_replication_role = replica;');
        $this->call(UserTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        // DB::statement('SET session_replication_role = DEFAULT;');
    }
}
