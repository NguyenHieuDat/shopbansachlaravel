<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Roles;
use DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::truncate();
        DB::table('admin_roles')->truncate();
        $adminRoles = Roles::where('role_name','admin')->first();
        $userRoles = Roles::where('role_name','user')->first();

        $admin = Admin::create([
            'admin_name' => 'datnguyenadmin',
            'admin_email' => 'datnguyenadmin@gmail.com',
            'admin_phone' => '0123456789',
            'admin_password' => bcrypt('12345')
        ]);
        $user = Admin::create([
            'admin_name' => 'datnguyenuser',
            'admin_email' => 'datnguyenuser@gmail.com',
            'admin_phone' => '0123456789',
            'admin_password' => bcrypt('12345')
        ]);

        $admin->roles()->attach($adminRoles);
        $user->roles()->attach($userRoles);

        \App\Models\Admin::factory(5)->create();
    }
}
