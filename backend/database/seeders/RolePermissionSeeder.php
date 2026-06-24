<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public const PERMISIJE = [
        'upravljanje sadržajem',
        'upravljanje korisnicima',
        'upravljanje stranicama',
        'sistemske postavke',
        'pregled logova',
    ];

    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (self::PERMISIJE as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'admin']);
        }

        $administrator = Role::firstOrCreate(['name' => 'administrator', 'guard_name' => 'admin']);
        $administrator->syncPermissions(self::PERMISIJE);

        $urednik = Role::firstOrCreate(['name' => 'urednik', 'guard_name' => 'admin']);
        $urednik->syncPermissions(['upravljanje sadržajem', 'pregled logova']);
    }
}
