<?php

namespace App\Http\Controllers\Administracija;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LogoviController extends Controller
{
    public function index(Request $request): Response
    {
        $logovi = $this->filtriraj($request)
            ->latest()
            ->paginate(10)
            ->withQueryString()
            ->through(fn (Activity $a) => $this->row($a));

        return Inertia::render('Logovi', [
            'logovi' => $logovi,
            'filteri' => [
                'korisnik' => $request->query('korisnik'),
                'akcija' => $request->query('akcija'),
                'period' => $request->query('period'),
            ],
        ]);
    }

    public function izvoz(Request $request): StreamedResponse
    {
        $naziv = 'logovi-aktivnosti-'.now()->format('Y-m-d-His').'.csv';

        return response()->streamDownload(function () use ($request) {
            $out = fopen('php://output', 'w');
            fwrite($out, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($out, ['Vrijeme', 'Korisnik', 'Uloga', 'Akcija', 'Opis', 'Entitet', 'IP adresa', 'Uređaj', 'Izmjene']);

            $this->filtriraj($request)
                ->latest()
                ->chunk(500, function ($chunk) use ($out) {
                    foreach ($chunk as $a) {
                        $r = $this->row($a);
                        $izmjene = collect($r['izmjene'])
                            ->map(fn ($i) => $i['polje'].': '.($i['staro'] ?? '').' -> '.($i['novo'] ?? ''))
                            ->implode('; ');

                        fputcsv($out, [
                            $r['vrijeme'], $r['korisnikPuni'], $r['uloga'], $r['akcija'],
                            $r['opis'], $r['entitet'], $r['ip'], $r['uredaj'], $izmjene,
                        ]);
                    }
                });

            fclose($out);
        }, $naziv, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    protected function filtriraj(Request $request)
    {
        $korisnik = $request->query('korisnik');
        $akcija = $request->query('akcija');
        $period = $request->query('period');

        return Activity::query()
            ->with('causer', 'subject')
            ->when($korisnik, function ($query) use ($korisnik) {
                $tip = match ($korisnik) {
                    'admin' => 'App\Models\Admin',
                    'web' => 'App\Models\User',
                    default => null,
                };

                if ($tip) {
                    $query->where('causer_type', $tip);
                }
            })
            ->when($akcija, function ($query) use ($akcija) {
                $akcija === 'auth'
                    ? $query->where('log_name', 'auth')
                    : $query->where('event', $akcija);
            })
            ->when($period, function ($query) use ($period) {
                $od = match ($period) {
                    'danas' => Carbon::today(),
                    '7dana' => Carbon::now()->subDays(7),
                    '30dana' => Carbon::now()->subDays(30),
                    default => null,
                };

                if ($od) {
                    $query->where('created_at', '>=', $od);
                }
            });
    }

    protected function row(Activity $a): array
    {
        $properties = $a->properties;
        $ip = is_object($properties) || is_array($properties) ? ($properties['ip'] ?? null) : null;

        $ua = is_object($properties) || is_array($properties) ? ($properties['user_agent'] ?? null) : null;

        return [
            'id' => $a->id,
            'vrijeme' => $a->created_at?->format('d.m.Y. H:i'),
            'korisnik' => $this->skratiIme($a->causer?->name),
            'korisnikPuni' => $a->causer?->name ?? 'Sistem',
            'uloga' => $this->causerUloga($a),
            'akcija' => $this->akcijaLabel($a),
            'akcijaBoja' => $this->akcijaBoja($a),
            'opis' => $this->opis($a),
            'naslov' => $a->description,
            'entitet' => $this->entitet($a),
            'ip' => $ip ?: '-',
            'uredaj' => $ua ?: '-',
            'izmjene' => $this->izmjene($a),
        ];
    }

    protected function causerUloga(Activity $a): string
    {
        $causer = $a->causer;

        if (! $causer) {
            return 'Sistem';
        }

        if ($causer instanceof \App\Models\Admin) {
            if ($causer->is_super) {
                return 'Super administrator';
            }

            $role = $causer->getRoleNames()->first();

            return $role ? Str::ucfirst($role) : 'Administrator';
        }

        return 'Korisnik';
    }

    protected function izmjene(Activity $a): array
    {
        $props = $a->properties;
        $novo = (array) (is_object($props) || is_array($props) ? ($props['attributes'] ?? []) : []);
        $staro = (array) (is_object($props) || is_array($props) ? ($props['old'] ?? []) : []);

        $polja = array_keys($novo ?: $staro);
        $out = [];

        foreach ($polja as $polje) {
            $out[] = [
                'polje' => Str::ucfirst(str_replace('_', ' ', (string) $polje)),
                'staro' => array_key_exists($polje, $staro) ? $this->formatVrijednost($staro[$polje]) : null,
                'novo' => array_key_exists($polje, $novo) ? $this->formatVrijednost($novo[$polje]) : null,
            ];
        }

        return $out;
    }

    protected function formatVrijednost($v): string
    {
        if (is_null($v)) {
            return '-';
        }

        if (is_bool($v)) {
            return $v ? 'Da' : 'Ne';
        }

        if (is_array($v)) {
            return json_encode($v, JSON_UNESCAPED_UNICODE) ?: '-';
        }

        $s = (string) $v;

        return $s === '' ? '-' : $s;
    }

    protected function skratiIme(?string $ime): string
    {
        $ime = trim((string) $ime);

        if ($ime === '') {
            return 'Sistem';
        }

        $dijelovi = preg_split('/\s+/', $ime);

        if (count($dijelovi) < 2) {
            return $ime;
        }

        return $dijelovi[0].' '.Str::upper(Str::substr($dijelovi[count($dijelovi) - 1], 0, 1)).'.';
    }

    protected function opis(Activity $a): string
    {
        if ($a->log_name === 'auth') {
            return $a->description === 'Odjava' ? 'odjava iz panela' : 'prijava u panel';
        }

        return match ($a->event) {
            'created' => 'kreirao sadržaj',
            'updated' => 'izmijenio sadržaj',
            'deleted' => 'obrisao sadržaj',
            default => (string) $a->description,
        };
    }

    protected function entitet(Activity $a): string
    {
        if (! $a->subject_type) {
            return '-';
        }

        $tip = [
            'App\Models\Business' => 'Biznis',
            'App\Models\Location' => 'Lokalitet',
            'App\Models\Event' => 'Događaj',
            'App\Models\Ad' => 'Oglas',
            'App\Models\Story' => 'Priča',
            'App\Models\News' => 'Vijest',
            'App\Models\User' => 'Korisnik',
            'App\Models\Admin' => 'Administrator',
            'Spatie\Permission\Models\Role' => 'Uloga',
        ][$a->subject_type] ?? class_basename($a->subject_type);

        $naziv = $this->subjektNaziv($a);

        return $naziv
            ? $tip.': '.$naziv
            : $tip.($a->subject_id ? ' #'.$a->subject_id : '');
    }

    protected function subjektNaziv(Activity $a): ?string
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

    protected function akcijaLabel(Activity $a): string
    {
        if ($a->log_name === 'auth') {
            return $a->description;
        }

        return match ($a->event) {
            'created' => 'Kreiranje',
            'updated' => 'Izmjena',
            'deleted' => 'Brisanje',
            default => Str::ucfirst((string) $a->event),
        };
    }

    protected function akcijaBoja(Activity $a): string
    {
        if ($a->log_name === 'auth') {
            return $a->description === 'Odjava' ? 'gray' : 'info';
        }

        return match ($a->event) {
            'created' => 'ok',
            'updated' => 'info',
            'deleted' => 'bad',
            default => 'gray',
        };
    }
}
