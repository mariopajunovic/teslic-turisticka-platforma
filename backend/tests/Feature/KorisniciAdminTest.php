<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Admin;
use App\Models\User;
use App\Notifications\KorisnikLozinkaLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
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

    public function test_can_create_user_and_sends_set_password_link(): void
    {
        $this->actingAs($this->admin(), 'admin')
            ->post('/administracija/korisnici', [
                'ime' => 'Nova Osoba',
                'email' => 'nova@primjer.ba',
                'uloga' => 'autor',
                'status' => 'aktivan',
                'telefon' => '065 999 000',
            ])
            ->assertRedirect()
            ->assertSessionHas('status');

        $this->assertDatabaseHas('users', [
            'email' => 'nova@primjer.ba',
            'role' => 'autor',
            'status' => 'aktivan',
            'telefon' => '065 999 000',
        ]);
    }

    public function test_create_user_without_email_skips_notification(): void
    {
        Notification::fake();

        $this->actingAs($this->admin(), 'admin')
            ->post('/administracija/korisnici', [
                'ime' => 'Bez Poziva',
                'email' => 'bez@primjer.ba',
                'uloga' => 'autor',
                'status' => 'aktivan',
                'posalji_email' => false,
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('users', ['email' => 'bez@primjer.ba']);
        Notification::assertNothingSent();
    }

    public function test_send_password_link_later_uses_new_account_variant(): void
    {
        Notification::fake();
        $user = $this->korisnik(UserRole::Autor);

        $this->actingAs($this->admin(), 'admin')
            ->post("/administracija/korisnici/{$user->id}/reset-lozinke")
            ->assertRedirect()
            ->assertSessionHas('status');

        Notification::assertSentTo($user, KorisnikLozinkaLink::class, function ($notification) {
            return $notification->noviNalog === true;
        });
    }

    public function test_create_user_validates_email_and_role(): void
    {
        $existing = $this->korisnik(UserRole::Autor);

        $this->actingAs($this->admin(), 'admin')
            ->post('/administracija/korisnici', [
                'ime' => 'X',
                'email' => $existing->email,
                'status' => 'aktivan',
            ])
            ->assertSessionHasErrors(['email', 'uloga']);
    }

    public function test_email_change_resets_verification(): void
    {
        $user = $this->korisnik(UserRole::Autor);
        $user->forceFill(['email_verified_at' => now()])->save();

        $this->actingAs($this->admin(), 'admin')
            ->put("/administracija/korisnici/{$user->id}", [
                'ime' => $user->name,
                'email' => 'promijenjen@primjer.ba',
                'uloga' => 'autor',
                'status' => 'aktivan',
            ])
            ->assertRedirect();

        $this->assertNull($user->fresh()->email_verified_at);
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

    public function test_reset_password_link_sends_without_route_error(): void
    {
        $user = $this->korisnik(UserRole::Autor);

        $this->actingAs($this->admin(), 'admin')
            ->post("/administracija/korisnici/{$user->id}/reset-lozinke")
            ->assertRedirect()
            ->assertSessionHas('status');
    }

    public function test_public_reset_password_form_renders(): void
    {
        $this->get('/reset-lozinke/neki-token?email=korisnik@primjer.ba')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->component('ResetPassword')
                ->where('token', 'neki-token')
                ->where('email', 'korisnik@primjer.ba'));
    }

    public function test_destroy_deletes_user(): void
    {
        $user = $this->korisnik(UserRole::Autor);

        $this->actingAs($this->admin(), 'admin')
            ->delete("/administracija/korisnici/{$user->id}")
            ->assertRedirect('/administracija/korisnici');

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function test_can_upload_and_remove_avatar(): void
    {
        Storage::fake('public');
        $admin = $this->admin();
        $user = $this->korisnik(UserRole::Autor);

        $this->actingAs($admin, 'admin')
            ->post("/administracija/korisnici/{$user->id}/avatar", [
                'image' => UploadedFile::fake()->image('avatar.jpg', 400, 400),
            ])
            ->assertRedirect();

        $this->assertNotNull($user->fresh()->getFirstMedia('avatar'));

        $this->actingAs($admin, 'admin')
            ->delete("/administracija/korisnici/{$user->id}/avatar")
            ->assertRedirect();

        $this->assertNull($user->fresh()->getFirstMedia('avatar'));
    }

    public function test_avatar_upload_rejects_non_image(): void
    {
        $user = $this->korisnik(UserRole::Autor);

        $this->actingAs($this->admin(), 'admin')
            ->post("/administracija/korisnici/{$user->id}/avatar", [
                'image' => UploadedFile::fake()->create('dokument.pdf', 100, 'application/pdf'),
            ])
            ->assertSessionHasErrors('image');
    }

    public function test_can_restore_soft_deleted_user(): void
    {
        $user = $this->korisnik(UserRole::Autor);
        $user->delete();

        $this->actingAs($this->admin(), 'admin')
            ->post("/administracija/korisnici/{$user->id}/vrati")
            ->assertRedirect();

        $this->assertNotSoftDeleted('users', ['id' => $user->id]);
    }

    public function test_can_permanently_delete_user(): void
    {
        $user = $this->korisnik(UserRole::Autor);
        $user->delete();

        $this->actingAs($this->admin(), 'admin')
            ->delete("/administracija/korisnici/{$user->id}/trajno")
            ->assertRedirect();

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_trashed_tab_lists_only_deleted_users(): void
    {
        $this->korisnik(UserRole::Autor);
        $deleted = $this->korisnik(UserRole::Biznis);
        $deleted->delete();

        $this->actingAs($this->admin(), 'admin')
            ->get('/administracija/korisnici?status=obrisani')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->has('korisnici.data', 1)
                ->where('korisnici.data.0.obrisan', true));
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
