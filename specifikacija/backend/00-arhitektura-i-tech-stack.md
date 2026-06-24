# 00 — Arhitektura i tehnološki stack

## Pregled
Jedan **Laravel** monolit servira tri „lica" iz iste baze i domenskog sloja:

```
                       ┌─────────────────────────────────────────┐
                       │              LARAVEL (jedan app)         │
                       │                                          │
  Posjetilac  ───────► │  JAVNI SAJT      (Inertia + Vue 3)       │
                       │   └ reuse frontend/src komponenti        │
  Biznis/Autor ──────► │  NALOG / DASHBOARD (Inertia + Vue 3)     │  ← users guard (web)
                       │   └ account/* views, role-based          │
  Admin ─────────────► │  /admin           (Filament 3)           │  ← admin guard (zaseban)
                       │                                          │
                       │  Domenski sloj: Modeli · Servisi · Policy │
                       │  Baza (MySQL/MariaDB/Postgres) · Storage  │
                       └─────────────────────────────────────────┘
```

- **Javni sajt + nalozi** = jedan Inertia/Vue front (isti dizajn, isti Tailwind tokeni).
- **Admin** = Filament panel, potpuno odvojen guard i model korisnika.
- Sav sadržaj ide kroz **jedan domenski/servisni sloj** (modeli + akcije + policy), tako da i Inertia i Filament rade nad istim pravilima (npr. workflow odobravanja).

## Tehnološke odluke

| Oblast | Izbor | Razlog |
|--------|-------|--------|
| Framework | **Laravel 11** (PHP 8.3+) | zrelo, ekosistem, Filament/Inertia first-class |
| Admin panel | **Filament 3** | brz CRUD, tabele/forme, widgeti, multi-panel, plugin ekosistem |
| Front render | **Inertia 2 + Vue 3** | bez odvojenog API-ja; **reuse postojećih Vue komponenti**; SSR opcionalno |
| Build | **Vite** (Laravel Vite plugin) | isti kao sad; HMR; jedan build pipeline |
| Stilizacija | **Tailwind CSS v4** + `@theme` tokeni | **prenosi se iz `frontend/`** bez izmjena |
| Auth (korisnici) | **Laravel Fortify** (login/registracija/reset/2FA) preko Inertia | headless, prilagodljiv dizajnu spec. 13 |
| Auth (admin) | **Filament auth** + zaseban `admins` guard + **2FA** | odvojena sigurnosna zona (📌 TS 6) |
| Uloge/prava | **spatie/laravel-permission** + **Filament Shield** | role-based na oba guarda |
| Media | **spatie/laravel-medialibrary** | galerije, naslovne slike, video, konverzije/thumb |
| Settings | **spatie/laravel-settings** | logo, kontakt, social, footer, partneri |
| Slug | **spatie/laravel-sluggable** | slugovi entiteta i stranica |
| Activity log | **spatie/laravel-activitylog** | logovi prijava i admin radnji (📌 TS 4.11, TS 8) |
| Workflow status | enum + state-guard u servisu (po potrebi `spatie/laravel-model-states`) | nacrt→odobreno→objavljeno… |
| CAPTCHA | hCaptcha/Cloudflare Turnstile (server-side verify) | javne forme (📌 TS 6) |
| Pretraga | DB (LIKE/fulltext) → opc. **Laravel Scout** kasnije | globalna pretraga iz headera |
| Queue/Mail | DB queue + SMTP | e-mail obavijesti o statusu (🟡 spec. 13E) |

> Verzije fiksiramo na **najnovije stabilne** u trenutku setupa; gornje su minimumi.

## Struktura projekta (ciljna)
Postojeći `frontend/` se **migrira u korijen Laravel aplikacije**; Vue izvor ide u `resources/js`.

```
turisticka/                        ← Laravel root
├── app/
│   ├── Models/                    Business, Location, Event, Ad, Story, News,
│   │                              Category, Tag, Place, Page, Block, Menu, MenuItem,
│   │                              Media, User, Admin
│   ├── Enums/                     ContentStatus, UserRole, BlockType, MenuItemType
│   ├── Filament/                  Admin panel (Resources, Pages, Widgets, …)
│   │   ├── Resources/
│   │   ├── Widgets/
│   │   └── Pages/
│   ├── Http/
│   │   ├── Controllers/           Inertia kontroleri (javni + nalog)
│   │   ├── Middleware/            HandleInertiaRequests, role middleware
│   │   └── Requests/              FormRequest validacije (+ CAPTCHA rule)
│   ├── Actions/                   Submit/Approve/Reject/Publish (workflow)
│   ├── Policies/                  per-model ovlaštenja (vlasništvo + uloge)
│   └── Support/Blocks/            render-mapiranje blok→Vue props
├── resources/
│   ├── js/                        ← iz frontend/src (1:1)
│   │   ├── Pages/                 Inertia stranice (mapirane na views/)
│   │   ├── components/            base/layout/cards/common/map/calendar/forms/account
│   │   ├── composables/  stores/  constants/  assets/
│   │   └── app.js                 Inertia bootstrap (zamjenjuje main.js+router)
│   └── views/app.blade.php        Inertia root + @vite
├── routes/
│   ├── web.php                    javne + nalog rute (Inertia)
│   └── ...                        Filament registruje svoje automatski
├── database/
│   ├── migrations/  factories/  seeders/   ← seed iz postojećih JSON-a
├── config/                        filament, inertia, permission, medialibrary…
├── vite.config.js  tailwind tokeni u resources/css ili @theme
└── composer.json  package.json
```

## Routing model (sažeto)
- **Javne rute** (`web.php`): `/`, `/o-projektu`, `/domace-je-najbolje`, `/turizam`, `/dogadjaji`, `/oglasi`, `/mapa`, `/price`, `/pridruzi-se`, `/kontakt`, pravne — sve vraćaju **Inertia** stranice. Putanje 1:1 s postojećim `frontend/src/router/index.js`.
- **CMS catch-all:** stranice kreirane u Filamentu razrješavaju se preko `/{slug}` (ili po prefiksu), renderuju generičkom Inertia stranicom `PageRenderer` (vidi [03](03-cms-modularnost.md)).
- **Nalog** (`/nalog/...`, `auth` middleware, web guard, uloge biznis/autor): postojeće `account/*` rute.
- **Admin** (`/admin`, Filament, admin guard): registruje Filament.

## Zašto monolit (a ne odvojeni API + SPA)
- Nema duplog deploya/CORS-a; jedan build, jedan hosting (📌 TS 7).
- Inertia daje SPA osjećaj uz server-side rute/auth/policy — manje koda nego REST + SPA.
- Filament i Inertia dijele iste modele i policy → **workflow odobravanja se piše jednom**.

## 🔗 Veze
[Model podataka](01-model-podataka.md) · [Filament](02-filament-admin.md) · [CMS](03-cms-modularnost.md) · [Inertia front](04-inertia-frontend.md) · [Frontend plan](../frontend/00-PLAN-RADA.md)
</content>
