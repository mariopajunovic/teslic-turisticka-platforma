<?php

namespace Tests\Feature;

use App\Enums\ContentStatus;
use App\Models\Admin;
use App\Models\Business;
use App\Models\User;
use App\Notifications\IzmjeneVracene;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class IzmjeneVracanjeTest extends TestCase
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

    protected function saPending(User $u): Business
    {
        return Business::create([
            'user_id' => $u->id,
            'naslov' => ['sr' => 'Stari zanati Borje'],
            'status' => ContentStatus::Objavljeno,
            'published_at' => now(),
            'pending' => ['naslov' => ['sr' => 'Novi naziv']],
        ]);
    }

    public function test_vrati_na_doradu_zadrzi_pending_i_zapise_razlog(): void
    {
        Notification::fake();
        $u = $this->biznis();
        $b = $this->saPending($u);

        $this->actingAs($this->admin(), 'admin')
            ->post("/administracija/biznisi/{$b->id}/vrati-izmjene", ['pending_reason' => 'Dopuni radno vrijeme'])
            ->assertRedirect();

        $b->refresh();
        $this->assertNotNull($b->pending);
        $this->assertSame('Dopuni radno vrijeme', $b->pending_reason);
        $this->assertSame(ContentStatus::Objavljeno, $b->status);

        Notification::assertSentTo($u, IzmjeneVracene::class);
    }

    public function test_vrati_zahtijeva_razlog(): void
    {
        $u = $this->biznis();
        $b = $this->saPending($u);

        $this->actingAs($this->admin(), 'admin')
            ->post("/administracija/biznisi/{$b->id}/vrati-izmjene", ['pending_reason' => ''])
            ->assertSessionHasErrors('pending_reason');

        $this->assertNull($b->fresh()->pending_reason);
    }

    public function test_vracene_izmjene_nisu_u_redu_odobravanja(): void
    {
        $u = $this->biznis();
        $b = $this->saPending($u);
        $b->vratiPending('Ispravi opis');

        $this->actingAs($this->admin(), 'admin')
            ->get('/administracija')
            ->assertInertia(fn ($p) => $p->where('stats.odobravanje', 0)->has('red', 0));
    }

    public function test_admin_lista_prikazuje_pending_stanje(): void
    {
        $u = $this->biznis();
        $naCekanju = $this->saPending($u);
        $vraceno = $this->saPending($u);
        $vraceno->vratiPending('Ispravi');

        $this->actingAs($this->admin(), 'admin')
            ->get('/administracija/biznisi')
            ->assertInertia(fn ($p) => $p
                ->where("biznisi.data.0.pendingStanje", 'vraceno')
                ->where("biznisi.data.1.pendingStanje", 'na_cekanju'));
    }

    public function test_vlasnik_ponovnim_slanjem_cisti_razlog_i_vraca_u_red(): void
    {
        $u = $this->biznis();
        $b = $this->saPending($u);
        $b->vratiPending('Ispravi opis');

        $this->actingAs($u)->post("/nalog/biznis/objave/{$b->id}", [
            'naslov' => 'Ispravljeni naziv',
            'action' => 'posalji',
        ])->assertRedirect();

        $b->refresh();
        $this->assertNull($b->pending_reason);
        $this->assertNotNull($b->pending);
        $this->assertSame('Ispravljeni naziv', $b->pending['naslov']);

        $this->actingAs($this->admin(), 'admin')
            ->get('/administracija')
            ->assertInertia(fn ($p) => $p->where('stats.odobravanje', 1)->has('red', 1));
    }
}
