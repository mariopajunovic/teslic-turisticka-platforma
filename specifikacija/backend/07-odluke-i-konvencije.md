# 07 — Potvrđene odluke, konvencije i dev okruženje

> Ž?ivi dokument. Bilježi konkretne odluke donesene tokom izrade (override generičkih opcija iz 00–06).

## Potvrđene tehnološke odluke
| Stavka | Odluka |
|--------|--------|
| Laravel | **13.x** (13.16+) |
| PHP | 8.4 (Sail image) |
| Admin panel | **Filament v5** |
| Front | **Inertia v3 + Vue 3** (reuse `frontend/` komponenti) |
| **SSR** | **DA** — Inertia SSR za javne stranice (SEO) |
| Baza | **MySQL** (`teslic`) |
| Dev okruženje | **Docker + Laravel Sail** (mysql, redis) |
| Brend boja | **teal `#0E8275`** (potvrđeno; ne `#00529C`) |
| Mediji iz `frontend/` | **pokazni/placeholder** — prave materijale ubacuje naručilac kasnije |
| Demo domen / podaci | **`komteldoo.com`** (sve seed e-mail adrese) |

## Otvoreno
- **Hosting**: cPanel ili VPS — još neodlučeno (utiče na deploy/B8; Sail je samo dev). Produkcija mora podržati PHP 8.3+, MySQL, Node build, SSR Node proces (ili SSR preko `php artisan inertia:start-ssr`).

## Dev pristup (pokazno okruženje)
- **Glavni dev/admin nalog:** `mario@komteldoo.com` / `mario123` (Filament `/admin`).
- Seed korisnici (biznis/autor) i sav demo sadržaj koriste `@komteldoo.com` domen.
- ⚠️ Lozinke su **samo za pokazno okruženje** — promijeniti pri primopredaji (📌 TS 15).

## Pokretanje (Sail)
```bash
# prvi put / nakon izmjene .env portova
export WWWUSER=$(id -u) WWWGROUP=$(id -g)
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev        # Vite (HMR)
# SSR (kad se uključi): ./vendor/bin/sail artisan inertia:start-ssr
```
- **Sajt:** http://localhost:8088 · **Admin:** http://localhost:8088/admin
- **Portovi (host)**: app `8088→80`, Vite `5174`, MySQL `3306`, Redis `6380→6379`.
  (Promijenjeni jer su 80/8080/8000/5173/6379 zauzeti na dev mašini; vidi `.env`: `APP_PORT`, `VITE_PORT`, `FORWARD_REDIS_PORT`.)

## Konvencije koda
- **Jezik sadržaja**: ijekavica; lokalni primjeri (Teslić, Banja Vrućica, Borja, Očauš).
- **Nazivi**: modeli/klase engleski (`Business`, `Story`), korisnički tekst i rute na lokalnom (`/domace-je-najbolje`).
- **Design tokeni**: Tailwind v4 `@theme`, prenose se iz `frontend/src/assets/main.css` bez izmjena; boje/razmaci samo preko tokena.
- **Workflow prelazi**: isključivo kroz Action klase (dijele ih Inertia i Filament); svaki se loguje.
- **Vlasništvo sadržaja**: Policy provjera `user_id`; korisnik nikad ne vidi tuđe.

