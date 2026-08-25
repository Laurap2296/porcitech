<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            [
                'email' => 'admin@system.com',
            ],
            [
                'name' => 'Administrador',
                'password' => Hash::make('123456'),
                'rol' => 'Administrador',
            ]
        );
    }
}