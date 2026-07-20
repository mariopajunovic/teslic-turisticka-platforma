<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('site.captcha_site_key', env('TURNSTILE_SITEKEY', ''));
        $this->migrator->add('site.captcha_secret', env('TURNSTILE_SECRET', ''));
    }

    public function down(): void
    {
        $this->migrator->delete('site.captcha_site_key');
        $this->migrator->delete('site.captcha_secret');
    }
};
