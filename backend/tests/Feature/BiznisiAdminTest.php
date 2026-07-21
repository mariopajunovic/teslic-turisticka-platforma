<?php

namespace Tests\Feature;

use App\Enums\ContentStatus;
use App\Models\Admin;
use App\Models\Business;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class BiznisiAdminTest extends TestCase
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

    protected function kategorija(): Category
    {
        return Category::create([
            'key' => 'hrana-'.uniqid(),
            'label' => 'Domaća hrana',
            'type' => 'domace',
            'color' => '#0E8275',
        ]);
    }

    protected function biznis(array $attr = []): Business
    {
        $b = new Business();
        $b->setTranslations('naslov', ['sr' => $attr['naslov'] ?? 'Test biznis '.uniqid()]);
        $b->status = $attr['status'] ?? ContentStatus::Nacrt;
        $b->category_id = $attr['category_id'] ?? null;
        $b->save();

        return $b;
    }

    public function test_list_renders(): void
    {
        $this->biznis(['naslov' => 'Pekara Klas']);

        $this->actingAs($this->admin(), 'admin')
            ->get('/administracija/biznisi')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->component('Biznisi/Lista')
                ->has('biznisi.data', 1)
                ->where('biznisi.data.0.naslov', 'Pekara Klas'));
    }

    public function test_list_filters_by_status(): void
    {
        $this->biznis(['naslov' => 'Objavljeni', 'status' => ContentStatus::Objavljeno]);
        $this->biznis(['naslov' => 'Nacrt', 'status' => ContentStatus::Nacrt]);

        $this->actingAs($this->admin(), 'admin')
            ->get('/administracija/biznisi?tab=objavljeni')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->has('biznisi.data', 1)
                ->where('biznisi.data.0.naslov', 'Objavljeni'));
    }

    public function test_can_create_with_translatable_title(): void
    {
        $kat = $this->kategorija();

        $this->actingAs($this->admin(), 'admin')
            ->post('/administracija/biznisi', [
                'naslov' => ['sr' => 'Novi biznis', 'en' => 'New business'],
                'opis' => ['sr' => 'Kratki opis'],
                'category_id' => $kat->id,
                'kontakt' => ['telefon' => '065', 'email' => '', 'adresa' => '', 'web' => ''],
                'preporuceno' => true,
                'status' => 'nacrt',
                'tags' => ['domace', 'hrana'],
            ])
            ->assertRedirect();

        $b = Business::first();
        $this->assertNotNull($b);
        $this->assertEquals(['sr' => 'Novi biznis', 'en' => 'New business'], $b->getTranslations('naslov'));
        $this->assertSame($kat->id, $b->category_id);
        $this->assertTrue($b->preporuceno);
        $this->assertCount(2, $b->tags);
        $this->assertNotEmpty($b->slug);
    }

    public function test_update_saves_fields(): void
    {
        $b = $this->biznis();

        $this->actingAs($this->admin(), 'admin')
            ->put("/administracija/biznisi/{$b->id}", [
                'naslov' => ['sr' => 'Izmijenjen naslov'],
                'lokacija' => ['sr' => 'Teslić'],
                'kontakt' => ['telefon' => '051', 'email' => 'a@b.c', 'adresa' => '', 'web' => ''],
                'lat' => 44.6,
                'lng' => 17.86,
                'status' => 'objavljeno',
                'preporuceno' => false,
            ])
            ->assertRedirect();

        $fresh = $b->fresh();
        $this->assertSame('Izmijenjen naslov', $fresh->getTranslations('naslov')['sr']);
        $this->assertSame(ContentStatus::Objavljeno, $fresh->status);
        $this->assertNotNull($fresh->published_at);
        $this->assertSame('+38751', $fresh->kontakt['telefon']);
    }

    public function test_update_saves_translatable_slug(): void
    {
        $b = $this->biznis(['naslov' => 'Pčelarstvo Borja']);

        $this->actingAs($this->admin(), 'admin')
            ->put("/administracija/biznisi/{$b->id}", [
                'naslov' => ['sr' => 'Pčelarstvo Borja', 'en' => 'Beekeeping Borja'],
                'slug' => ['sr' => 'pcelarska-oprema-teslic', 'en' => 'beekeeping-supplies'],
                'status' => 'nacrt',
            ])
            ->assertRedirect();

        $fresh = $b->fresh();
        $this->assertSame('pcelarska-oprema-teslic', $fresh->slugFor('sr'));
        $this->assertSame('beekeeping-supplies', $fresh->slugFor('en'));
    }

    public function test_slug_is_unique_per_language(): void
    {
        $admin = $this->admin();

        $a = $this->biznis(['naslov' => 'Prvi']);
        $this->actingAs($admin, 'admin')->put("/administracija/biznisi/{$a->id}", [
            'naslov' => ['sr' => 'Prvi'],
            'slug' => ['en' => 'zauzet'],
            'status' => 'nacrt',
        ]);

        $b = $this->biznis(['naslov' => 'Drugi']);
        $this->actingAs($admin, 'admin')->put("/administracija/biznisi/{$b->id}", [
            'naslov' => ['sr' => 'Drugi'],
            'slug' => ['en' => 'zauzet'],
            'status' => 'nacrt',
        ]);

        $this->assertSame('zauzet', $a->fresh()->slugFor('en'));
        $this->assertSame('zauzet-2', $b->fresh()->slugFor('en'));
    }

    public function test_public_resolves_business_by_language_slug(): void
    {
        $admin = $this->admin();
        $kat = $this->kategorija();
        $b = $this->biznis(['naslov' => 'Pčelarstvo', 'category_id' => $kat->id]);

        $this->actingAs($admin, 'admin')->put("/administracija/biznisi/{$b->id}", [
            'naslov' => ['sr' => 'Pčelarstvo', 'en' => 'Beekeeping'],
            'slug' => ['sr' => 'pcelarstvo', 'en' => 'beekeeping'],
            'status' => 'objavljeno',
        ]);

        $this->get('/biznis/pcelarstvo')->assertOk();
        $this->get('/en/business/beekeeping')->assertOk();
    }

    public function test_language_switcher_uses_localized_slug(): void
    {
        $admin = $this->admin();
        $kat = $this->kategorija();
        $b = $this->biznis(['naslov' => 'Pčelarstvo', 'category_id' => $kat->id]);

        $this->actingAs($admin, 'admin')->put("/administracija/biznisi/{$b->id}", [
            'naslov' => ['sr' => 'Pčelarstvo', 'en' => 'Beekeeping'],
            'slug' => ['sr' => 'pcelarstvo', 'en' => 'beekeeping'],
            'status' => 'objavljeno',
        ]);

        $this->get('/biznis/pcelarstvo')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->where('locale.alternates.en', url('/en/business/beekeeping'))
                ->where('locale.alternates.sr', url('/biznis/pcelarstvo')));
    }

    public function test_approve_changes_status(): void
    {
        $b = $this->biznis(['status' => ContentStatus::Poslano]);

        $this->actingAs($this->admin(), 'admin')
            ->post("/administracija/biznisi/{$b->id}/odobri")
            ->assertRedirect();

        $fresh = $b->fresh();
        $this->assertSame(ContentStatus::Objavljeno, $fresh->status);
        $this->assertNotNull($fresh->published_at);
    }

    public function test_reject_changes_status_and_reason(): void
    {
        $b = $this->biznis(['status' => ContentStatus::Poslano]);

        $this->actingAs($this->admin(), 'admin')
            ->post("/administracija/biznisi/{$b->id}/odbij", [
                'rejection_reason' => 'Nedovoljno informacija.',
            ])
            ->assertRedirect();

        $fresh = $b->fresh();
        $this->assertSame(ContentStatus::Odbijeno, $fresh->status);
        $this->assertSame('Nedovoljno informacija.', $fresh->rejection_reason);
    }

    public function test_reject_requires_reason(): void
    {
        $b = $this->biznis(['status' => ContentStatus::Poslano]);

        $this->actingAs($this->admin(), 'admin')
            ->post("/administracija/biznisi/{$b->id}/odbij", [])
            ->assertSessionHasErrors('rejection_reason');
    }

    public function test_can_delete(): void
    {
        $b = $this->biznis();

        $this->actingAs($this->admin(), 'admin')
            ->delete("/administracija/biznisi/{$b->id}")
            ->assertRedirect();

        $this->assertDatabaseMissing('businesses', ['id' => $b->id]);
    }
}
