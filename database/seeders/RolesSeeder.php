<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $default = array(
            array(
                'role_name' => 'Admin',
                'role_level' => 10
            ),
            array(
                'role_name' => 'Owner',
                'role_level' => 5
            ),
            array(
                'role_name' => 'Residents',
                'role_level' => 1
            ),
        );

        foreach ($default as $role) {
            Roles::create([
                'role_name' => $role['role_name'],
                'role_level' => $role['role_level']
            ]);
        }
    }
}
