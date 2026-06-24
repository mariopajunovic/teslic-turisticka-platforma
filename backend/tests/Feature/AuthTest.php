<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    protected function user(string $status): User
    {
        return User::create([
            'name' => 'Test Korisnik',
            'email' => 'korisnik@komteldoo.com',
            'password' => Hash::make('mario123'),
            'role' => 'biznis',
            'status' => $status,
        ]);
    }

    public function test_registracija_kreira_nalog_na_odobrenju(): void
    {
        $response = $this->post('/register', [
            'role' => 'biznis',
            'name' => 'Novi Biznis',
            'email' => 'novi@komteldoo.com',
            'telefon' => '065/000-000',
            'password' => 'mario123',
            'password_confirmation' => 'mario123',
        ]);

        $response->assertRedirect('/prijava');
        $this->assertGuest();
        $this->assertDatabaseHas('users', [
            'email' => 'novi@komteldoo.com',
            'role' => 'biznis',
            'status' => 'na_odobrenju',
        ]);
    }

    public function test_prijava_blokirana_dok_je_na_odobrenju(): void
    {
        $this->user('na_odobrenju');

        $this->post('/login', [
            'email' => 'korisnik@komteldoo.com',
            'password' => 'mario123',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_prijava_blokirana_za_blokiran_nalog(): void
    {
        $this->user('blokiran');

        $this->post('/login', [
            'email' => 'korisnik@komteldoo.com',
            'password' => 'mario123',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_aktivan_korisnik_se_prijavljuje(): void
    {
        $this->user('aktivan');

        $this->post('/login', [
            'email' => 'korisnik@komteldoo.com',
            'password' => 'mario123',
        ]);

        $this->assertAuthenticated();
    }

    public function test_odjava(): void
    {
        $user = $this->user('aktivan');

        $this->actingAs($user)->post('/logout');

        $this->assertGuest();
    }
}
