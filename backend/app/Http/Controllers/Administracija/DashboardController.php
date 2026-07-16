<?php

namespace App\Http\Controllers\Administracija;

use App\Enums\ContentStatus;
use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Business;
use App\Models\Event;
use App\Models\Location;
use App\Models\News;
use App\Models\Story;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    protected array $tipovi = [
        Business::class => ['tip' => 'Biznis', 'tipBoja' => 'brand'],
        Location::class => ['tip' => 'Lokalitet', 'tipBoja' => 'ok'],
        Event::class => ['tip' => 'Događaj', 'tipBoja' => 'info'],
        Ad::class => ['tip' => 'Oglas', 'tipBoja' => 'warn'],
        Story::class => ['tip' => 'Priča', 'tipBoja' => 'gray'],
        News::class => ['tip' => 'Vijest', 'tipBoja' => 'ok'],
    ];

    public function index(): Response
    {
        $poslano = ContentStatus::Poslano->value;

        $odobravanje = 0;
        $red = [];

        foreach ($this->tipovi as $model => $meta) {
            $items = $model::with('user')
                ->where('status', $poslano)
                ->latest('updated_at')
                ->limit(5)
                ->get();

            $odobravanje += $model::where('status', $poslano)->count();

            foreach ($items as $item) {
                $red[] = [
                    'tip' => $meta['tip'],
                    'tipBoja' => $meta['tipBoja'],
                    'naslov' => (string) ($item->naslov ?: 'Bez naslova'),
                    'meta' => trim(($item->user?->name ? 'od '.$item->user->name.' · ' : '').$item->updated_at?->diffForHumans()),
                    'url' => '#',
                ];
            }
        }

        usort($red, fn ($a, $b) => strcmp($b['meta'], $a['meta']));
        $red = array_slice($red, 0, 8);

        $stats = [
            'odobravanje' => $odobravanje,
            'naloziNaOdobrenju' => User::where('status', 'na_odobrenju')->count(),
            'aktivniOglasi' => Ad::where('status', ContentStatus::Objavljeno->value)->count(),
            'dogadjaji' => Event::where('status', ContentStatus::Objavljeno->value)->count(),
        ];

        $aktivnosti = Activity::with('causer', 'subject')
            ->latest()
            ->limit(8)
            ->get()
            ->map(fn (Activity $a) => [
                'icon' => $this->logIcon($a),
                'boja' => $this->logBoja($a),
                'ko' => $a->causer?->name ?? 'Sistem',
                'tekst' => $this->logTekst($a),
                'vrijeme' => $a->created_at?->diffForHumans(),
            ])
            ->all();

        return Inertia::render('Dashboard', [
            'stats' => $stats,
            'red' => $red,
            'aktivnosti' => $aktivnosti,
        ]);
    }

    protected function logIcon(Activity $a): string
    {
        if ($a->log_name === 'auth') {
            return $a->description === 'Odjava' ? 'log-out' : 'log-in';
        }

        return match ($a->event) {
            'created' => 'plus',
            'deleted' => 'trash-2',
            default => 'pencil',
        };
    }

    protected function logBoja(Activity $a): string
    {
        if ($a->log_name === 'auth') {
            return 'brand';
        }

        return match ($a->event) {
            'created' => 'ok',
            'deleted' => 'bad',
            default => 'info',
        };
    }

    protected function logTekst(Activity $a): string
    {
        if ($a->log_name === 'auth') {
            return $a->description === 'Odjava' ? 'se odjavio sa panela' : 'se prijavio na panel';
        }

        $glagol = match ($a->event) {
            'created' => 'kreirao',
            'deleted' => 'obrisao',
            default => 'izmijenio',
        };

        return trim('je '.$glagol.' '.$this->subjektNaziv($a));
    }

    protected function subjektNaziv(Activity $a): string
    {
        if (! $a->subject_type) {
            return '';
        }

        $tip = [
            Business::class => 'biznis',
            Location::class => 'lokalitet',
            Event::class => 'događaj',
            Ad::class => 'oglas',
            Story::class => 'priču',
            News::class => 'vijest',
            User::class => 'korisnika',
            \Spatie\Permission\Models\Role::class => 'ulogu',
        ][$a->subject_type] ?? Str::afterLast($a->subject_type, '\\');

        $ime = $this->subjektIme($a);

        return $ime
            ? $tip.' „'.$ime.'"'
            : $tip.($a->subject_id ? ' #'.$a->subject_id : '');
    }

    protected function subjektIme(Activity $a): ?string
    {
        $subject = $a->subject;

        if (! $subject) {
            return null;
        }

        foreach (['name', 'naslov', 'title'] as $polje) {
            $v = $subject->{$polje} ?? null;

            if (is_array($v)) {
                $v = $v['sr'] ?? (reset($v) ?: null);
            }

            if (is_string($v) && trim($v) !== '') {
                return trim($v);
            }
        }

        return null;
    }
}
