<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Settings\SiteSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class SettingsAdminTest extends TestCase
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

    protected function payload(array $override = []): array
    {
        return array_merge([
            'brand_naziv' => ['sr' => 'TO Teslić', 'en' => 'TO Teslic'],
            'brand_logo_tekst' => ['sr' => 'TO Teslić'],
            'kontakt_adresa' => 'Svetog Save 15',
            'kontakt_telefon' => '+387 53 411 500',
            'kontakt_email' => 'info@teslic.travel',
            'footer_opis' => ['sr' => 'Opis'],
            'copyright' => ['sr' => '© 2026'],
            'partneri_tekst' => ['sr' => 'Finansira X'],
            'logo_visina' => 40,
            'seo_opis' => ['sr' => 'Meta opis sajta'],
            'social' => [
                ['name' => 'facebook', 'label' => 'Facebook', 'href' => 'https://facebook.com'],
                ['name' => 'instagram', 'label' => 'Instagram', 'href' => 'https://instagram.com'],
            ],
            'partneri' => ['Partner 1', 'Partner 2'],
            'google_indeksiranje' => true,
            'odrzavanje' => false,
            'odrzavanje_lozinka' => '',
            'odrzavanje_minuta' => 120,
            'odrzavanje_poruka' => '',
        ], $override);
    }

    public function test_settings_screen_renders(): void
    {
        $this->actingAs($this->admin(), 'admin')
            ->get('/administracija/postavke')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->component('Postavke')
                ->has('postavke.social')
                ->has('postavke.brand_naziv'));
    }

    public function test_update_saves_settings_with_social_and_partneri(): void
    {
        $this->actingAs($this->admin(), 'admin')
            ->put('/administracija/postavke', $this->payload())
            ->assertRedirect()
            ->assertSessionHas('status');

        app()->forgetInstance(SiteSettings::class);
        $s = app(SiteSettings::class);

        $this->assertEquals(['sr' => 'TO Teslić', 'en' => 'TO Teslic'], $s->brand_naziv);
        $this->assertEquals(['sr' => 'Finansira X'], $s->partneri_tekst);
        $this->assertCount(2, $s->social);
        $this->assertSame('facebook', $s->social[0]['name']);
    }

    public function test_social_order_is_preserved(): void
    {
        $this->actingAs($this->admin(), 'admin')
            ->put('/administracija/postavke', $this->payload([
                'social' => [
                    ['name' => 'youtube', 'label' => 'YouTube', 'href' => 'https://youtube.com'],
                    ['name' => 'facebook', 'label' => 'Facebook', 'href' => 'https://facebook.com'],
                ],
            ]))
            ->assertRedirect();

        app()->forgetInstance(SiteSettings::class);
        $s = app(SiteSettings::class);

        $this->assertSame('youtube', $s->social[0]['name']);
        $this->assertSame('facebook', $s->social[1]['name']);
    }

    public function test_can_upload_and_remove_logo(): void
    {
        Storage::fake('public');
        $admin = $this->admin();

        $this->actingAs($admin, 'admin')
            ->post('/administracija/postavke/logo', [
                'image' => UploadedFile::fake()->image('logo.png', 400, 120),
            ])
            ->assertRedirect();

        app()->forgetInstance(SiteSettings::class);
        $this->assertNotEmpty(app(SiteSettings::class)->brand_logo);

        $this->actingAs($admin, 'admin')
            ->delete('/administracija/postavke/logo')
            ->assertRedirect();

        app()->forgetInstance(SiteSettings::class);
        $this->assertEmpty(app(SiteSettings::class)->brand_logo);
    }

    public function test_logo_rejects_non_image(): void
    {
        $this->actingAs($this->admin(), 'admin')
            ->post('/administracija/postavke/logo', [
                'image' => UploadedFile::fake()->create('dok.pdf', 100, 'application/pdf'),
            ])
            ->assertSessionHasErrors('image');
    }

    public function test_update_validates_email_and_social_url(): void
    {
        $this->actingAs($this->admin(), 'admin')
            ->put('/administracija/postavke', $this->payload([
                'kontakt_email' => 'nije-email',
                'social' => [['name' => 'facebook', 'label' => 'FB', 'href' => 'nije-url']],
            ]))
            ->assertSessionHasErrors(['kontakt_email', 'social.0.href']);
    }
}
