<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'code' => '10009',
            'first_name' => 'بشوي',
            'second_name' => 'وجيه',
            'third_name' => 'سليمان',
            'email' => 'admin@gmail.com',
            'phone_number' => '01201026745',
            'login_allow' => '1',
            'password' => bcrypt('123456'),
        ]);

        $role = Role::create(['name' => 'owner']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
