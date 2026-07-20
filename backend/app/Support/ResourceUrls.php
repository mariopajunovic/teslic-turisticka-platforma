<?php

namespace App\Support;

use App\Models\Category;
use App\Models\Page;

class ResourceUrls
{
    public static function types(): array
    {
        return (array) config('resources.types');
    }

    public static function config(string $type): ?array
    {
        return self::types()[$type] ?? null;
    }

    public static function typeFor(object|string $model): ?string
    {
        $class = is_string($model) ? $model : $model::class;

        foreach (self::types() as $key => $cfg) {
            if (($cfg['model'] ?? null) === $class) {
                return $key;
            }
        }

        return null;
    }

    public static function typeForCategory(?string $categoryType): ?string
    {
        foreach (self::types() as $key => $cfg) {
            if (($cfg['category_type'] ?? null) === $categoryType) {
                return $key;
            }
        }

        return null;
    }

    public static function segment(string $type, ?string $lang = null): ?string
    {
        $lang ??= self::jezik();
        $segmenti = self::config($type)['segment'] ?? null;

        if (! $segmenti) {
            return null;
        }

        return $segmenti[$lang] ?? $segmenti['sr'] ?? null;
    }

    public static function segments(string $type): array
    {
        return array_values(array_unique(array_filter((array) (self::config($type)['segment'] ?? []))));
    }

    public static function detail(object $model, ?string $lang = null): ?string
    {
        $type = self::typeFor($model);

        if (! $type) {
            return null;
        }

        $lang ??= self::jezik();
        $slug = method_exists($model, 'slugFor') ? $model->slugFor($lang) : $model->slug;

        if (! $slug) {
            return null;
        }

        return self::sPrefiksom('/'.self::segment($type, $lang).'/'.$slug, $lang);
    }

    public static function collection(string $type, ?string $lang = null): ?string
    {
        $lang ??= self::jezik();

        $page = Page::query()
            ->where('resource_type', $type)
            ->whereNull('category_id')
            ->orderBy('id')
            ->first();

        return $page ? self::sPrefiksom($page->pathFor($lang), $lang) : null;
    }

    public static function category(Category $category, ?string $lang = null): ?string
    {
        $lang ??= self::jezik();

        $page = Page::query()->where('category_id', $category->id)->orderBy('id')->first();

        if ($page) {
            return self::sPrefiksom($page->pathFor($lang), $lang);
        }

        $type = self::typeForCategory($category->type);

        if (! $type) {
            return null;
        }

        $kolekcija = self::collection($type, $lang);

        return $kolekcija ? $kolekcija.'?kategorija='.$category->slugFor($lang) : null;
    }

    protected static function jezik(): string
    {
        return app(ActiveLocale::class)->language();
    }

    protected static function sPrefiksom(string $path, string $lang): string
    {
        return app(ActiveLocale::class)->path($path, $lang);
    }
}
