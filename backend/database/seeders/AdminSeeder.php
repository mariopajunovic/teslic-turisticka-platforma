<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $mario = Admin::updateOrCreate(
            ['email' => 'mario@komteldoo.com'],
            [
                'name' => 'Mario Pajunović',
                'password' => 'mario123',
                'is_super' => true,
                'email_verified_at' => now(),
            ],
        );
        $mario->syncRoles(['administrator']);

        $urednik = Admin::updateOrCreate(
            ['email' => 'urednik@komteldoo.com'],
            [
                'name' => 'Demo Urednik',
                'password' => 'mario123',
                'is_super' => false,
                'email_verified_at' => now(),
            ],
        );
        $urednik->syncRoles(['urednik']);
    }
}
