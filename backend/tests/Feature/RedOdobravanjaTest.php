<?php

namespace Tests\Feature;

use App\Enums\ContentStatus;
use App\Models\Admin;
use App\Models\Business;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class RedOdobravanjaTest extends TestCase
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

    protected function biznis(): User
    {
        return User::create([
            'name' => 'Vlasnik',
            'email' => 'vlasnik@komteldoo.com',
            'password' => 'mario123',
            'role' => 'biznis',
            'status' => 'aktivan',
        ]);
    }

    public function test_izmjena_objavljenog_se_pojavljuje_u_redu_odobravanja(): void
    {
        $u = $this->biznis();
        $b = Business::create([
            'user_id' => $u->id,
            'naslov' => ['sr' => 'Stari zanati Borje'],
            'status' => ContentStatus::Objavljeno,
            'published_at' => now(),
            'pending' => ['naslov' => ['sr' => 'Stari zanati Borje - novo']],
        ]);

        $this->actingAs($this->admin(), 'admin')
            ->get('/administracija')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->component('Dashboard')
                ->where('stats.odobravanje', 1)
                ->has('red', 1)
                ->where('red.0.naslov', 'Stari zanati Borje')
                ->where('red.0.oznaka', 'Izmjena')
                ->where('red.0.url', "/administracija/biznisi/{$b->id}/uredi"));
    }

    public function test_nova_objava_i_izmjena_oboje_u_redu(): void
    {
        $u = $this->biznis();

        Business::create([
            'user_id' => $u->id,
            'naslov' => ['sr' => 'Nova objava'],
            'status' => ContentStatus::Poslano,
        ]);

        Business::create([
            'user_id' => $u->id,
            'naslov' => ['sr' => 'Objavljena sa izmjenom'],
            'status' => ContentStatus::Objavljeno,
            'published_at' => now(),
            'pending' => ['naslov' => ['sr' => 'Izmijenjeno']],
        ]);

        $this->actingAs($this->admin(), 'admin')
            ->get('/administracija')
            ->assertOk()
            ->assertInertia(fn (AssertableInertia $p) => $p
                ->where('stats.odobravanje', 2)
                ->has('red', 2));
    }

    public function test_zvono_endpoint_vraca_obavijesti(): void
    {
        $u = $this->biznis();
        Business::create([
            'user_id' => $u->id,
            'naslov' => ['sr' => 'Poslani biznis'],
            'status' => ContentStatus::Poslano,
        ]);

        $this->actingAs($this->admin(), 'admin')
            ->getJson('/administracija/obavijesti')
            ->assertOk()
            ->assertJsonStructure(['stavke', 'broj'])
            ->assertJsonPath('broj', 1)
            ->assertJsonPath('stavke.0.naslov', 'Poslani biznis');
    }
}
