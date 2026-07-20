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
            'biznis detalj' => ['/biznis/stari-zanati-borje'],
            'turizam' => ['/turizam'],
            'lokalitet detalj' => ['/lokalitet/planina-borja'],
            'dogadjaji' => ['/dogadjaji'],
            'dogadjaj detalj' => ['/dogadjaj/ljeto-na-borju'],
            'oglasi' => ['/oglasi'],
            'oglas detalj' => ['/oglas/konobar-kardial'],
            'price' => ['/price'],
            'prica detalj' => ['/prica/ljudi-duh-teslica'],
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
        $this->get('/biznis/nepostojeci-slug')->assertNotFound();
    }
}
