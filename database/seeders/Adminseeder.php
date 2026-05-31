<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'ekalinga123@gmail.com'],
            [
                'name'     => 'eKalinga Admin',
                'password' => Hash::make('Admin@1234'),
                'role'     => 'admin',
            ]
        );
    }
}