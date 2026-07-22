<?php

namespace Tests\Feature;

use App\Enums\ContentStatus;
use App\Models\Admin;
use App\Models\Business;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VlasnikSadrzajaTest extends TestCase
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

    protected function korisnik(): User
    {
        return User::create([
            'name' => 'Vlasnik',
            'email' => 'vlasnik@komteldoo.com',
            'password' => 'mario123',
            'role' => 'biznis',
            'status' => 'aktivan',
        ]);
    }

    public function test_admin_veze_biznis_za_korisnika(): void
    {
        $u = $this->korisnik();
        $b = Business::create(['naslov' => ['sr' => 'Biznis'], 'status' => ContentStatus::Nacrt]);

        $this->actingAs($this->admin(), 'admin')
            ->put("/administracija/biznisi/{$b->id}", [
                'naslov' => ['sr' => 'Biznis'],
                'status' => 'nacrt',
                'user_id' => $u->id,
            ])->assertRedirect();

        $this->assertSame($u->id, $b->fresh()->user_id);
    }

    public function test_admin_veze_dogadjaj_za_korisnika(): void
    {
        $u = $this->korisnik();
        $e = Event::create(['naslov' => ['sr' => 'Događaj'], 'datum' => '2026-08-01', 'status' => ContentStatus::Nacrt]);

        $this->actingAs($this->admin(), 'admin')
            ->put("/administracija/dogadjaji/{$e->id}", [
                'naslov' => ['sr' => 'Događaj'],
                'status' => 'nacrt',
                'datum' => '2026-08-01',
                'user_id' => $u->id,
            ])->assertRedirect();

        $this->assertSame($u->id, $e->fresh()->user_id);
    }

    public function test_moze_odvezati_korisnika(): void
    {
        $u = $this->korisnik();
        $b = Business::create(['user_id' => $u->id, 'naslov' => ['sr' => 'Biznis'], 'status' => ContentStatus::Nacrt]);

        $this->actingAs($this->admin(), 'admin')
            ->put("/administracija/biznisi/{$b->id}", [
                'naslov' => ['sr' => 'Biznis'],
                'status' => 'nacrt',
                'user_id' => null,
            ])->assertRedirect();

        $this->assertNull($b->fresh()->user_id);
    }
}
