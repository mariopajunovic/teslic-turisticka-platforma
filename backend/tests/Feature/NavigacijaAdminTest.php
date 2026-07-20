<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class NavigacijaAdminTest extends TestCase
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

    protected function meni(): Menu
    {
        return Menu::create(['key' => 'main', 'name' => 'Glavna navigacija']);
    }

    protected function stranica(string $slug, string $naslov, ?int $parentId = null): Page
    {
        $p = new Page();
        $p->setTranslations('title', ['sr' => $naslov]);
        $p->slug = ['sr' => $slug];
        $p->parent_id = $parentId;
        $p->published = true;
        $p->save();

        return $p;
    }

    public function test_list_renders(): void
    {
        $meni = $this->meni();
        $this->stranica('o-projektu', 'O projektu');

        $this->actingAs($this->admin(), 'admin')
            ->get('/administracija/navigacija')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->component('Navigacija/Lista')
                ->has('meniji', 1)
                ->where('aktivan.key', 'main')
                ->has('ciljevi.stranice'));
    }

    public function test_can_add_item_bound_to_page(): void
    {
        $meni = $this->meni();
        $stranica = $this->stranica('o-projektu', 'O projektu');

        $this->actingAs($this->admin(), 'admin')
            ->post("/administracija/navigacija/{$meni->id}/stavke", [
                'label' => ['sr' => 'O nama'],
                'target_type' => 'page',
                'target_id' => $stranica->id,
            ])
            ->assertRedirect();

        $stavka = MenuItem::first();
        $this->assertSame('page', $stavka->target_type);
        $this->assertSame('/o-projektu', $stavka->razrijeseniUrl());
        $this->assertFalse($stavka->mrtav());
    }

    public function test_link_follows_slug_change(): void
    {
        $meni = $this->meni();
        $stranica = $this->stranica('o-projektu', 'O projektu');

        $this->actingAs($this->admin(), 'admin')
            ->post("/administracija/navigacija/{$meni->id}/stavke", [
                'label' => ['sr' => 'O nama'],
                'target_type' => 'page',
                'target_id' => $stranica->id,
            ]);

        $stranica->slug = ['sr' => 'o-nama-novo'];
        $stranica->save();

        $this->assertSame('/o-nama-novo', MenuItem::first()->razrijeseniUrl());
    }

    public function test_category_item_resolves_to_child_page(): void
    {
        $meni = $this->meni();

        $kategorija = Category::create([
            'key' => 'hrana',
            'label' => 'Hrana',
            'type' => 'domace',
        ]);

        $roditelj = $this->stranica('domace-je-najbolje', 'Domaće je najbolje');
        $dijete = $this->stranica('hrana', 'Hrana', $roditelj->id);
        $dijete->category_id = $kategorija->id;
        $dijete->save();

        $this->actingAs($this->admin(), 'admin')
            ->post("/administracija/navigacija/{$meni->id}/stavke", [
                'label' => ['sr' => 'Hrana'],
                'target_type' => 'category',
                'target_id' => $kategorija->id,
            ]);

        $this->assertSame('/domace-je-najbolje/hrana', MenuItem::first()->razrijeseniUrl());
    }

    public function test_unpublished_page_marks_item_dead(): void
    {
        $meni = $this->meni();
        $stranica = $this->stranica('o-projektu', 'O projektu');

        $this->actingAs($this->admin(), 'admin')
            ->post("/administracija/navigacija/{$meni->id}/stavke", [
                'label' => ['sr' => 'O nama'],
                'target_type' => 'page',
                'target_id' => $stranica->id,
            ]);

        $stranica->published = false;
        $stranica->save();

        $this->assertTrue(MenuItem::first()->mrtav());
    }

    public function test_external_item_keeps_url(): void
    {
        $meni = $this->meni();

        $this->actingAs($this->admin(), 'admin')
            ->post("/administracija/navigacija/{$meni->id}/stavke", [
                'label' => ['sr' => 'Facebook'],
                'target_type' => 'external',
                'url' => 'https://facebook.com/teslic',
            ])
            ->assertRedirect();

        $this->assertSame('https://facebook.com/teslic', MenuItem::first()->razrijeseniUrl());
    }

    public function test_reorder_and_nesting(): void
    {
        $meni = $this->meni();
        $a = $this->stranica('a', 'A');
        $b = $this->stranica('b', 'B');
        $admin = $this->admin();

        foreach ([[$a, 'Prva'], [$b, 'Druga']] as [$str, $lab]) {
            $this->actingAs($admin, 'admin')->post("/administracija/navigacija/{$meni->id}/stavke", [
                'label' => ['sr' => $lab],
                'target_type' => 'page',
                'target_id' => $str->id,
            ]);
        }

        $stavke = MenuItem::orderBy('id')->get();

        $this->actingAs($admin, 'admin')->post("/administracija/navigacija/{$meni->id}/redoslijed", [
            'stavke' => [
                ['id' => $stavke[1]->id, 'parent_id' => null],
                ['id' => $stavke[0]->id, 'parent_id' => $stavke[1]->id],
            ],
        ])->assertRedirect();

        $this->assertSame(0, $stavke[1]->fresh()->sort);
        $this->assertSame($stavke[1]->id, $stavke[0]->fresh()->parent_id);
    }

    public function test_toggle_visibility_and_delete(): void
    {
        $meni = $this->meni();
        $stranica = $this->stranica('o-projektu', 'O projektu');
        $admin = $this->admin();

        $this->actingAs($admin, 'admin')->post("/administracija/navigacija/{$meni->id}/stavke", [
            'label' => ['sr' => 'O nama'],
            'target_type' => 'page',
            'target_id' => $stranica->id,
        ]);

        $stavka = MenuItem::first();

        $this->actingAs($admin, 'admin')->post("/administracija/navigacija/stavke/{$stavka->id}/vidljivost")->assertRedirect();
        $this->assertFalse($stavka->fresh()->visible);

        $this->actingAs($admin, 'admin')->delete("/administracija/navigacija/stavke/{$stavka->id}")->assertRedirect();
        $this->assertDatabaseMissing('menu_items', ['id' => $stavka->id]);
    }
}
