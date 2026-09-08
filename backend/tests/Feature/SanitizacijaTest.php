<?php

namespace Tests\Feature;

use App\Models\Business;
use App\Models\Story;
use App\Support\SafeHtml;
use PHPUnit\Framework\Attributes\DataProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SanitizacijaTest extends TestCase
{
    use RefreshDatabase;

    public static function napadi(): array
    {
        return [
            'script tag' => ['<p>Zdravo</p><script>alert(1)</script>', 'script'],
            'img onerror' => ['<img src=x onerror="alert(1)">', 'onerror'],
            'javascript: link' => ['<a href="javascript:alert(1)">klik</a>', 'javascript:'],
            'iframe' => ['<iframe src="https://zlo.example"></iframe>', 'iframe'],
            'svg onload' => ['<svg onload="alert(1)"></svg>', 'onload'],
            'style izraz' => ['<p style="background:url(javascript:alert(1))">x</p>', 'javascript:'],
            'form' => ['<form action="https://zlo.example"><input name="a"></form>', '<form'],
            'onclick atribut' => ['<p onclick="alert(1)">tekst</p>', 'onclick'],
        ];
    }

    #[DataProvider('napadi')]
    public function test_opasan_html_se_uklanja(string $ulaz, string $zabranjeno): void
    {
        $this->assertStringNotContainsString($zabranjeno, (string) SafeHtml::clean($ulaz));
    }

    public function test_legitiman_sadrzaj_ostaje(): void
    {
        $html = '<h2>Naslov</h2><p>Tekst sa <strong>podebljanim</strong> i <em>kurzivom</em>.</p>'
            .'<ul><li>prva</li><li>druga</li></ul>'
            .'<blockquote>citat</blockquote>'
            .'<p><a href="https://visitteslic.com">link</a></p>'
            .'<img src="/storage/slika.jpg" alt="opis" class="rtf-img"><hr>';

        $ocisceno = (string) SafeHtml::clean($html);

        foreach (['<h2>', '<strong>', '<em>', '<ul>', '<li>', '<blockquote>', 'href="https://visitteslic.com"', '<img', 'src="/storage/slika.jpg"', 'alt="opis"', '<hr'] as $ocekivano) {
            $this->assertStringContainsString($ocekivano, $ocisceno, "nedostaje: $ocekivano");
        }
    }

    public function test_model_cisti_pri_snimanju(): void
    {
        $prica = Story::create([
            'naslov' => ['sr' => 'Test'],
            'sadrzaj' => ['sr' => '<p>Ok</p><script>alert(1)</script>'],
            'status' => 'nacrt',
        ]);

        $this->assertStringNotContainsString('script', $prica->fresh()->getTranslations('sadrzaj')['sr']);
    }

    public function test_biznis_opis_dug_se_cisti(): void
    {
        $biznis = Business::create([
            'naslov' => ['sr' => 'Test biznis'],
            'opis_dug' => ['sr' => '<p>Opis</p><img src=x onerror="alert(1)">'],
            'status' => 'nacrt',
        ]);

        $this->assertStringNotContainsString('onerror', $biznis->fresh()->getTranslations('opis_dug')['sr']);
    }
}
