<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
        Permission::truncate();

        $adminRole = Role::create([ 'name' => 'Admin' ]);
        $writerRole = Role::create([ 'name' => 'Writer' ]);

        $viewPostPermission = Permission::create([ 'name' => 'View posts' ]);
        $createPostPermission = Permission::create([ 'name' => 'Create posts' ]);
        $updatePostPermission = Permission::create([ 'name' => 'Update posts' ]);
        $deletePostPermission = Permission::create([ 'name' => 'Delete posts' ]);

        $viewUserPermission = Permission::create([ 'name' => 'View users' ]);
        $createUserPermission = Permission::create([ 'name' => 'Create users' ]);
        $updateUserPermission = Permission::create([ 'name' => 'Update users' ]);
        $deleteUserPermission = Permission::create([ 'name' => 'Delete users' ]);

        $updateRolesPermission = Permission::create([ 'name' => 'Update roles' ]);

        $admin = new User;
        $admin->name = 'Admin';
        $admin->email = 'admin@admin.com';
        $admin->password = '123456';
        $admin->save();

        $admin->assignRole($adminRole);

        $writer = new User;
        $writer->name = 'Escritor';
        $writer->email = 'escritor@escritor.com';
        $writer->password = '123456';
        $writer->save();

        $writer->assignRole($writerRole);
    }
}
