<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ContactInformation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $default = array(
            array(
                'username' => 'Admin',
                'email' => 'rafbbbb@gmail.com',
                'password' => '12345678',
                'first_name' => 'Rafi',
                'last_name' => 'Hidayat',
                'gender' => 'Laki-laki',
                'id_role' => 1,
            ),
            array(
                'username' => 'Penghuni',
                'email' => 'penghuni@gmail.com',
                'password' => '12345678',
                'first_name' => 'Peng',
                'last_name' => 'Nigga',
                'gender' => 'Laki-laki',
                'id_role' => 3,
            ),
        );

        foreach ($default as $users) {
            $user = User::create([
                'username' => $users['username'],
                'email' => $users['email'],
                'password' => Hash::make($users['password']),
            ]);
            $contact = ContactInformation::create([
                'id_user' => $user->id_user,
                'first_name' => $users['first_name'],
                'last_name' => $users['last_name'],
                'email' => $users['email'],
                'gender' => $users['gender'],
                'no_hp' => ''
            ]);
            
            $userx = User::find($user->id_user);
            $userx->assignRole(Role::find($users['id_role'])->name);
        }
    }
}
