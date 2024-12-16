<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'Admin'])->syncPermissions(Permission::pluck('id','id')->all());
        Role::create(['name' => 'Owner'])->syncPermissions([
            'property-list','property-create','property-edit','property-delete',
            'rent-list','rent-create','rent-edit','rent-delete'
        ]);
        Role::create(['name' => 'Resident'])->syncPermissions([
            'property-list'
        ]);
        // $default = array(
        //     array(
        //         'role_name' => 'Admin',
        //         'role_level' => 10
        //     ),
        //     array(
        //         'role_name' => 'Owner',
        //         'role_level' => 5
        //     ),
        //     array(
        //         'role_name' => 'Residents',
        //         'role_level' => 1
        //     ),
        // );

        // foreach ($default as $role) {
        //     Roles::create([
        //         'role_name' => $role['role_name'],
        //         'role_level' => $role['role_level']
        //     ]);
        // }
    }
}
