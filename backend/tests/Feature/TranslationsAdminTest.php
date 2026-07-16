<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Locale;
use App\Models\Translation;
use App\Support\Translations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class TranslationsAdminTest extends TestCase
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

    protected function seedLocales(): void
    {
        Locale::create(['code' => 'sr', 'name' => 'Srpski', 'is_system' => true, 'is_active' => true, 'sort_order' => 0]);
        Locale::create(['code' => 'en', 'name' => 'Engleski', 'is_system' => true, 'is_active' => true, 'sort_order' => 1]);
        Locale::create(['code' => 'de', 'name' => 'Njemački', 'is_system' => true, 'is_active' => true, 'sort_order' => 2]);
    }

    public function test_translations_screen_renders_with_dynamic_columns(): void
    {
        $this->seedLocales();
        Translation::create(['group' => 'action', 'key' => 'action.login', 'values' => ['sr' => 'Prijava', 'en' => 'Login', 'de' => 'Anmelden']]);
        Translation::create(['group' => 'action', 'key' => 'action.logout', 'values' => ['sr' => 'Odjava', 'en' => '', 'de' => '']]);

        $this->actingAs($this->admin(), 'admin')
            ->get('/administracija/prevodi')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->component('Translations')
                ->where('columns', fn ($c) => count($c) === 3)
                ->where('missingCount', 1)
                ->has('translations', 2));
    }

    public function test_target_language_selector_shapes_rows_and_missing_counts(): void
    {
        $this->seedLocales();
        $admin = $this->admin();
        Translation::create(['group' => 'action', 'key' => 'action.login', 'values' => ['sr' => 'Prijava', 'en' => 'Login', 'de' => '']]);
        Translation::create(['group' => 'action', 'key' => 'action.logout', 'values' => ['sr' => 'Odjava', 'en' => '', 'de' => '']]);

        $this->actingAs($admin, 'admin')
            ->get('/administracija/prevodi')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->component('Translations')
                ->where('target', 'en')
                ->where('missingByLang.en', 1)
                ->where('missingByLang.de', 2)
                ->where('missingByLang.sr', 0)
                ->where('missingCount', 1)
                ->where('translations.0.source', 'Prijava')
                ->where('translations.0.value', 'Login'));

        $this->actingAs($admin, 'admin')
            ->get('/administracija/prevodi?lang=de')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->where('target', 'de')
                ->where('missingCount', 2)
                ->where('translations.0.value', ''));
    }

    public function test_update_saves_only_target_language(): void
    {
        $this->seedLocales();
        $t = Translation::create(['group' => 'action', 'key' => 'action.login', 'values' => ['sr' => 'Prijava', 'en' => 'Login', 'de' => '']]);

        $this->actingAs($this->admin(), 'admin')
            ->put("/administracija/prevodi/{$t->id}", ['values' => ['de' => 'Anmelden']])
            ->assertRedirect();

        $fresh = Translation::find($t->id);
        $this->assertSame('Anmelden', $fresh->values['de']);
        $this->assertSame('Prijava', $fresh->values['sr']);
        $this->assertSame('Login', $fresh->values['en']);
    }

    public function test_missing_filter_narrows_rows(): void
    {
        $this->seedLocales();
        Translation::create(['group' => 'action', 'key' => 'action.login', 'values' => ['sr' => 'Prijava', 'en' => 'Login', 'de' => 'Anmelden']]);
        Translation::create(['group' => 'action', 'key' => 'action.logout', 'values' => ['sr' => 'Odjava', 'en' => '', 'de' => '']]);

        $this->actingAs($this->admin(), 'admin')
            ->get('/administracija/prevodi?missing=1')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p->has('translations', 1));
    }

    public function test_translation_update_persists_and_clears_cache(): void
    {
        $this->seedLocales();
        $t = Translation::create(['group' => 'action', 'key' => 'action.login', 'values' => ['sr' => 'Prijava', 'en' => 'Login', 'de' => 'Anmelden']]);

        app(Translations::class)->messages('en');

        $this->actingAs($this->admin(), 'admin')
            ->put("/administracija/prevodi/{$t->id}", ['values' => ['sr' => 'Prijava', 'en' => 'Sign in', 'de' => 'Anmelden']])
            ->assertRedirect();

        $this->assertSame('Sign in', Translation::find($t->id)->values['en']);
        $this->assertSame('Sign in', app(Translations::class)->messages('en')['action']['login']);
    }

    public function test_new_language_falls_back_to_serbian_latin(): void
    {
        $this->seedLocales();
        Locale::create(['code' => 'it', 'name' => 'Italijanski', 'is_system' => false, 'is_active' => true, 'sort_order' => 5]);
        Translation::create(['group' => 'action', 'key' => 'action.login', 'values' => ['sr' => 'Prijava', 'en' => 'Login', 'de' => 'Anmelden']]);

        $this->assertSame('Prijava', app(Translations::class)->messages('it')['action']['login']);
    }

    public function test_languages_screen_renders(): void
    {
        $this->seedLocales();

        $this->actingAs($this->admin(), 'admin')
            ->get('/administracija/jezici')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->component('Languages')
                ->has('languages', 3));
    }

    public function test_can_add_language(): void
    {
        $this->seedLocales();

        $this->actingAs($this->admin(), 'admin')
            ->post('/administracija/jezici', ['code' => 'it', 'name' => 'Italijanski'])
            ->assertRedirect();

        $this->assertDatabaseHas('locales', ['code' => 'it', 'name' => 'Italijanski', 'is_system' => false, 'is_active' => true]);
    }

    public function test_add_language_validates_code(): void
    {
        $this->seedLocales();
        $admin = $this->admin();

        $this->actingAs($admin, 'admin')
            ->post('/administracija/jezici', ['code' => 'EN123', 'name' => 'X'])
            ->assertSessionHasErrors('code');

        $this->actingAs($admin, 'admin')
            ->post('/administracija/jezici', ['code' => 'en', 'name' => 'Dup'])
            ->assertSessionHasErrors('code');
    }

    public function test_system_language_cannot_be_deleted_or_edited(): void
    {
        $this->seedLocales();
        $admin = $this->admin();
        $sr = Locale::where('code', 'sr')->first();

        $this->actingAs($admin, 'admin')
            ->delete("/administracija/jezici/{$sr->id}")
            ->assertSessionHas('error');
        $this->assertDatabaseHas('locales', ['code' => 'sr']);

        $this->actingAs($admin, 'admin')
            ->put("/administracija/jezici/{$sr->id}", ['name' => 'Hacked', 'is_active' => false])
            ->assertSessionHas('error');
        $this->assertSame('Srpski', $sr->fresh()->name);
    }

    public function test_custom_language_can_be_edited_and_deleted(): void
    {
        $this->seedLocales();
        $admin = $this->admin();
        $it = Locale::create(['code' => 'it', 'name' => 'Italijanski', 'is_system' => false, 'is_active' => true, 'sort_order' => 5]);

        $this->actingAs($admin, 'admin')
            ->put("/administracija/jezici/{$it->id}", ['name' => 'Italiano', 'is_active' => false])
            ->assertRedirect();
        $this->assertDatabaseHas('locales', ['code' => 'it', 'name' => 'Italiano', 'is_active' => false]);

        $this->actingAs($admin, 'admin')
            ->delete("/administracija/jezici/{$it->id}")
            ->assertRedirect();
        $this->assertDatabaseMissing('locales', ['code' => 'it']);
    }
}
