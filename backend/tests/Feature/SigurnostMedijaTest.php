<?php

namespace Tests\Feature;

use App\Enums\ContentStatus;
use App\Http\Controllers\SecureMediaController;
use App\Models\Business;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class SigurnostMedijaTest extends TestCase
{
    use RefreshDatabase;

    protected function biznis(): User
    {
        return User::create([
            'name' => 'Test Biznis',
            'email' => 'biznis@komteldoo.com',
            'password' => 'mario123',
            'role' => 'biznis',
            'status' => 'aktivan',
        ]);
    }

    protected function objavljeni(User $u): Business
    {
        return Business::create([
            'user_id' => $u->id,
            'naslov' => ['sr' => 'Original'],
            'status' => ContentStatus::Objavljeno,
            'published_at' => now(),
        ]);
    }

    protected function saStagedNaslovnom(): Business
    {
        Storage::fake('local');
        Storage::fake('public');

        $u = $this->biznis();
        $b = $this->objavljeni($u);

        $this->actingAs($u)->post("/nalog/biznis/objave/{$b->id}", [
            'naslov' => 'Izmjena',
            'action' => 'posalji',
            'naslovna' => UploadedFile::fake()->image('nova.jpg'),
        ])->assertRedirect();

        return $b->refresh();
    }

    public function test_staged_naslovna_je_na_privatnom_disku(): void
    {
        $b = $this->saStagedNaslovnom();
        $media = $b->getFirstMedia('naslovna_pending');

        $this->assertNotNull($media);
        $this->assertSame('local', $media->disk);
    }

    public function test_pregled_medija_bez_potpisa_odbijen(): void
    {
        $b = $this->saStagedNaslovnom();
        $media = $b->getFirstMedia('naslovna_pending');

        $this->get("/mediji/{$media->id}/pregled")->assertForbidden();
    }

    public function test_pregled_medija_sa_potpisom_radi(): void
    {
        $b = $this->saStagedNaslovnom();
        $media = $b->getFirstMedia('naslovna_pending');

        $this->get(SecureMediaController::url($media))->assertOk();
    }

    public function test_pregled_odbija_ne_pending_kolekciju(): void
    {
        Storage::fake('local');
        Storage::fake('public');

        $u = $this->biznis();
        $b = $this->objavljeni($u);
        $b->addMedia(UploadedFile::fake()->image('ziva.jpg'))->toMediaCollection('naslovna');
        $media = $b->getFirstMedia('naslovna');

        $url = URL::temporarySignedRoute('mediji.pregled', now()->addHour(), ['media' => $media->id]);

        $this->get($url)->assertNotFound();
    }

    public function test_odobravanje_promovise_medij_na_public_disk(): void
    {
        $b = $this->saStagedNaslovnom();
        $b->pending = ['naslov' => 'Izmjena'];
        $b->save();

        $b->primijeniPending();
        $b->refresh();

        $this->assertTrue($b->getMedia('naslovna_pending')->isEmpty());
        $media = $b->getFirstMedia('naslovna');
        $this->assertNotNull($media);
        $this->assertSame('public', $media->disk);
    }
}
