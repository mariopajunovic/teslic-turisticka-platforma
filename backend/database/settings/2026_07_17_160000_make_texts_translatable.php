<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    protected array $keys = [
        'site.brand_naziv',
        'site.brand_logo_tekst',
        'site.footer_opis',
        'site.copyright',
        'site.partneri_tekst',
        'site.seo_opis',
    ];

    public function up(): void
    {
        foreach ($this->keys as $key) {
            $this->migrator->update($key, fn ($value) => is_array($value) ? $value : ['sr' => (string) $value]);
        }
    }

    public function down(): void
    {
        foreach ($this->keys as $key) {
            $this->migrator->update($key, fn ($value) => is_array($value) ? ($value['sr'] ?? '') : (string) $value);
        }
    }
};
