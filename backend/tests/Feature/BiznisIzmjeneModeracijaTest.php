<?php

namespace Tests\Feature;

use App\Enums\ContentStatus;
use App\Models\Admin;
use App\Models\Business;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BiznisIzmjeneModeracijaTest extends TestCase
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

    protected function biznis(): User
    {
        return User::create([
            'name' => 'Test Biznis',
            'email' => 'biznis@komteldoo.com',
            'password' => 'mario123',
            'role' => 'biznis',
            'status' => 'aktivan',
        ]);
    }

    protected function objavljeni(User $u): Business
    {
        return Business::create([
            'user_id' => $u->id,
            'naslov' => ['sr' => 'Original'],
            'opis' => ['sr' => 'Original opis'],
            'status' => ContentStatus::Objavljeno,
            'published_at' => now(),
        ]);
    }

    public function test_izmjena_objavljenog_ide_u_pending_ne_dira_zivo(): void
    {
        $u = $this->biznis();
        $b = $this->objavljeni($u);

        $this->actingAs($u)->post("/nalog/biznis/objave/{$b->id}", [
            'naslov' => 'Novi naziv',
            'action' => 'posalji',
        ])->assertRedirect();

        $b->refresh();
        $this->assertSame(ContentStatus::Objavljeno, $b->status);
        $this->assertSame('Original', $b->naslov);
        $this->assertNotNull($b->pending);
        $this->assertSame('Novi naziv', $b->pending['naslov']);
    }

    public function test_admin_odobri_izmjene_prelije_u_zivo(): void
    {
        $u = $this->biznis();
        $b = $this->objavljeni($u);
        $b->pending = ['naslov' => 'Odobreni naziv'];
        $b->save();

        $b->primijeniPending();
        $b->refresh();

        $this->assertNull($b->pending);
        $this->assertSame('Odobreni naziv', $b->naslov);
        $this->assertSame(ContentStatus::Objavljeno, $b->status);
    }

    public function test_admin_odbij_izmjene_zadrzi_zivo(): void
    {
        $u = $this->biznis();
        $b = $this->objavljeni($u);
        $b->pending = ['naslov' => 'Odbijeni naziv'];
        $b->save();

        $b->odbaciPending();
        $b->refresh();

        $this->assertNull($b->pending);
        $this->assertSame('Original', $b->naslov);
    }

    public function test_izmjena_nacrta_ide_odmah_uzivo(): void
    {
        $u = $this->biznis();
        $b = Business::create([
            'user_id' => $u->id,
            'naslov' => ['sr' => 'Nacrt'],
            'status' => ContentStatus::Nacrt,
        ]);

        $this->actingAs($u)->post("/nalog/biznis/objave/{$b->id}", [
            'naslov' => 'Nacrt izmijenjen',
            'action' => 'nacrt',
        ])->assertRedirect();

        $b->refresh();
        $this->assertNull($b->pending);
        $this->assertSame('Nacrt izmijenjen', $b->naslov);
        $this->assertSame(ContentStatus::Nacrt, $b->status);
    }

    public function test_admin_ruta_odobri_izmjene(): void
    {
        $u = $this->biznis();
        $b = $this->objavljeni($u);
        $b->pending = ['naslov' => 'Odobreno kroz rutu'];
        $b->save();

        $this->actingAs($this->admin(), 'admin')
            ->post("/administracija/biznisi/{$b->id}/odobri-izmjene")
            ->assertRedirect();

        $b->refresh();
        $this->assertNull($b->pending);
        $this->assertSame('Odobreno kroz rutu', $b->naslov);
        $this->assertSame(ContentStatus::Objavljeno, $b->status);
    }

    public function test_admin_ruta_odbij_izmjene(): void
    {
        $u = $this->biznis();
        $b = $this->objavljeni($u);
        $b->pending = ['naslov' => 'Odbijeno kroz rutu'];
        $b->save();

        $this->actingAs($this->admin(), 'admin')
            ->post("/administracija/biznisi/{$b->id}/odbij-izmjene")
            ->assertRedirect();

        $b->refresh();
        $this->assertNull($b->pending);
        $this->assertSame('Original', $b->naslov);
    }
}
