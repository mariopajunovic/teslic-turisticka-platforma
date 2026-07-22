<?php

namespace App\Support;

use App\Enums\ContentStatus;
use App\Models\Ad;
use App\Models\Business;
use App\Models\Event;
use App\Models\Location;
use App\Models\News;
use App\Models\Story;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Models\Activity;

class AdminObavijesti
{
    protected static array $tipovi = [
        Business::class => ['tip' => 'Biznis', 'tipBoja' => 'brand', 'baza' => 'biznisi'],
        Location::class => ['tip' => 'Lokalitet', 'tipBoja' => 'ok', 'baza' => 'turizam'],
        Event::class => ['tip' => 'Događaj', 'tipBoja' => 'info', 'baza' => 'dogadjaji'],
        Ad::class => ['tip' => 'Oglas', 'tipBoja' => 'warn', 'baza' => 'oglasi'],
        Story::class => ['tip' => 'Priča', 'tipBoja' => 'gray', 'baza' => 'price'],
        News::class => ['tip' => 'Vijest', 'tipBoja' => 'ok', 'baza' => 'vijesti'],
    ];

    protected static function filter(string $model): \Closure
    {
        $poslano = ContentStatus::Poslano->value;
        $imaPending = Schema::hasColumn((new $model)->getTable(), 'pending');

        return fn ($q) => $q->where('status', $poslano)
            ->when($imaPending, fn ($q) => $q->orWhere(fn ($q) => $q->whereNotNull('pending')->whereNull('pending_reason')));
    }

    public static function redOdobravanja(int $limit = 8): array
    {
        $red = [];

        foreach (static::$tipovi as $model => $meta) {
            $imaPending = Schema::hasColumn((new $model)->getTable(), 'pending');

            $items = $model::with('user')->where(static::filter($model))->latest('updated_at')->limit(5)->get();

            foreach ($items as $item) {
                $izmjena = $imaPending && $item->pending !== null;

                $red[] = [
                    'tip' => $meta['tip'],
                    'tipBoja' => $meta['tipBoja'],
                    'oznaka' => $izmjena ? 'Izmjena' : 'Novo',
                    'naslov' => (string) ($item->naslov ?: 'Bez naslova'),
                    'meta' => trim(($item->user?->name ? 'od '.$item->user->name.' · ' : '').($izmjena ? 'izmjena objave · ' : '').$item->updated_at?->diffForHumans()),
                    'datum' => $item->updated_at?->translatedFormat('d.m.Y. H:i'),
                    'ts' => $item->updated_at?->getTimestamp() ?? 0,
                    'url' => "/administracija/{$meta['baza']}/{$item->id}/uredi",
                ];
            }
        }

        usort($red, fn ($a, $b) => $b['ts'] <=> $a['ts']);

        return array_slice($red, 0, $limit);
    }

    public static function brojOdobravanja(): int
    {
        $count = 0;

        foreach (array_keys(static::$tipovi) as $model) {
            $count += $model::where(static::filter($model))->count();
        }

        return $count;
    }

    public static function brojRegistracija(): int
    {
        return User::where('status', 'na_odobrenju')->count();
    }

    public static function broj(): int
    {
        return static::brojOdobravanja() + static::brojRegistracija();
    }

    /** Kombinovana lista za zvono: sadržaj na odobrenju + nove registracije + kontakt poruke. */
    public static function sve(int $limit = 12): array
    {
        $stavke = static::redOdobravanja($limit);

        foreach (User::where('status', 'na_odobrenju')->latest()->limit(5)->get() as $u) {
            $stavke[] = [
                'tip' => 'Registracija',
                'tipBoja' => 'info',
                'oznaka' => 'Nalog',
                'naslov' => $u->name,
                'meta' => 'nova registracija · '.$u->created_at?->diffForHumans(),
                'datum' => $u->created_at?->translatedFormat('d.m.Y. H:i'),
                'ts' => $u->created_at?->getTimestamp() ?? 0,
                'url' => '/administracija/korisnici',
            ];
        }

        foreach (Activity::where('log_name', 'kontakt')->latest()->limit(5)->get() as $a) {
            $stavke[] = [
                'tip' => 'Poruka',
                'tipBoja' => 'gray',
                'oznaka' => 'Kontakt',
                'naslov' => trim(str_replace('Kontakt poruka:', '', (string) $a->description)) ?: 'Nova poruka',
                'meta' => 'poruka sa sajta · '.$a->created_at?->diffForHumans(),
                'datum' => $a->created_at?->translatedFormat('d.m.Y. H:i'),
                'ts' => $a->created_at?->getTimestamp() ?? 0,
                'url' => '/administracija/logovi',
            ];
        }

        usort($stavke, fn ($a, $b) => $b['ts'] <=> $a['ts']);

        return array_slice($stavke, 0, $limit);
    }
}
