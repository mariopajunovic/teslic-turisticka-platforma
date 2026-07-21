<?php

namespace Tests\Feature;

use App\Enums\ContentStatus;
use App\Models\Admin;
use App\Models\Story;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutorIzmjeneModeracijaTest extends TestCase
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

    protected function autor(): User
    {
        return User::create([
            'name' => 'Test Autor',
            'email' => 'autor@komteldoo.com',
            'password' => 'mario123',
            'role' => 'autor',
            'status' => 'aktivan',
        ]);
    }

    protected function objavljena(User $u): Story
    {
        return Story::create([
            'user_id' => $u->id,
            'naslov' => ['sr' => 'Original'],
            'sadrzaj' => ['sr' => 'Original tekst'],
            'status' => ContentStatus::Objavljeno,
            'published_at' => now(),
        ]);
    }

    public function test_izmjena_objavljene_price_ide_u_pending(): void
    {
        $u = $this->autor();
        $s = $this->objavljena($u);

        $this->actingAs($u)->put("/nalog/autor/price/{$s->id}", [
            'naslov' => 'Novi naslov',
            'action' => 'posalji',
        ])->assertRedirect();

        $s->refresh();
        $this->assertSame(ContentStatus::Objavljeno, $s->status);
        $this->assertSame('Original', $s->naslov);
        $this->assertNotNull($s->pending);
        $this->assertSame('Novi naslov', $s->pending['naslov']);
    }

    public function test_admin_odobri_izmjene_price(): void
    {
        $u = $this->autor();
        $s = $this->objavljena($u);
        $s->pending = ['naslov' => 'Odobreni naslov'];
        $s->save();

        $this->actingAs($this->admin(), 'admin')
            ->post("/administracija/price/{$s->id}/odobri-izmjene")
            ->assertRedirect();

        $s->refresh();
        $this->assertNull($s->pending);
        $this->assertSame('Odobreni naslov', $s->naslov);
        $this->assertSame(ContentStatus::Objavljeno, $s->status);
    }

    public function test_admin_odbij_izmjene_price(): void
    {
        $u = $this->autor();
        $s = $this->objavljena($u);
        $s->pending = ['naslov' => 'Odbijeni naslov'];
        $s->save();

        $this->actingAs($this->admin(), 'admin')
            ->post("/administracija/price/{$s->id}/odbij-izmjene")
            ->assertRedirect();

        $s->refresh();
        $this->assertNull($s->pending);
        $this->assertSame('Original', $s->naslov);
    }

    public function test_izmjena_nacrta_price_ide_odmah_uzivo(): void
    {
        $u = $this->autor();
        $s = Story::create([
            'user_id' => $u->id,
            'naslov' => ['sr' => 'Nacrt'],
            'status' => ContentStatus::Nacrt,
        ]);

        $this->actingAs($u)->put("/nalog/autor/price/{$s->id}", [
            'naslov' => 'Nacrt izmijenjen',
            'action' => 'nacrt',
        ])->assertRedirect();

        $s->refresh();
        $this->assertNull($s->pending);
        $this->assertSame('Nacrt izmijenjen', $s->naslov);
        $this->assertSame(ContentStatus::Nacrt, $s->status);
    }
}
