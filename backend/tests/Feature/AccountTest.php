<?php

namespace Tests\Feature;

use App\Enums\ContentStatus;
use App\Models\Ad;
use App\Models\Business;
use App\Models\Story;
use App\Models\User;
use App\Notifications\ContentStatusChanged;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    protected function user(string $role): User
    {
        return User::create([
            'name' => 'Test Korisnik',
            'email' => $role.'@komteldoo.com',
            'password' => 'mario123',
            'role' => $role,
            'status' => 'aktivan',
        ]);
    }

    public function test_gost_se_preusmjerava_na_prijavu(): void
    {
        $this->get('/nalog/autor/price')->assertRedirect('/prijava');
    }

    public function test_autor_vidi_svoje_price(): void
    {
        $this->actingAs($this->user('autor'))
            ->get('/nalog/autor/price')
            ->assertOk();
    }

    public function test_biznis_nema_pristup_autor_panelu(): void
    {
        $this->actingAs($this->user('biznis'))
            ->get('/nalog/autor/price')
            ->assertForbidden();
    }

    public function test_autor_salje_pricu_na_odobrenje(): void
    {
        $autor = $this->user('autor');

        $this->actingAs($autor)->post('/nalog/autor/price', [
            'naslov' => 'Moja prva priča',
            'izvod' => 'Kratak izvod.',
            'sadrzaj' => 'Sadržaj priče.',
            'action' => 'posalji',
        ])->assertRedirect('/nalog/autor/price');

        $story = Story::where('user_id', $autor->id)->first();
        $this->assertNotNull($story);
        $this->assertSame(ContentStatus::Poslano, $story->status);
    }

    public function test_biznis_uredjuje_profil_naloga(): void
    {
        $biznis = $this->user('biznis');

        $this->actingAs($biznis)->post('/nalog/biznis/profil', [
            'name' => 'Pčelarstvo Đukić',
            'telefon' => '065/111-222',
            'bio' => 'Domaći med.',
        ])->assertRedirect('/nalog/biznis/profil');

        $this->assertSame('Domaći med.', $biznis->fresh()->bio);
    }

    public function test_biznis_kreira_objavu_i_salje(): void
    {
        $biznis = $this->user('biznis');

        $this->actingAs($biznis)->post('/nalog/biznis/objave', [
            'naslov' => 'Moja objava',
            'opis_dug' => 'Opis.',
            'action' => 'posalji',
        ])->assertRedirect();

        $business = Business::where('user_id', $biznis->id)->first();
        $this->assertNotNull($business);
        $this->assertSame(ContentStatus::Poslano, $business->status);
    }

    public function test_biznis_salje_oglas_na_odobrenje(): void
    {
        $biznis = $this->user('biznis');

        $this->actingAs($biznis)->post('/nalog/biznis/oglasi', [
            'naslov' => 'Prodaja meda',
            'action' => 'posalji',
        ])->assertRedirect('/nalog/biznis/oglasi');

        $ad = Ad::where('user_id', $biznis->id)->first();
        $this->assertNotNull($ad);
        $this->assertSame(ContentStatus::Poslano, $ad->status);
    }

    public function test_autor_uredjuje_profil(): void
    {
        $autor = $this->user('autor');

        $this->actingAs($autor)->post('/nalog/autor/profil', [
            'name' => 'Marko Đukić',
            'bio' => 'Pišem o kraju.',
        ])->assertRedirect('/nalog/autor/profil');

        $this->assertSame('Pišem o kraju.', $autor->fresh()->bio);
    }

    public function test_biznis_stranice_rade(): void
    {
        $biznis = $this->user('biznis');

        $this->actingAs($biznis)->get('/nalog/biznis/objave')->assertOk();
        $this->actingAs($biznis)->get('/nalog/biznis/objave/nova')->assertOk();
        $this->actingAs($biznis)->get('/nalog/biznis/profil')->assertOk();
    }

    public function test_obavijest_se_salje_pri_objavi(): void
    {
        Notification::fake();

        $autor = $this->user('autor');
        $story = Story::create([
            'user_id' => $autor->id,
            'naslov' => 'Priča',
            'status' => ContentStatus::Poslano,
        ]);

        $story->update(['status' => ContentStatus::Objavljeno]);

        Notification::assertSentTo($autor, ContentStatusChanged::class);
    }

    public function test_upit_biznisu_se_salje(): void
    {
        $business = Business::create([
            'naslov' => 'Test Biznis',
            'slug' => 'test-biznis',
            'status' => ContentStatus::Objavljeno,
            'published_at' => now(),
        ]);

        $this->post("/domace-je-najbolje/{$business->slug}/upit", [
            'ime' => 'Marko',
            'email' => 'marko@primjer.ba',
            'poruka' => 'Zanima me ponuda.',
        ])->assertRedirect();
    }

    public function test_kontakt_forma_prima_poruku(): void
    {
        $this->post('/kontakt', [
            'ime' => 'Marko',
            'email' => 'marko@primjer.ba',
            'poruka' => 'Pozdrav!',
        ])->assertRedirect();
    }

    public function test_autor_ne_moze_urediti_tudju_pricu(): void
    {
        $drugi = $this->user('autor');
        $tudja = Story::create([
            'user_id' => $drugi->id,
            'naslov' => 'Tuđa priča',
            'status' => ContentStatus::Nacrt,
        ]);

        $autor = User::create([
            'name' => 'Drugi Autor',
            'email' => 'autor2@komteldoo.com',
            'password' => 'mario123',
            'role' => 'autor',
            'status' => 'aktivan',
        ]);

        $this->actingAs($autor)
            ->get("/nalog/autor/price/{$tudja->id}/uredi")
            ->assertForbidden();
    }
}
