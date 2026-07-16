# Administracija (Inertia + Vue) — Contract

Separate Inertia app for the admin panel. **Do not touch** the public app
(`resources/js/app.js`, `resources/js/Pages/**`) or Filament (`app/Filament/**`, `/admin`).
This admin lives at **`/administracija`**, `admin` guard, own root view (`administracija`),
own Vite entry (`resources/js/administracija/app.js`), own CSS (`resources/css/administracija.css`).

Stack: Laravel 13, Inertia `@inertiajs/vue3` v3.4, Vue 3.5 `<script setup>` (Composition API, **no TypeScript**),
Tailwind v4. Package manager runs in Sail: `./vendor/bin/sail ...`.

Design reference (already approved): a WordPress-style admin — dark left sidebar, light content,
teal (`#0E8275`) accent. Match the visual language of the earlier Pencil design.

---

## 1. Design tokens (Tailwind classes already available)

Defined in `resources/css/administracija.css` via `@theme`. Use these Tailwind classes:

- Sidebar: `bg-sidebar` `bg-sidebar-alt` `text-sidebar-text` `text-sidebar-strong` `text-sidebar-group`
- Surfaces: `bg-canvas` `bg-surface` `bg-surface-alt` `border-line` `border-line-strong`
- Text: `text-ink` `text-ink-2` `text-ink-3`
- Brand: `bg-brand` `text-brand` `bg-brand-tint` `hover:bg-brand-dark`
- Status: `text-warn`/`bg-warn-bg`, `text-ok`/`bg-ok-bg`, `text-bad`/`bg-bad-bg`, `text-info`/`bg-info-bg`
- Radius: `rounded-[var(--radius-card)]` (8px). Shadows: `shadow-[var(--shadow-card)]` / `shadow-[var(--shadow-pop)]`
- Icons: use `lucide-vue-next` (install it): `import { Inbox } from 'lucide-vue-next'`.

Responsive: mobile-first. On `< lg` the sidebar is a slide-over drawer (hamburger in topbar toggles it).
Tables become stacked cards on `< md`. No horizontal page scroll ever.

---

## 2. Routes (name → method path → Inertia page)

Guest (middleware `guest:admin`):
- `administracija.prijava.show`  GET  `/administracija/prijava`   → `Prijava`
- `administracija.prijava`       POST `/administracija/prijava`   (authenticate `admin` guard, rate-limit 5/min)
- `administracija.2fa.show`      GET  `/administracija/2fa`       → `Dvofaktorska`
- `administracija.2fa`           POST `/administracija/2fa`       (verify TOTP)

Auth (middleware `auth:admin`):
- `administracija.dashboard`     GET  `/administracija`          → `Dashboard`
- `administracija.korisnici`     GET  `/administracija/korisnici`→ `Korisnici`   (perm: upravljanje korisnicima)
- `administracija.administratori`GET  `/administracija/administratori` → `Administratori` (super/admin only)
- `administracija.uloge`         GET  `/administracija/uloge`    → `Uloge`       (super/admin only)
- `administracija.logovi`        GET  `/administracija/logovi`   → `Logovi`      (perm: pregled logova)
- `administracija.odjava`        POST `/administracija/odjava`

Frontend navigates with Inertia `<Link>` / `router.post`. Reference routes by literal path
(e.g. `/administracija/korisnici`) — no Ziggy.

---

## 3. Shared Inertia props (every page)

Provided by `App\Http\Middleware\HandleAdminInertiaRequests` (rootView `administracija`):
```
auth.admin: { name, email, initials, roles: string[], is_super: boolean } | null
flash: { status?: string, error?: string }
badges: { odobravanje: number }   // pending-approval count for the sidebar nav badge
```

## 4. Per-page props (what each controller passes / each page expects)

**Prijava** — `{ status?: string }`. Form posts `{ email, password, remember }` to `administracija.prijava`.
**Dvofaktorska** — `{}`. Form posts `{ code }` to `administracija.2fa`; link back to login; "rezervni kod".

**Dashboard** — `{ stats: { odobravanje, noviKorisnici, aktivniOglasi, dogadjaji }, red: RedItem[], aktivnosti: LogItem[] }`
- `RedItem: { tip, tipBoja: 'brand'|'ok'|'warn'|'info'|'gray', naslov, meta, url }`
- `LogItem: { icon, boja, tekst, vrijeme }`

**Korisnici** — `{ korisnici: { data: UserRow[], links, meta }, filteri: { status, uloga, q } }`
- `UserRow: { id, ime, email, initials, uloga, ulogaBoja, status, statusBoja, zadnjaPrijava, akcija: 'blokiraj'|'odobri'|'odblokiraj' }`
- statuses: aktivan (ok), na_odobrenju (warn), blokiran (bad).

**Administratori** — `{ administratori: AdminRow[] }`
- `AdminRow: { id, ime, email, initials, uloga, ulogaBoja, dvaFA: boolean, dvaFAtekst, zadnjaPrijava }`

**Uloge** — `{ uloge: RoleCard[], matrica: PermRow[] }`
- `RoleCard: { naziv, boja, opis, brojNaloga }`
- `PermRow: { dozvola, administrator: boolean, urednik: boolean }` (from spec 12 matrix)

**Logovi** — `{ logovi: { data: LogRow[], links, meta }, filteri: { korisnik, akcija, period } }`
- `LogRow: { vrijeme, korisnik, akcija, akcijaBoja, opis, entitet, ip }`

Backend agent: derive real data from models (Business/Location/Event/Ad/Story/News for approval counts;
`users` for Korisnici with `status`; `admins` + roles for Administratori; spatie roles/permissions for Uloge;
`activity_log` table for Logovi). Use `->paginate(20)->withQueryString()` for Korisnici & Logovi.

