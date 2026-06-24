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
        return Admin::create([
            'name' => 'Test Admin',
            'email' => 'test-admin@komteldoo.com',
            'password' => 'mario123',
            'is_super' => true,
        ]);
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
        ];
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
