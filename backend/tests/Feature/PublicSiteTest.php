<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicSiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public static function pages(): array
    {
        return [
            'home' => ['/'],
            'biznisi' => ['/domace-je-najbolje'],
            'biznis detalj' => ['/domace-je-najbolje/stari-zanati-borje'],
            'turizam' => ['/turizam'],
            'lokalitet detalj' => ['/turizam/planina-borja'],
            'dogadjaji' => ['/dogadjaji'],
            'dogadjaj detalj' => ['/dogadjaji/ljeto-na-borju'],
            'oglasi' => ['/oglasi'],
            'oglas detalj' => ['/oglasi/konobar-kardial'],
            'price' => ['/price'],
            'prica detalj' => ['/price/ljudi-duh-teslica'],
            'mapa' => ['/mapa'],
            'cms o-projektu' => ['/o-projektu'],
            'cms pravna' => ['/politika-privatnosti'],
            'kontakt' => ['/kontakt'],
            'pridruzi-se' => ['/pridruzi-se'],
        ];
    }

    #[DataProvider('pages')]
    public function test_public_page_renders(string $url): void
    {
        $this->get($url)->assertOk();
    }

    public function test_unknown_business_returns_404(): void
    {
        $this->get('/domace-je-najbolje/nepostojeci-slug')->assertNotFound();
    }
}
