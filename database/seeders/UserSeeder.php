<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'      => 'Administrator',
                'email'     => 'admin@gmail.com',
                'password'  => Hash::make('admin123'),
                'role'      => 'admin',
                'level'     => null,
                'is_active' => true,
            ],
            [
                'name'      => 'Budi Santoso',
                'email'     => 'approver1@gmail.com',
                'password'  => Hash::make('approver123'),
                'role'      => 'approver',
                'level'     => 1,
                'is_active' => true,
            ],
            [
                'name'      => 'Siti Rahayu',
                'email'     => 'approver2@gmail.com',
                'password'  => Hash::make('approver123'),
                'role'      => 'approver',
                'level'     => 2,
                'is_active' => true,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}