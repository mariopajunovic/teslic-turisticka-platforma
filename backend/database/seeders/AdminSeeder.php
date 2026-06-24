<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'mario@komteldoo.com'],
            [
                'name' => 'Mario Pajunović',
                'password' => 'mario123',
                'is_super' => true,
                'email_verified_at' => now(),
            ],
        );
    }
}
