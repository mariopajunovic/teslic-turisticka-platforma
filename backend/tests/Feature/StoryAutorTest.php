<?php

namespace Tests\Feature;

use App\Enums\ContentStatus;
use App\Http\Resources\StoryResource;
use App\Models\Story;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoryAutorTest extends TestCase
{
    use RefreshDatabase;

    public function test_autor_i_bio_se_preuzimaju_iz_vezanog_korisnika(): void
    {
        $u = new User([
            'name' => 'Ana Anić',
            'email' => 'ana@komteldoo.com',
            'password' => 'mario123',
            'role' => 'autor',
            'status' => 'aktivan',
        ]);
        $u->setTranslations('bio', ['sr' => 'Biografija Ane']);
        $u->save();

        $s = new Story(['user_id' => $u->id, 'status' => ContentStatus::Objavljeno]);
        $s->setTranslations('naslov', ['sr' => 'Priča o kraju']);
        $s->setTranslations('autor', ['sr' => 'Stari ručni autor']);
        $s->setTranslations('autor_bio', ['sr' => 'Stara ručna bio']);
        $s->published_at = now();
        $s->save();
        $s->load('user');

        $arr = (new StoryResource($s))->toArray(request());

        $this->assertSame('Ana Anić', $arr['autor']);
        $this->assertSame('Biografija Ane', $arr['autorBio']);
    }

    public function test_bez_korisnika_koristi_rucni_autor(): void
    {
        $s = new Story(['status' => ContentStatus::Objavljeno]);
        $s->setTranslations('naslov', ['sr' => 'Priča']);
        $s->setTranslations('autor', ['sr' => 'Gost Autor']);
        $s->setTranslations('autor_bio', ['sr' => 'Gostujuća bio']);
        $s->published_at = now();
        $s->save();

        $arr = (new StoryResource($s))->toArray(request());

        $this->assertSame('Gost Autor', $arr['autor']);
        $this->assertSame('Gostujuća bio', $arr['autorBio']);
    }
}
