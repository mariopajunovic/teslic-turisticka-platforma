<?php

namespace App\Support;

class ActiveLocale
{
    protected string $language;

    protected string $script;

    public function __construct(?string $language = null, string $script = 'lat')
    {
        $this->set($language ?? (string) config('locales.default'), $script);
    }

    public function set(string $language, string $script = 'lat'): void
    {
        $languages = (array) config('locales.content');
        $this->language = in_array($language, $languages, true) ? $language : (string) config('locales.default');
        $this->script = ($script === 'cir') ? 'cir' : 'lat';
    }

    public function setScript(string $script): void
    {
        $this->script = ($script === 'cir') ? 'cir' : 'lat';
    }

    public function language(): string
    {
        return $this->language;
    }

    public function script(): string
    {
        return $this->script;
    }

    public function isCyrillic(): bool
    {
        return $this->language === 'sr' && $this->script === 'cir';
    }

    public function prefix(): string
    {
        return (string) (config('locales.languages')[$this->language]['prefix'] ?? '');
    }

    public function appLocale(): string
    {
        return (string) (config('locales.app_locale')[$this->language][$this->script] ?? 'sr_Latn');
    }

    public function htmlLang(): string
    {
        $base = (string) (config('locales.languages')[$this->language]['html'] ?? 'sr');

        return $this->isCyrillic() ? 'sr-Cyrl' : ($this->language === 'sr' ? 'sr-Latn' : $base);
    }

    // Prefixes an app-relative path with the active language prefix (/en, /de).
    public function path(string $path, ?string $language = null): string
    {
        $language ??= $this->language;
        $prefix = (string) (config('locales.languages')[$language]['prefix'] ?? '');
        $path = '/'.ltrim($path, '/');

        if ($prefix === '') {
            return $path;
        }

        return '/'.$prefix.($path === '/' ? '' : $path);
    }

    public function languageOptions(): array
    {
        return collect(config('locales.languages'))
            ->map(fn ($cfg, $key) => [
                'key' => $key,
                'label' => $cfg['label'],
                'short' => $cfg['short'],
                'prefix' => $cfg['prefix'],
                'active' => $key === $this->language,
            ])
            ->values()
            ->all();
    }
}