## Dnevnik napretka
- **B0 ✅** Laravel 13 + Sail + MySQL + Filament v5 (admin guard) + Inertia/Vue/Tailwind; build prolazi; `/` i `/admin/login` → 200.
- **B1 (djelimično)** odvojen `admin` guard + `Admin` model + dev super-admin; `users` dobio `role/status/telefon/bio` + spatie `HasRoles`; demo `biznis@`/`autor@komteldoo.com`. (Fortify login za korisnike = B6.)
- **B2 (Biznis slice)** paketi: spatie permission/medialibrary/sluggable/activitylog/settings, Fortify, Filament media plugin. Modeli `Category`, `Business` (HasSlug, media kolekcije `naslovna`/`galerija`, status enum). Seed iz `database/data/*.json` (kopija mock JSON-a): 7 kategorija, 6 biznisa.
- **B3 (Biznis slice)** Filament `BusinessResource` (forma: kategorija/vlasnik/kontakt fieldset/mapa/mediji/status; tabela: badge status + filteri + akcije „Odobri i objavi"/„Vrati uz razlog" → `rejection_reason`) i `CategoryResource`. 5 smoke testova (`AdminPanelTest`) zeleno.
- **B3 ✅ (svi entiteti)** Filament resursi za Lokalitet/Događaj/Oglas/Priča/Vijest po Biznis šablonu (status workflow, media, filteri). Seed: lokaliteti 4, događaji 4, oglasi 4, priče 4, vijesti 2, kategorije 12. **16/16 smoke testova** (lista+forma za svih 7 resursa) zeleno.
- **B-front temelj ✅** `frontend/src` portan u `backend/resources/js` (Inertia): 57 komponenti, 32 Pages, Pinia registriran, tokeni u `resources/css/app.css`, `RouterLink`→`Link`. `npm run build` zelen. Detalj-stranice i listinzi još koriste mock `api.js` (data-wiring = B4).
- **B4 ✅ (5 sadržajnih tipova)** Inertia kontroleri + API Resource transformeri (oblik 1:1 s mock JSON-om) za Biznise/Lokalitete/Događaje/Oglase/Priče — listing + detalj na **pravim podacima** iz baze. Vue stranice čitaju Inertia props (SSR-ready) umjesto mock `api.js`. Rute u `web.php`. **30/30 testova** (admin + javni front + 404) zeleno.
- **Mapa ✅** `MapController` agregira objavljene biznise/lokalitete/događaje s koordinatama → `Map.vue` sklopljena od postojećih map-komponenti (Leaflet/OSM, cluster, filter, popup s linkom na detalj). `/mapa` testiran.
- **B5.1 ✅ (settings + meniji + dinamičan header/footer)** Tabele `menus`/`menu_items` + spatie `SiteSettings`; seed reprodukuje postojeću navigaciju 1:1. `SiteData::shared()` → Inertia shared `site` (mainNav/secondaryNav/footerLinks/kontakt/postavke). Header/footer/drawer/Contact prebačeni na `useSite()` composable (fallback na konstante). Filament: `MenuResource` + `ItemsRelationManager` (upravljanje navigacijom/footerom) i `ManageSiteSettings` stranica (brend/kontakt/footer/social/partneri). **34/34 testova** zeleno; meni i brend iz baze potvrđeni u HTML-u.
- **Popravka praznog ekrana (2026-06-24):** tri uzroka — (1) nedostajao globalni layout → `Layouts/PublicLayout.vue` (header/footer/cookie) kao default layout u `app.js`/`ssr.js` (osim `account/*`); (2) Inertia je serijalizovao `Resource::collection()` kao `{data:[...]}` → `JsonResource::withoutWrapping()` u `AppServiceProvider`; (3) SSR padao na browser globalima → Leaflet lazy u `onMounted`, `markerIcon(L,…)`, `consent` store guard za `localStorage`. SSR sada renderuje cijelu stranicu na svim javnim rutama; graceful fallback na klijent ako SSR server stane. Vidi [[inertia-ssr-gotchas]].
- **B5.2 ✅ (block-builder)** Tabela `pages` (blokovi kao JSON `content`) + `Page` model. Filament `PageResource` s **Builder** poljem — tipovi blokova: `hero`, `section_header`, `rich_text`, `card_grid` (ž-ivi izvor: business/location/event/ad/story + kategorija/limit/kolone), `cta`. Frontend: `components/blocks/Block*.vue` + `Pages/PageRenderer.vue` (registar tip→komponenta); `PageController` razrješava `card_grid` na prave podatke server-side; catch-all `/{slug}` (izuzima admin/build/storage). Demo CMS stranica **`/o-projektu`** (hero+tekst+mreža biznisa+CTA) renderuje preko SSR-a bez grešaka. **37/37 testova**.
- **B5.2+ ✅ (prošireni blokovi + stranice od blokova)** Dodato još 5 tipova blokova → ukupno **11**: `hero, section_header, rich_text, card_grid, cta, category_nav, gallery, video, map, spacer`. `map` i `card_grid` povlače žive podatke (`MapPoints` servis dijele MapController i PageController). **Početna `/` je sada CMS stranica od blokova** (`pocetna` seed: hero+kategorije+4 mreže+mapa+CTA), uz fallback na `Home.vue` ako stranica ne postoji. Blokovima napravljene i: `o-projektu`, `politika-privatnosti`, `politika-kolacica`, `uslovi-koristenja`. Rute dodate za `/kontakt`, `/pridruzi-se`(+biznis/autor), `/prijava`, `/registracija`, `/zaboravljena-lozinka` (renderuju postojeće Vue stranice; forme se vežu u B6/B7). **40/40 testova**, 0 SSR grešaka.
  - **Ostaju namjenske (ne blokovi):** listinzi i detalji (data-aplikacije s filterima/paginacijom), te forme (Kontakt/registracija) — vežu se u B6/B7.
