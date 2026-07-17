<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Partner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PartnersAdminTest extends TestCase
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

    public function test_can_create_update_and_delete_partner(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin, 'admin')
            ->post('/administracija/postavke/partneri', ['naziv' => 'Partner A', 'href' => 'https://partner-a.ba'])
            ->assertRedirect();

        $partner = Partner::first();
        $this->assertSame('Partner A', $partner->naziv);
        $this->assertSame('https://partner-a.ba', $partner->href);

        $this->actingAs($admin, 'admin')
            ->put("/administracija/postavke/partneri/{$partner->id}", ['naziv' => 'Partner B', 'href' => null])
            ->assertRedirect();
        $this->assertSame('Partner B', $partner->fresh()->naziv);
        $this->assertNull($partner->fresh()->href);

        $this->actingAs($admin, 'admin')
            ->delete("/administracija/postavke/partneri/{$partner->id}")
            ->assertRedirect();
        $this->assertDatabaseMissing('partners', ['id' => $partner->id]);
    }

    public function test_partner_validates_url(): void
    {
        $this->actingAs($this->admin(), 'admin')
            ->post('/administracija/postavke/partneri', ['naziv' => 'X', 'href' => 'nije-url'])
            ->assertSessionHasErrors('href');
    }

    public function test_can_upload_and_remove_partner_logo(): void
    {
        Storage::fake('public');
        $admin = $this->admin();
        $partner = Partner::create(['naziv' => 'Partner', 'sort_order' => 0]);

        $this->actingAs($admin, 'admin')
            ->post("/administracija/postavke/partneri/{$partner->id}/logo", [
                'image' => UploadedFile::fake()->image('logo.png', 300, 120),
            ])
            ->assertRedirect();
        $this->assertNotNull($partner->fresh()->getFirstMedia('logo'));

        $this->actingAs($admin, 'admin')
            ->delete("/administracija/postavke/partneri/{$partner->id}/logo")
            ->assertRedirect();
        $this->assertNull($partner->fresh()->getFirstMedia('logo'));
    }

    public function test_reorder_updates_sort_order(): void
    {
        $a = Partner::create(['naziv' => 'A', 'sort_order' => 0]);
        $b = Partner::create(['naziv' => 'B', 'sort_order' => 1]);
        $c = Partner::create(['naziv' => 'C', 'sort_order' => 2]);

        $this->actingAs($this->admin(), 'admin')
            ->post('/administracija/postavke/partneri/redoslijed', ['ids' => [$c->id, $a->id, $b->id]])
            ->assertRedirect();

        $this->assertSame(0, $c->fresh()->sort_order);
        $this->assertSame(1, $a->fresh()->sort_order);
        $this->assertSame(2, $b->fresh()->sort_order);
    }

    public function test_settings_screen_delivers_partners(): void
    {
        Partner::create(['naziv' => 'Partner', 'href' => 'https://x.ba', 'sort_order' => 0]);

        $this->actingAs($this->admin(), 'admin')
            ->get('/administracija/postavke')
            ->assertOk()
            ->assertInertia(fn ($p) => $p
                ->has('partneri', 1)
                ->where('partneri.0.naziv', 'Partner'));
    }
}
