<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class KorisniciAdminTest extends TestCase
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

    protected function korisnik(UserRole $role, string $status = 'aktivan'): User
    {
        return User::create([
            'name' => 'Marko Đukić',
            'email' => 'marko'.uniqid().'@primjer.ba',
            'password' => Hash::make('lozinka123'),
            'role' => $role,
            'status' => $status,
        ]);
    }

    public function test_detail_screen_renders_for_biznis_with_sections(): void
    {
        $user = $this->korisnik(UserRole::Biznis);

        $this->actingAs($this->admin(), 'admin')
            ->get("/administracija/korisnici/{$user->id}")
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->component('Korisnici/Detalji')
                ->where('korisnik.ime', 'Marko Đukić')
                ->where('korisnik.ulogaKljuc', 'biznis')
                ->has('sekcije', 3)
                ->where('sekcije.0.key', 'biznisi')
                ->where('sekcije.0.total', 0)
                ->has('sekcije.0.items')
                ->has('logovi'));
    }

    public function test_detail_screen_for_autor_shows_stories_section(): void
    {
        $user = $this->korisnik(UserRole::Autor);

        $this->actingAs($this->admin(), 'admin')
            ->get("/administracija/korisnici/{$user->id}")
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->has('sekcije', 1)
                ->where('sekcije.0.key', 'price'));
    }

    public function test_update_changes_user_fields_and_logs(): void
    {
        $user = $this->korisnik(UserRole::Autor, 'na_odobrenju');

        $this->actingAs($this->admin(), 'admin')
            ->put("/administracija/korisnici/{$user->id}", [
                'ime' => 'Marko Petrović',
                'email' => 'novi@primjer.ba',
                'uloga' => 'biznis',
                'status' => 'aktivan',
                'telefon' => '065 111 222',
                'bio' => ['sr' => 'Zdravo', 'en' => 'Hello', 'de' => ''],
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Marko Petrović',
            'email' => 'novi@primjer.ba',
            'role' => 'biznis',
            'status' => 'aktivan',
            'telefon' => '065 111 222',
        ]);

        $fresh = $user->fresh();
        $this->assertSame(['sr' => 'Zdravo', 'en' => 'Hello'], $fresh->getTranslations('bio'));

        $this->assertDatabaseHas('activity_log', [
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'event' => 'updated',
        ]);
    }

    public function test_update_requires_role(): void
    {
        $user = $this->korisnik(UserRole::Autor);

        $this->actingAs($this->admin(), 'admin')
            ->put("/administracija/korisnici/{$user->id}", [
                'ime' => 'Marko',
                'email' => 'marko-novi@primjer.ba',
                'status' => 'aktivan',
            ])
            ->assertSessionHasErrors('uloga');
    }

    public function test_update_validates_email_and_status(): void
    {
        $user = $this->korisnik(UserRole::Autor);

        $this->actingAs($this->admin(), 'admin')
            ->put("/administracija/korisnici/{$user->id}", [
                'ime' => 'X',
                'email' => 'nije-email',
                'status' => 'izmisljeno',
            ])
            ->assertSessionHasErrors(['email', 'status']);
    }

    public function test_approve_block_unblock_update_status_and_log(): void
    {
        $admin = $this->admin();
        $user = $this->korisnik(UserRole::Autor, 'na_odobrenju');

        $this->actingAs($admin, 'admin')->post("/administracija/korisnici/{$user->id}/odobri")->assertRedirect();
        $this->assertSame('aktivan', $user->fresh()->status);

        $this->actingAs($admin, 'admin')->post("/administracija/korisnici/{$user->id}/blokiraj")->assertRedirect();
        $this->assertSame('blokiran', $user->fresh()->status);

        $this->actingAs($admin, 'admin')->post("/administracija/korisnici/{$user->id}/odblokiraj")->assertRedirect();
        $this->assertSame('aktivan', $user->fresh()->status);

        $this->assertDatabaseHas('activity_log', [
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'event' => 'updated',
        ]);
    }

    public function test_destroy_deletes_user(): void
    {
        $user = $this->korisnik(UserRole::Autor);

        $this->actingAs($this->admin(), 'admin')
            ->delete("/administracija/korisnici/{$user->id}")
            ->assertRedirect('/administracija/korisnici');

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_role_filter_returns_only_matching_users(): void
    {
        $this->korisnik(UserRole::Autor);
        $this->korisnik(UserRole::Biznis);

        $this->actingAs($this->admin(), 'admin')
            ->get('/administracija/korisnici?uloga=autor')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->component('Korisnici')
                ->has('korisnici.data', 1)
                ->where('korisnici.data.0.ulogaKljuc', 'autor'));
    }
}