- **B6.1 ✅ (auth temelj — Fortify + Inertia)** `users` guard (web). Registracija (biznis/autor) → status **na_odobrenju**, bez auto-logina, poruka „čeka odobrenje" (`RegisterResponse`); `CreateNewUser` upisuje role/telefon/status. Prijava preko `Fortify::authenticateUsing` blokira **na_odobrenju** i **blokiran** uz jasne poruke; rate-limit 5/min. Odjava. Inertia shared `auth.user` + `flash` → header prikazuje ime + „Odjava" (ili Prijava/Pridruži se). Izgrađene prave forme: `Login`, `RegisterBusiness`, `RegisterAuthor` (bile placeholderi). Fortify config: `views=false` (koriste se naše Serbian rute), bez 2FA/passkeys za korisnike. **45/45 testova** (5 novih auth). Demo `biznis@`/`autor@komteldoo.com` su `aktivan` → mogu se prijaviti.
- **B6.2 ✅ (korisnički paneli — infrastruktura + autor tok)** `EnsureRole` middleware (alias `role`) + `redirectGuestsTo('/prijava')`. Sve `/nalog/...` rute (autor + biznis) pod `auth`+`role` (oba panela navigabilna, bez 404). **Autor→Priče vezano end-to-end:** `AutorStoryController` (lista vlastitih priča sa status-badge i razlogom odbijanja; kreiranje/izmjena; „Sačuvaj nacrt"/„Pošalji na odobrenje" → status; ownership 403 na tuđe). `AutorPrice.vue`+`AutorNovaPrica.vue` vezane (`useForm`), `ContentStatus::badge()` → PostRow varijanta. `AccountLayout` odjava + inicijali iz `auth.user`. **50/50 testova** (5 novih: gost→prijava, role 403, slanje→poslano, ownership).
  - **Renderuju (mock, navigabilno, još nevezano):** `BiznisProfil/Objave/Oglasi/Mediji/Postavke`, `AutorProfil/Postavke` — vežu se istim obrascem (controller per resurs).
- **B6.2 biznis tok ✅** `BiznisProfilController` (uredi vlastiti profil + nacrt/pošalji) i `BiznisAdController` (oglasi: lista/kreiranje/izmjena/slanje, ownership 403). `BiznisProfil.vue`, `BiznisOglasi.vue`, nova `BiznisOglasForm.vue` vezane. Renderuju (još nevezane): BiznisObjave/Mediji, Autor/Biznis Postavke.
- **B7 ✅ (sigurnost — jezgro)** Filament **`UserResource`** (grupa Korisnici): odobravanje naloga (na_odobrenju→aktivan), blokada/odblokada, uloge — zatvara petlju registracije. **Activity log** (spatie; u ovoj verziji `Models\Concerns\LogsActivity` + `Support\LogOptions`, `dontLogEmptyChanges`): `TracksStatus` trait na Business/Ad/Story (logује promjene `status`/`published_at`), + logovanje prijava/odjava (Login/Logout event listeneri) → read-only **`ActivityResource`** (grupa Sistem). **CAPTCHA** (`App\Rules\Captcha`, Cloudflare Turnstile, dev-skippable ako nema `TURNSTILE_SECRET`) na kontakt i registraciji; **rate-limit** `throttle:5,1` na kontakt (login već 5/min). `ContactController` + vezana Kontakt forma. **56/56 testova** (biznis profil/oglas slanje, kontakt, users/activity resursi). 0 SSR grešaka.
- **B6/B7 dovršeno ✅ (preostale stranice + obavijesti + mediji)**
  - **E-mail obavijesti:** `ContentStatusChanged` notifikacija šalje se vlasniku pri promjeni statusa na **objavljeno/odbijeno** (okidač u `TracksStatus::bootTracksStatus` na `updated`); u dev-u `mail=log`. Zatvara informisanje korisnika u workflow-u.
  - **Account settings (Postavke):** `SettingsPanel` vezan na Fortify — izmjena imena/e-maila (`/user/profile-information`) i lozinke (`/user/password`); koristi ga i biznis i autor panel.
  - **Autor profil:** ime + bio + **avatar upload** (`User` sad `HasMedia`, kolekcija `avatar`); `AutorProfilController`.
  - **Biznis mediji:** `BiznisMediController` — upload **naslovne** + **galerije** + brisanje; `BiznisMediji.vue` funkcionalan (file inputi, preview, delete). `storage:link` postavljen.
  - **Biznis objave:** `BiznisProfilController@objave` — pregled profila + oglasa sa statusima/razlozima.
  - Sve account stranice sada vezane (Profil/Objave/Oglasi/Mediji/Postavke · Price/NovaPrica/Profil/Postavke). **59/59 testova**.
  - **Otvoreno (🟡):** produkcijski CAPTCHA ključevi (`TURNSTILE_SECRET/SITEKEY`) + SMTP mail; causer za admin-akcije u logu (admin guard); 2FA za korisnike (admini je već imaju); priprema za deploy (cPanel/VPS).
