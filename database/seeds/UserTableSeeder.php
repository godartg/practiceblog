<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

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
        Role::truncate();

        $adminRole = Role::create([ 'name' => 'Admin' ]);
        $writerRole = Role::create([ 'name' => 'Writer' ]);

        $admin = new User;
        $admin->name = 'Admin';
        $admin->email = 'admin@admin.com';
        $admin->password = bcrypt('123456');
        $admin->save();

        $admin->assignRole($adminRole);

        $writer = new User;
        $writer->name = 'Escritor';
        $writer->email = 'escritor@escritor.com';
        $writer->password = bcrypt('123456');
        $writer->save();

        $writer->assignRole($writerRole);
    }
}
