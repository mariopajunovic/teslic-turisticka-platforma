<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    protected function admin(): Admin
    {
        $admin = Admin::create([
            'name' => 'Test Admin',
            'email' => 'test-admin@komteldoo.com',
            'password' => 'mario123',
            'is_super' => true,
        ]);
        $admin->saveAppAuthenticationSecret('JBSWY3DPEHPK3PXP');

        return $admin;
    }

    public function test_public_home_renders(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_admin_login_available(): void
    {
        $this->get('/admin/login')->assertOk();
    }

    public static function resources(): array
    {
        return [
            'businesses' => ['businesses'],
            'locations' => ['locations'],
            'events' => ['events'],
            'ads' => ['ads'],
            'stories' => ['stories'],
            'news' => ['news'],
            'categories' => ['categories'],
            'menus' => ['menus'],
            'pages' => ['pages'],
            'users' => ['users'],
        ];
    }

    public function test_admin_can_open_activity_log(): void
    {
        $this->actingAs($this->admin(), 'admin')
            ->get('/admin/activities')
            ->assertOk();
    }

    public function test_urednik_nema_pristup_korisnicima_ali_ima_sadrzaju(): void
    {
        $this->seed(\Database\Seeders\RolePermissionSeeder::class);

        $urednik = Admin::create([
            'name' => 'Urednik',
            'email' => 'urednik-test@komteldoo.com',
            'password' => 'mario123',
            'is_super' => false,
        ]);
        $urednik->saveAppAuthenticationSecret('JBSWY3DPEHPK3PXP');
        $urednik->assignRole('urednik');

        $this->actingAs($urednik, 'admin')->get('/admin/users')->assertForbidden();
        $this->actingAs($urednik, 'admin')->get('/admin/businesses')->assertOk();
    }

    public function test_admin_can_open_site_settings(): void
    {
        $this->actingAs($this->admin(), 'admin')
            ->get('/admin/manage-site-settings')
            ->assertOk();
    }

    #[DataProvider('resources')]
    public function test_admin_can_open_resource_list(string $resource): void
    {
        $this->actingAs($this->admin(), 'admin')
            ->get("/admin/{$resource}")
            ->assertOk();
    }

    #[DataProvider('resources')]
    public function test_admin_can_open_resource_create(string $resource): void
    {
        $this->actingAs($this->admin(), 'admin')
            ->get("/admin/{$resource}/create")
            ->assertOk();
    }
}
