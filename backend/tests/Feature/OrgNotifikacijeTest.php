<?php

namespace Tests\Feature;

use App\Actions\Fortify\CreateNewUser;
use App\Enums\ContentStatus;
use App\Models\Business;
use App\Models\User;
use App\Notifications\OrgNovaPoruka;
use App\Notifications\OrgNovaRegistracija;
use App\Notifications\OrgSadrzajNaOdobrenju;
use App\Settings\SiteSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class OrgNotifikacijeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $s = app(SiteSettings::class);
        $s->kontakt_email = 'org@teslic.ba';
        $s->save();
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

    public function test_registracija_salje_org_email(): void
    {
        Notification::fake();

        app(CreateNewUser::class)->create([
            'name' => 'Novi Biznis',
            'email' => 'novi@primjer.ba',
            'password' => 'lozinka123',
            'password_confirmation' => 'lozinka123',
            'role' => 'biznis',
        ]);

        Notification::assertSentOnDemand(OrgNovaRegistracija::class);
    }

    public function test_novi_sadrzaj_na_odobrenje_salje_org_email(): void
    {
        Notification::fake();
        $u = $this->biznis();
        $b = Business::create([
            'user_id' => $u->id,
            'naslov' => ['sr' => 'Nacrt biznis'],
            'status' => ContentStatus::Nacrt,
        ]);

        $this->actingAs($u)->post("/nalog/biznis/objave/{$b->id}", [
            'naslov' => 'Poslani biznis',
            'action' => 'posalji',
        ])->assertRedirect();

        Notification::assertSentOnDemand(OrgSadrzajNaOdobrenju::class);
    }

    public function test_kontakt_poruka_salje_org_email(): void
    {
        Notification::fake();

        $this->post('/kontakt', [
            'ime' => 'Marko',
            'email' => 'marko@primjer.ba',
            'poruka' => 'Zdravo, imam pitanje.',
        ])->assertRedirect();

        Notification::assertSentOnDemand(OrgNovaPoruka::class);
    }

    public function test_bez_kontakt_emaila_ne_puca(): void
    {
        Notification::fake();
        $s = app(SiteSettings::class);
        $s->kontakt_email = '';
        $s->save();

        $this->post('/kontakt', [
            'ime' => 'Marko',
            'email' => 'marko@primjer.ba',
            'poruka' => 'Test.',
        ])->assertRedirect();

        Notification::assertNothingSent();
    }
}