- **Ispravka biznis panela ✅ (model je bio pogrešno postavljen):** „Moj profil" je bio biznis-profil, „Moje objave" lista biznisa, klik vraćao na profil, nije bilo više objava. Ispravljeno:
  - **Moj profil** = podaci o **nalogu** (`BiznisProfilController` ažurira `User`: ime, telefon, bio, avatar; e-mail read-only — mijenja se u Postavkama).
  - **Moje objave** = **više biznis objava** (`BiznisObjaveController`: Business CRUD — index/create/store/edit/update + brisanje medija); „Nova objava"; klik → uređivanje **te** objave; status/razlog po objavi.
  - **`BiznisObjavaForm.vue`** = puna forma (naziv, kategorija, opis, kontakt, lokacija, lat/lng) + **mediji po objavi** (naslovna + galerija upload/delete).
  - Zaseban „Mediji" tab uklonjen (mediji su sad u svakoj objavi); `BiznisMediController` obrisan. **60/60 testova**.
- **Sigurnosne/arhitektonske ispravke ✅ (3 prijavljena gapa):**
  1. **2FA za admine (TS 6) — sada postoji i obavezno je.** Filament v5 ugrađeni **MFA** (`AppAuthentication` TOTP, `recoverable`), `multiFactorAuthentication(..., isRequired: true)` → admin **mora** postaviti 2FA. `Admin` implementira `HasAppAuthentication(+Recovery)`; kolone `app_authentication_secret`/`app_authentication_recovery_codes` na **`admins`**. Pogrešne `two_factor_*` kolone **uklonjene s `users`** (i nekorištene s `admins`). (Fortify 2FA je za web guard; panel koristi Filament-native MFA.)
  2. **Uloge/permisije se realno koriste.** `Admin` `use HasRoles` (guard `admin`). `RolePermissionSeeder`: permisije (sadržaj/korisnici/stranice/postavke/logovi) + role **administrator** (sve) i **urednik** (sadržaj+logovi); dodijeljene (`syncRoles`) — mario=super+administrator, demo `urednik@komteldoo.com`. `Gate::before` → super bypass. `canAccessPanel` = super ili ima ulogu. **`canAccess()`** na admin-only resursima (Korisnici/Stranice/Meniji/Postavke) → urednik ih ne vidi; sadržaj/logove vide oba. Test dokazuje razliku.
  3. **Mrtvi `frontend/` uklonjen** (+ `middleware.js`/`vercel.json` koji su bili unutar njega) — kanonski front je `backend/resources/js`; provjereno bez zavisnosti; seed podaci već u `backend/database/data`.
  - **61/61 testova** (uklj. urednik 403 na Korisnike, 200 na Sadržaj).
- **Stanje:** B0–B7 kompletni + sigurnosne ispravke. Platforma radi end-to-end; workflow odobravanja zatvoren s e-mail obavijestima; admini s obaveznom 2FA i razdvojenim ulogama; jedan kanonski frontend.
- **Proces:** bez subagenata i bez `git commit` (korisnikova instrukcija).

## 🔗 Veze
[README](README.md) · [Arhitektura](00-arhitektura-i-tech-stack.md) · [Plan po fazama](06-plan-po-fazama.md) · [Auth/sigurnost](05-auth-uloge-sigurnost.md)
</content>
