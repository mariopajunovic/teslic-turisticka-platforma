<?php

namespace App\Http\Controllers\Administracija;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Business;
use App\Models\Event;
use App\Models\Location;
use App\Models\News;
use App\Models\Page;
use App\Models\Procurement;
use App\Models\Story;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GlobalSearchController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $q = trim((string) $request->query('q', ''));

        if (mb_strlen($q) < 2) {
            return response()->json(['grupe' => []]);
        }

        $admin = $request->user('admin');
        $moze = fn (string $ability) => $admin && ($admin->is_super || $admin->hasPermissionTo($ability));

        $like = fn ($query, array $kolone) => $query->where(function ($w) use ($kolone, $q) {
            foreach ($kolone as $col) {
                $w->orWhereRaw('CAST('.$col.' AS CHAR) COLLATE utf8mb4_unicode_ci LIKE ?', ['%'.$q.'%']);
            }
        });

        $grupe = [];

        if ($moze('upravljanje sadržajem')) {
            $resursi = [
                [Business::class, 'Biznisi', ['naslov', 'lokacija'], 'biznisi'],
                [Location::class, 'Lokaliteti', ['naslov', 'lokacija'], 'turizam'],
                [Event::class, 'Događaji', ['naslov', 'lokacija'], 'dogadjaji'],
                [Ad::class, 'Oglasi', ['naslov'], 'oglasi'],
                [Story::class, 'Priče', ['naslov'], 'price'],
                [News::class, 'Vijesti', ['naslov'], 'vijesti'],
                [Procurement::class, 'Javne nabavke', ['naslov'], 'nabavke'],
            ];

            foreach ($resursi as [$model, $label, $kolone, $baza]) {
                $stavke = $like($model::query(), $kolone)
                    ->orderByDesc('id')
                    ->limit(5)
                    ->get()
                    ->map(fn ($m) => [
                        'naslov' => (string) ($m->naslov ?: '(bez naslova)'),
                        'meta' => (string) ($m->lokacija ?? ''),
                        'url' => '/administracija/'.$baza.'/'.$m->id.'/uredi',
                    ])
                    ->all();

                if ($stavke) {
                    $grupe[] = ['tip' => $label, 'stavke' => $stavke];
                }
            }
        }

        if ($moze('upravljanje stranicama')) {
            $stavke = $like(Page::query(), ['title', 'slug'])
                ->orderByDesc('id')
                ->limit(5)
                ->get()
                ->map(fn (Page $p) => [
                    'naslov' => (string) ($p->title ?: '(bez naslova)'),
                    'meta' => (string) ($p->slugFor('sr') ?? ''),
                    'url' => '/administracija/stranice/'.$p->id.'/uredi',
                ])
                ->all();

            if ($stavke) {
                $grupe[] = ['tip' => 'Stranice', 'stavke' => $stavke];
            }
        }

        if ($moze('upravljanje korisnicima')) {
            $stavke = $like(User::query(), ['name', 'email'])
                ->orderByDesc('id')
                ->limit(5)
                ->get()
                ->map(fn (User $u) => [
                    'naslov' => (string) $u->name,
                    'meta' => (string) $u->email,
                    'url' => '/administracija/korisnici/'.$u->id,
                ])
                ->all();

            if ($stavke) {
                $grupe[] = ['tip' => 'Korisnici', 'stavke' => $stavke];
            }
        }

        return response()->json(['grupe' => $grupe]);
    }
}
