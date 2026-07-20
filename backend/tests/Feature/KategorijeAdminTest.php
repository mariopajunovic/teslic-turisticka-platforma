<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Business;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class KategorijeAdminTest extends TestCase
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

    protected function kategorija(array $attr = []): Category
    {
        $c = new Category();
        $c->key = $attr['key'] ?? 'kat-'.uniqid();
        $c->setTranslations('label', ['sr' => $attr['label'] ?? 'Test kategorija']);
        $c->type = $attr['type'] ?? 'domace';
        $c->color = $attr['color'] ?? '#0E8275';
        $c->icon = $attr['icon'] ?? 'tag';
        $c->sort = $attr['sort'] ?? 0;
        $c->save();

        return $c;
    }

    public function test_list_renders(): void
    {
        $this->kategorija(['label' => 'Hrana i piće', 'type' => 'domace']);

        $this->actingAs($this->admin(), 'admin')
            ->get('/administracija/kategorije')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->component('Kategorije/Lista')
                ->has('kategorije.data', 1)
                ->where('kategorije.data.0.label', 'Hrana i piće'));
    }

    public function test_list_filters_by_type(): void
    {
        $this->kategorija(['label' => 'Domaća', 'type' => 'domace']);
        $this->kategorija(['label' => 'Turistička', 'type' => 'turizam']);

        $this->actingAs($this->admin(), 'admin')
            ->get('/administracija/kategorije?tip=turizam')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->has('kategorije.data', 1)
                ->where('kategorije.data.0.label', 'Turistička'));
    }

    public function test_create_page_renders(): void
    {
        $this->actingAs($this->admin(), 'admin')
            ->get('/administracija/kategorije/nova')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->component('Kategorije/Forma')
                ->where('kategorija', null)
                ->has('tipovi'));
    }

    public function test_edit_page_renders(): void
    {
        $c = $this->kategorija(['label' => 'Hrana', 'type' => 'domace']);

        $this->actingAs($this->admin(), 'admin')
            ->get("/administracija/kategorije/{$c->id}/uredi")
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->component('Kategorije/Forma')
                ->where('kategorija.key', $c->key)
                ->where('kategorija.label.sr', 'Hrana'));
    }

    public function test_can_create_with_translatable_label(): void
    {
        $this->actingAs($this->admin(), 'admin')
            ->post('/administracija/kategorije', [
                'label' => ['sr' => 'Hrana i piće', 'en' => 'Food and drink'],
                'slug' => ['sr' => 'hrana-pice', 'en' => 'food-drink'],
                'opis' => ['sr' => 'Kratki opis'],
                'type' => 'domace',
                'color' => '#0E8275',
                'icon' => 'utensils',
                'visible' => true,
            ])
            ->assertRedirect();

        $c = Category::first();
        $this->assertNotNull($c);
        $this->assertSame('hrana-pice', $c->slugFor('sr'));
        $this->assertSame('food-drink', $c->slugFor('en'));
        $this->assertSame('hrana-pice', $c->key);
        $this->assertEquals(['sr' => 'Hrana i piće', 'en' => 'Food and drink'], $c->getTranslations('label'));
        $this->assertSame('domace', $c->type);
        $this->assertTrue($c->visible);
    }

    public function test_update_saves_translatable_label(): void
    {
        $c = $this->kategorija(['label' => 'Staro ime']);

        $this->actingAs($this->admin(), 'admin')
            ->put("/administracija/kategorije/{$c->id}", [
                'label' => ['sr' => 'Novo ime', 'en' => 'New name'],
                'slug' => ['sr' => 'novo-ime', 'en' => 'new-name'],
                'type' => 'turizam',
                'color' => '#2271B1',
                'icon' => 'mountain',
                'visible' => false,
            ])
            ->assertRedirect();

        $fresh = $c->fresh();
        $this->assertSame('Novo ime', $fresh->getTranslations('label')['sr']);
        $this->assertSame('New name', $fresh->getTranslations('label')['en']);
        $this->assertSame('novo-ime', $fresh->slugFor('sr'));
        $this->assertSame('new-name', $fresh->slugFor('en'));
        $this->assertSame('turizam', $fresh->type);
        $this->assertFalse($fresh->visible);
    }

    public function test_slug_is_unique_per_language(): void
    {
        $admin = $this->admin();

        $a = $this->kategorija(['label' => 'Prva']);
        $this->actingAs($admin, 'admin')->put("/administracija/kategorije/{$a->id}", [
            'label' => ['sr' => 'Prva'],
            'slug' => ['en' => 'zauzet'],
            'type' => 'domace',
        ]);

        $b = $this->kategorija(['label' => 'Druga']);
        $this->actingAs($admin, 'admin')->put("/administracija/kategorije/{$b->id}", [
            'label' => ['sr' => 'Druga'],
            'slug' => ['en' => 'zauzet'],
            'type' => 'domace',
        ]);

        $this->assertSame('zauzet', $a->fresh()->slugFor('en'));
        $this->assertSame('zauzet-2', $b->fresh()->slugFor('en'));
    }

    public function test_category_child_page_resolves_and_filters(): void
    {
        $admin = $this->admin();
        $c = $this->kategorija(['label' => 'Hrana', 'type' => 'domace']);

        $this->actingAs($admin, 'admin')->put("/administracija/kategorije/{$c->id}", [
            'label' => ['sr' => 'Hrana'],
            'slug' => ['sr' => 'hrana-pice'],
            'type' => 'domace',
        ]);

        $kolekcija = new \App\Models\Page();
        $kolekcija->setTranslations('title', ['sr' => 'Domaće je najbolje']);
        $kolekcija->slug = ['sr' => 'domace-je-najbolje'];
        $kolekcija->published = true;
        $kolekcija->resource_type = 'business';
        $kolekcija->content = [['type' => 'resource_list', 'data' => ['perPage' => 12]]];
        $kolekcija->save();

        $dijete = new \App\Models\Page();
        $dijete->setTranslations('title', ['sr' => 'Hrana']);
        $dijete->slug = ['sr' => 'hrana-pice'];
        $dijete->parent_id = $kolekcija->id;
        $dijete->published = true;
        $dijete->resource_type = 'business';
        $dijete->category_id = $c->id;
        $dijete->content = [['type' => 'resource_list', 'data' => ['perPage' => 12]]];
        $dijete->save();

        $this->get('/domace-je-najbolje')->assertOk();
        $this->get('/domace-je-najbolje/hrana-pice')->assertOk();

        $this->assertSame('/domace-je-najbolje/hrana-pice', \App\Support\ResourceUrls::category($c->fresh()));
    }

    public function test_reorder_saves_sort(): void
    {
        $a = $this->kategorija(['label' => 'Prva', 'sort' => 0]);
        $b = $this->kategorija(['label' => 'Druga', 'sort' => 1]);

        $this->actingAs($this->admin(), 'admin')
            ->post('/administracija/kategorije/redoslijed', [
                'redoslijed' => [$b->id, $a->id],
            ])
            ->assertRedirect();

        $this->assertSame(0, $b->fresh()->sort);
        $this->assertSame(1, $a->fresh()->sort);
    }

    public function test_cannot_delete_category_with_items(): void
    {
        $c = $this->kategorija(['type' => 'domace']);
        $b = new Business();
        $b->setTranslations('naslov', ['sr' => 'Biznis']);
        $b->category_id = $c->id;
        $b->save();

        $this->actingAs($this->admin(), 'admin')
            ->delete("/administracija/kategorije/{$c->id}")
            ->assertRedirect();

        $this->assertDatabaseHas('categories', ['id' => $c->id]);
    }

    public function test_can_delete_empty_category(): void
    {
        $c = $this->kategorija();

        $this->actingAs($this->admin(), 'admin')
            ->delete("/administracija/kategorije/{$c->id}")
            ->assertRedirect();

        $this->assertDatabaseMissing('categories', ['id' => $c->id]);
    }
}
