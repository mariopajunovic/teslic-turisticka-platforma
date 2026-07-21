<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class PagesAdminTest extends TestCase
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

    protected function stranica(array $attr = []): Page
    {
        $page = new Page();
        $page->setTranslations('title', ['sr' => $attr['title'] ?? 'Test stranica']);
        $slug = $attr['slug'] ?? 'test-'.uniqid();
        $page->slug = is_array($slug) ? $slug : ['sr' => $slug];
        $page->published = $attr['published'] ?? true;
        $page->is_system = $attr['is_system'] ?? false;
        $page->content = $attr['content'] ?? [];
        $page->setTranslations('meta_title', []);
        $page->setTranslations('meta_description', []);
        $page->save();

        return $page;
    }

    public function test_pages_list_renders(): void
    {
        $this->stranica(['title' => 'O projektu', 'slug' => 'o-projektu']);

        $this->actingAs($this->admin(), 'admin')
            ->get('/administracija/stranice')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->component('Stranice/Lista')
                ->has('stranice', 1)
                ->where('stranice.0.title', 'O projektu'));
    }

    public function test_can_create_page_with_translatable_title(): void
    {
        $this->actingAs($this->admin(), 'admin')
            ->post('/administracija/stranice', [
                'title' => ['sr' => 'Nova strana', 'en' => 'New page'],
                'slug' => 'nova-strana',
                'published' => true,
            ])
            ->assertRedirect();

        $page = Page::where('slug->sr', 'nova-strana')->first();
        $this->assertNotNull($page);
        $this->assertEquals(['sr' => 'Nova strana', 'en' => 'New page'], $page->getTranslations('title'));
        $this->assertTrue($page->published);
    }

    public function test_create_generates_slug_from_title_when_empty(): void
    {
        $this->actingAs($this->admin(), 'admin')
            ->post('/administracija/stranice', [
                'title' => ['sr' => 'Neka Nova Stranica'],
                'published' => false,
            ])
            ->assertRedirect();

        $this->assertTrue(Page::where('slug->sr', 'neka-nova-stranica')->exists());
    }

    public function test_update_saves_title_slug_and_seo(): void
    {
        $page = $this->stranica(['slug' => 'stara']);

        $this->actingAs($this->admin(), 'admin')
            ->put("/administracija/stranice/{$page->id}", [
                'title' => ['sr' => 'Izmijenjen naslov'],
                'slug' => 'novi-slug',
                'published' => false,
                'meta_title' => ['sr' => 'Meta', 'en' => 'Meta EN'],
                'meta_description' => ['sr' => 'Opis'],
            ])
            ->assertRedirect();

        $fresh = $page->fresh();
        $this->assertSame('Izmijenjen naslov', $fresh->getTranslations('title')['sr']);
        $this->assertSame('novi-slug', $fresh->slugFor('sr'));
        $this->assertFalse($fresh->published);
        $this->assertEquals(['sr' => 'Meta', 'en' => 'Meta EN'], $fresh->getTranslations('meta_title'));
    }

    public function test_system_page_slug_locked_and_cannot_delete(): void
    {
        $admin = $this->admin();
        $page = $this->stranica(['slug' => 'pocetna', 'is_system' => true]);

        $this->actingAs($admin, 'admin')
            ->put("/administracija/stranice/{$page->id}", [
                'title' => ['sr' => 'Početna'],
                'slug' => 'promijenjeno',
                'published' => true,
            ])
            ->assertRedirect();
        $this->assertSame('pocetna', $page->fresh()->slugFor('sr'));

        $this->actingAs($admin, 'admin')
            ->delete("/administracija/stranice/{$page->id}")
            ->assertSessionHas('error');
        $this->assertDatabaseHas('pages', ['id' => $page->id]);
    }

    public function test_non_home_system_page_slug_is_editable(): void
    {
        $page = $this->stranica(['slug' => 'pridruzi-se', 'is_system' => true]);

        $this->actingAs($this->admin(), 'admin')
            ->put("/administracija/stranice/{$page->id}", [
                'title' => ['sr' => 'Pridruži se'],
                'slug' => 'join-us',
                'published' => true,
            ])
            ->assertRedirect();

        $this->assertSame('join-us', $page->fresh()->slugFor('sr'));
    }

    public function test_default_meta_title_appends_site_name(): void
    {
        $settings = app(\App\Settings\SiteSettings::class);
        $settings->brand_naziv = ['sr' => 'TO Teslić'];
        $settings->save();

        $this->stranica(['slug' => 'meta-default', 'title' => 'Kontakt']);

        $this->get('/meta-default')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p->where('seo.title', 'Kontakt'));
    }

    public function test_custom_meta_title_gets_site_name_appended(): void
    {
        $settings = app(\App\Settings\SiteSettings::class);
        $settings->brand_naziv = ['sr' => 'TO Teslić'];
        $settings->save();

        $page = $this->stranica(['slug' => 'meta-custom', 'title' => 'Kontakt']);
        $page->setTranslations('meta_title', ['sr' => 'Pocetna']);
        $page->save();

        $this->get('/meta-custom')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p->where('seo.title', 'Pocetna'));
    }

    public function test_meta_title_not_doubled_when_site_name_present(): void
    {
        $settings = app(\App\Settings\SiteSettings::class);
        $settings->brand_naziv = ['sr' => 'TO Teslić'];
        $settings->save();

        $page = $this->stranica(['slug' => 'meta-nodouble', 'title' => 'X']);
        $page->setTranslations('meta_title', ['sr' => 'Kontakt - TO Teslić']);
        $page->save();

        $this->get('/meta-nodouble')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p->where('seo.title', 'Kontakt - TO Teslić'));
    }

    public function test_seo_uses_dedicated_share_image(): void
    {
        $page = $this->stranica([
            'slug' => 'og-namjenska',
            'content' => [['type' => 'hero', 'data' => ['title' => ['sr' => 'X'], 'image' => 'https://cdn.test/hero.jpg']]],
        ]);
        $page->og_image = 'https://cdn.test/share.jpg';
        $page->save();

        $this->get('/og-namjenska')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p->where('seo.image', 'https://cdn.test/share.jpg'));
    }

    public function test_seo_falls_back_to_hero_image(): void
    {
        $this->stranica([
            'slug' => 'og-fallback',
            'content' => [['type' => 'hero', 'data' => ['title' => ['sr' => 'X'], 'image' => 'https://cdn.test/hero.jpg']]],
        ]);

        $this->get('/og-fallback')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p->where('seo.image', 'https://cdn.test/hero.jpg'));
    }

    public function test_seo_absolutizes_relative_share_image(): void
    {
        $page = $this->stranica(['slug' => 'og-relativna', 'content' => []]);
        $page->og_image = '/storage/stranice/share.jpg';
        $page->save();

        $this->get('/og-relativna')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p->where('seo.image', url('/storage/stranice/share.jpg')));
    }

    public function test_update_saves_og_image(): void
    {
        $page = $this->stranica(['slug' => 'og-save']);

        $this->actingAs($this->admin(), 'admin')
            ->put("/administracija/stranice/{$page->id}", [
                'title' => ['sr' => 'Naslov'],
                'slug' => 'og-save',
                'published' => true,
                'og_image' => 'https://cdn.test/nova.jpg',
            ])
            ->assertRedirect();

        $this->assertSame('https://cdn.test/nova.jpg', $page->fresh()->og_image);
    }

    public function test_builder_renders_with_schema_and_catalog(): void
    {
        $page = $this->stranica([
            'slug' => 'builder-test',
            'content' => [
                ['type' => 'hero', 'data' => ['title' => ['sr' => 'Naslov'], 'variant' => 'split']],
            ],
        ]);

        $this->actingAs($this->admin(), 'admin')
            ->get("/administracija/stranice/{$page->id}/uredi")
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->component('Stranice/Builder')
                ->where('stranica.slug.sr', 'builder-test')
                ->has('stranica.blocks', 1)
                ->where('stranica.blocks.0.data.title.sr', 'Naslov')
                ->has('schema.hero')
                ->has('katalog')
                ->has('defaults.hero'));
    }

    public function test_update_content_saves_blocks(): void
    {
        $page = $this->stranica(['slug' => 'sadrzaj-test']);

        $blocks = [
            ['type' => 'hero', 'data' => ['title' => ['sr' => 'A', 'en' => 'B'], 'settings' => ['hidden' => false]]],
            ['type' => 'rich_text', 'data' => ['sadrzaj' => ['sr' => '<p>tekst</p>']]],
        ];

        $this->actingAs($this->admin(), 'admin')
            ->put("/administracija/stranice/{$page->id}/sadrzaj", ['blocks' => $blocks])
            ->assertRedirect();

        $fresh = $page->fresh();
        $this->assertCount(2, $fresh->content);
        $this->assertSame('hero', $fresh->content[0]['type']);
        $this->assertEqualsCanonicalizing(['sr' => 'A', 'en' => 'B'], $fresh->content[0]['data']['title']);
    }

    public function test_admin_preview_renders_draft_blocks(): void
    {
        $admin = $this->admin();
        $page = $this->stranica([
            'slug' => 'draft-preview',
            'content' => [['type' => 'hero', 'data' => ['title' => ['sr' => 'Sačuvano']]]],
        ]);

        $this->actingAs($admin, 'admin')
            ->post("/administracija/stranice/{$page->id}/pregled-draft", [
                'blocks' => [['type' => 'hero', 'data' => ['title' => ['sr' => 'Draft verzija']]]],
            ])
            ->assertNoContent();

        $this->actingAs($admin, 'admin')
            ->get('/draft-preview?preview=1')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->component('PageRenderer')
                ->where('blocks.0.data.title', 'Draft verzija'));
    }

    public function test_draft_ignored_without_preview_flag(): void
    {
        $admin = $this->admin();
        $page = $this->stranica([
            'slug' => 'javni-test',
            'content' => [['type' => 'hero', 'data' => ['title' => ['sr' => 'Sačuvano']]]],
        ]);

        $this->actingAs($admin, 'admin')
            ->post("/administracija/stranice/{$page->id}/pregled-draft", [
                'blocks' => [['type' => 'hero', 'data' => ['title' => ['sr' => 'Draft verzija']]]],
            ]);

        $this->actingAs($admin, 'admin')
            ->get('/javni-test')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->where('blocks.0.data.title', 'Sačuvano'));
    }

    public function test_update_content_drops_unknown_block_types(): void
    {
        $page = $this->stranica(['slug' => 'filter-test']);

        $this->actingAs($this->admin(), 'admin')
            ->put("/administracija/stranice/{$page->id}/sadrzaj", ['blocks' => [
                ['type' => 'hero', 'data' => ['title' => ['sr' => 'ok']]],
                ['type' => 'nepostojeci', 'data' => []],
                ['nema' => 'type'],
            ]])
            ->assertRedirect();

        $content = $page->fresh()->content;
        $this->assertCount(1, $content);
        $this->assertSame('hero', $content[0]['type']);
    }

    public function test_can_delete_non_system_page(): void
    {
        $page = $this->stranica();

        $this->actingAs($this->admin(), 'admin')
            ->delete("/administracija/stranice/{$page->id}")
            ->assertRedirect();

        $this->assertDatabaseMissing('pages', ['id' => $page->id]);
    }
}
