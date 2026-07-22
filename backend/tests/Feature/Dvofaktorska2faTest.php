<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class Dvofaktorska2faTest extends TestCase
{
    use RefreshDatabase;

    protected function adminBez2fa(): Admin
    {
        return Admin::create([
            'name' => 'Test Admin',
            'email' => 'test-admin@komteldoo.com',
            'password' => 'mario123',
            'is_super' => true,
        ]);
    }

    public function test_setup_stranica_generise_qr_i_tajnu(): void
    {
        $this->actingAs($this->adminBez2fa(), 'admin')
            ->get('/administracija/2fa-postavljanje')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->component('PostaviDvofaktorsku')
                ->has('secret')
                ->where('qr', fn ($qr) => is_string($qr) && str_starts_with($qr, 'data:image')));
    }

    public function test_bez_2fa_admin_je_preusmjeren_na_postavljanje(): void
    {
        $this->actingAs($this->adminBez2fa(), 'admin')
            ->get('/administracija')
            ->assertRedirect('/administracija/2fa-postavljanje');
    }
}
