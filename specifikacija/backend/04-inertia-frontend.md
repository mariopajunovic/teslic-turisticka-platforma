# 04 — Inertia + Vue front (migracija postojećeg fronta)

> Postojeći `frontend/` (Vue 3 SPA) se **ne prepisuje** — seli se u Laravel/Inertia uz **maksimalan reuse** komponenti.
> Princip: backend se prilagođava obliku podataka koji komponente već očekuju (`services/api.js` ugovor), pa je promjena minimalna.

## Šta se mijenja, a šta ostaje

| Sloj | Sada (SPA) | Poslije (Inertia) |
|------|------------|-------------------|
| Komponente `base/layout/cards/common/map/calendar/forms/account` | `frontend/src/components` | **1:1** u `resources/js/components` |
| Stranice | `src/views/*.vue` | `resources/js/Pages/*.vue` (Inertia page) |
| Routing | `vue-router` | **server rute** (`web.php`) + Inertia; router se uklanja |
| Navigacija (`RouterLink`) | vue-router | Inertia `<Link>` (tanak wrapper, isti API) |
| Podaci | `services/api.js` (mock JSON) | **Inertia props** iz kontrolera (pravi podaci) |
| `useFetch` composable | fetch mock | uglavnom nepotreban (podaci u props); ostaje za lazy/akcije |
| State (Pinia) | consent, UI | ostaje (consent, UI, filteri) |
| Tokeni/Tailwind | `assets/main.css @theme` | **isto**, neizmijenjeno |
| Header/Footer izvor | `constants/navigation.js` | **Inertia shared** (`menus`, `settings`) iz baze |

## Mapiranje view → Inertia stranica/kontroler

| Ruta | Inertia Page | Kontroler vraća props |
|------|--------------|------------------------|
| `/` | `Pages/Home` (ili `PageRenderer`) | blokovi početne + dinamički listovi |
| `/domace-je-najbolje` | `Pages/LocalListing` | `business[]` + filteri + kategorije |
| `/domace-je-najbolje/{slug}` | `Pages/BusinessProfile` | `business` + related + place |
| `/turizam`, `/turizam/{slug}` | `Pages/TourismListing` / `LocationDetail` | `location[]` / `location` |
| `/dogadjaji`, `/dogadjaji/{slug}` | `Pages/Events` / `EventDetail` | `event[]` (+kalendar) / `event` |
| `/oglasi`, `/oglasi/{slug}` | `Pages/AdsListing` / `AdDetail` | `ad[]` / `ad` |
| `/mapa` | `Pages/Map` | `places[]` + filteri |
| `/price`, `/price/{slug}` | `Pages/StoriesListing` / `StoryDetail` | `story[]` / `story` |
| `/pridruzi-se`, `/.../biznis`, `/.../autor` | `Pages/JoinHub` / `RegisterBusiness` / `RegisterAuthor` | forme |
| `/kontakt` | `Pages/Contact` | forma |
| `/{slug}` (CMS) | `Pages/PageRenderer` | `page` + `blocks[]` |
| pravne | `Pages/Legal` | `page` (iz CMS-a/settings) |

> Listinzi i dalje mogu raditi client-side filtriranje nad dostavljenim setom, ili server-side preko query parametara (`?kategorija=`) — postojeća logika filtera u komponentama se zadržava.

## Korisnički paneli (biznis/autor) — Inertia, role-based (📌 spec. 13)
- Postojeći `account/*` views (`BiznisProfilView`, `BiznisObjaveView`, `BiznisOglasiView`, `BiznisMedijiView`, `BiznisPostavkeView`, `AutorPriceView`, `AutorNovaPricaView`, `AutorProfilView`, `AutorPostavkeView`) + `AccountLayout` ostaju **1:1**.
- Rute `/nalog/...` pod `auth` middleware (web guard) + provjera uloge (biznis vs autor).
- Akcije: kreiranje/uređivanje nacrta, upload medija, **„Sačuvaj nacrt" / „Pošalji na odobrenje"** → zovu workflow Action-e; statusi i razlozi odbijanja se prikazuju iz backend-a.
- Korisnik vidi **isključivo svoj** sadržaj (Policy `owner`), bez dugmeta „Objavi".

## Forme i validacija
- Forme (`forms/*`) šalju Inertia `useForm().post(...)`; validacija u Laravel **FormRequest** (greške se vraćaju u `errors` → postojeći `FormField` prikaz).
- **CAPTCHA** na svim javnim formama (kontakt, registracija biznis/autor, upit biznisu) — server-side verifikacija (📌 TS 6, spec. 15).
- Stanja (slanje/uspjeh/greška) već postoje (`BaseAlert`, `FormCaptcha`).

## Bootstrap
- `resources/js/app.js`: Inertia `createInertiaApp` + Pinia + global registracija (BaseIcon i sl.) + Inertia `<Link>` wrapper umjesto `RouterLink`.
- `vite.config.js`: Laravel Vite plugin + `@vitejs/plugin-vue` + Tailwind v4; alias `@` → `resources/js`.
- SSR (opciono, faza QA) radi SEO-a javnih stranica.

## Migracioni zahvati (mehanički, mali)
1. Zamijeniti `RouterLink`/`router-link` → Inertia `Link`; `useRoute().params` → Inertia `page props`.
2. Zamijeniti `useFetch(api.list/get)` → čitanje iz `props` (gdje su podaci već dostavljeni).
3. `constants/navigation.js` → fallback; primarni izvor su Inertia shared `menus`/`settings`.
4. Ukloniti `vue-router` i Vercel `middleware.js` (zamjenjuje Laravel auth).

## 🔗 Veze
[Arhitektura](00-arhitektura-i-tech-stack.md) · [CMS/blokovi](03-cms-modularnost.md) · [Auth/uloge](05-auth-uloge-sigurnost.md) · [Frontend plan](../frontend/00-PLAN-RADA.md) · [Komponente](../frontend/01-KOMPONENTE.md)
</content>