---

## 5. Component API (Vue SFCs in `resources/js/administracija/components/`)

Build these, `<script setup>`, props via `defineProps`, slots where noted. All responsive.

- **AdminLayout.vue** — the shell. Renders `<Sidebar>` + `<Topbar>` + `<main><slot/></main>`.
  Reads shared props via `usePage()`. Holds mobile drawer open state. Default layout for all pages except auth.
- **Sidebar.vue** — dark nav. Groups + items from a static list (see nav below). Active item by `usePage().url`.
  Props: `{ open: Boolean }` (mobile drawer). Emits `close`. Shows `badges.odobravanje` pill on "Red odobravanja".
- **SidebarItem.vue** — `{ icon, label, href, active, count? }`.
- **Topbar.vue** — hamburger (emits `toggle`), page title (slot or prop), search, admin avatar + dropdown (Odjava).
  Props `{ title }`.
- **Card.vue** — `{ title?, count? }`, slots: `#actions`, default (body). Header hidden when no title.
- **Badge.vue** — `{ label, color: 'brand'|'ok'|'warn'|'bad'|'info'|'gray', dot?: Boolean }`.
- **StatCard.vue** — `{ label, value, caption, icon, color }`.
- **Btn.vue** — `{ variant: 'primary'|'secondary'|'ghost'|'danger', icon?, size? }`, slot label. `as` = button|Link (href).
- **IconBtn.vue** — `{ icon, color?, tooltip? }`.
- **DataTable.vue** — `{ columns: {key,label,align?,width?}[] }`, slots: default = rows (consumer renders `<tr>`),
  responsive: on `< md` becomes stacked. Provide `TableCell.vue` if helpful. Header row styled `bg-surface-alt`.
- **Tabs.vue** — `{ tabs: {key,label}[], modelValue }`, `v-model`.
- **Dropdown.vue** — `{ label, icon? }` filter pill (design only, opens menu).
- **Pagination.vue** — `{ links, meta }` from Laravel paginator (Inertia links).
- **Avatar.vue** — `{ initials, size? }`.
- **FormField.vue** / **SelectField.vue** / **TextareaField.vue** / **ToggleField.vue** — label + control, `v-model`.
- **EmptyState.vue** — `{ icon, title, text }`.

Sidebar nav (icons from lucide-vue-next), groups:
- (top) Nadzorna ploča → `/administracija`
- Sadržaj: Red odobravanja (count badge), Oglasi, Biznisi, Događaji, Lokaliteti, Vijesti, Priče (content routes are placeholders `#` for now)
- Sistem: Korisnici → `/administracija/korisnici`, Administratori → `/administracija/administratori`, Uloge → `/administracija/uloge`, Logovi aktivnosti → `/administracija/logovi`
- Postavke: Postavke sajta (`#`), Mediji (`#`)

Only wire real hrefs for the routes in §2; the rest are `#` placeholders (later iteration).

---

## 6. Global activity logger (backend agent)

Requirement: a **global** logger that records every create/update/delete across the system.
- Add a service provider (e.g. `App\Providers\ActivityLogServiceProvider`) that registers a global
  Eloquent listener (via `Event::listen('eloquent.created: *' | 'eloquent.updated: *' | 'eloquent.deleted: *')`
  or a base observer) writing to spatie `activity_log`.
- Skip noisy/internal models: `Spatie\Activitylog\Models\Activity`, sessions, cache, jobs, password reset tokens,
  and models that already log via `TracksStatus` (avoid double logging — either exclude those or dedupe).
- Each entry: `causer` = `auth('admin')->user() ?? auth('web')->user()`, `description` (created/updated/deleted +
  model + key), and `properties` include `ip` (`request()->ip()`), `user_agent`, and `attributes`/`old` for updates.
- Also log admin **login/logout** with IP (there is already a Login/Logout listener in `AppServiceProvider` — extend
  it to add IP, or add here). Register the provider in `bootstrap/providers.php`.
- Publish/create `config/activitylog.php` if needed. The Logovi page reads from this table.

---

## 7. Wiring (backend agent owns)

- `routes/administracija.php` — all routes in §2, grouped, with `auth:admin` / `guest:admin` + permission checks.
- Register that route file in `bootstrap/app.php` under a dedicated middleware group `admin` that contains the
  standard web stack (EncryptCookies, AddQueuedCookies, StartSession, ShareErrorsFromSession, CSRF, SubstituteBindings)
  **plus** `HandleAdminInertiaRequests` — but NOT the public `HandleInertiaRequests`, `SetLocale`, or
  `EnsureSiteAvailable`. Verify exact middleware class names against the installed framework in `vendor/`.
- Controllers in `app/Http/Controllers/Administracija/`. Auth controller uses the `admin` guard + `RateLimiter`.
- `HandleAdminInertiaRequests` (rootView `administracija`, shares §3). Reuse the roles from `RolePermissionSeeder`
  (`administrator`, `urednik`) and permissions (`upravljanje sadržajem/korisnicima/stranicama`, `sistemske postavke`, `pregled logova`).

## File ownership (no overlaps)
- BACKEND: `routes/administracija.php`, `app/Http/Controllers/Administracija/**`, `app/Http/Middleware/HandleAdminInertiaRequests.php`, `app/Observers/**`, `app/Providers/ActivityLogServiceProvider.php`, `config/activitylog.php`, edits to `bootstrap/app.php` + `bootstrap/providers.php`.
- COMPONENTS: `resources/js/administracija/components/**`.
- PAGES: `resources/js/administracija/Pages/**`.
- Foundation (already done, do not edit): `app.js`, `administracija.blade.php`, `administracija.css`, `vite.config.js`.
