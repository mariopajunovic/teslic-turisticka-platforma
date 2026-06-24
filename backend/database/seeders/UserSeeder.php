<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'biznis@komteldoo.com'],
            [
                'name' => 'Demo Biznis',
                'password' => 'mario123',
                'role' => UserRole::Biznis,
                'status' => 'aktivan',
                'email_verified_at' => now(),
            ],
        );

        User::updateOrCreate(
            ['email' => 'autor@komteldoo.com'],
            [
                'name' => 'Demo Autor',
                'password' => 'mario123',
                'role' => UserRole::Autor,
                'status' => 'aktivan',
                'email_verified_at' => now(),
            ],
        );
    }
}
