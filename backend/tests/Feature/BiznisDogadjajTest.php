<?php

namespace Tests\Feature;

use App\Enums\ContentStatus;
use App\Models\Event;
use App\Models\User;
use App\Notifications\OrgSadrzajNaOdobrenju;
use App\Settings\SiteSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class BiznisDogadjajTest extends TestCase
{
    use RefreshDatabase;

    protected function biznis(string $email = 'biznis@komteldoo.com'): User
    {
        return User::create([
            'name' => 'Vlasnik',
            'email' => $email,
            'password' => 'mario123',
            'role' => 'biznis',
            'status' => 'aktivan',
        ]);
    }

    public function test_biznis_kreira_dogadjaj_i_salje_na_odobrenje(): void
    {
        $s = app(SiteSettings::class);
        $s->kontakt_email = 'org@teslic.ba';
        $s->save();
        Notification::fake();

        $u = $this->biznis();

        $this->actingAs($u)->post('/nalog/biznis/dogadjaji', [
            'naslov' => 'Muzika uživo - petak',
            'datum' => '2026-08-01',
            'vrijeme' => '20:00',
            'lokacija' => 'Restoran Borje',
            'action' => 'posalji',
        ])->assertRedirect('/nalog/biznis/dogadjaji');

        $event = Event::first();
        $this->assertNotNull($event);
        $this->assertSame($u->id, $event->user_id);
        $this->assertSame(ContentStatus::Poslano, $event->status);
        $this->assertSame('Muzika uživo - petak', $event->naslov);

        Notification::assertSentOnDemand(OrgSadrzajNaOdobrenju::class);
    }

    public function test_nacrt_dogadjaja_ne_salje_notifikaciju(): void
    {
        Notification::fake();
        $u = $this->biznis();

        $this->actingAs($u)->post('/nalog/biznis/dogadjaji', [
            'naslov' => 'Nacrt',
            'datum' => '2026-08-01',
            'action' => 'nacrt',
        ])->assertRedirect();

        $this->assertSame(ContentStatus::Nacrt, Event::first()->status);
        Notification::assertNothingSent();
    }

    public function test_biznis_ne_moze_urediti_tudji_dogadjaj(): void
    {
        $vlasnik = $this->biznis('a@komteldoo.com');
        $drugi = $this->biznis('b@komteldoo.com');

        $event = Event::create([
            'user_id' => $vlasnik->id,
            'naslov' => ['sr' => 'Tuđi'],
            'datum' => '2026-08-01',
            'status' => ContentStatus::Nacrt,
        ]);

        $this->actingAs($drugi)->get("/nalog/biznis/dogadjaji/{$event->id}/uredi")->assertForbidden();
    }
}
