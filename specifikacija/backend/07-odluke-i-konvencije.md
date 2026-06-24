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
- **Sljedeće:** Mapa (places endpoint), početna i header/footer iz baze = CMS B5; Fortify korisnički login + nalozi B6. Statične stranice (O projektu/Kontakt/Pridruži se/Legal) i Home zasad statične do B5.
- **Proces:** bez subagenata i bez `git commit` (korisnikova instrukcija).

## 🔗 Veze
[README](README.md) · [Arhitektura](00-arhitektura-i-tech-stack.md) · [Plan po fazama](06-plan-po-fazama.md) · [Auth/sigurnost](05-auth-uloge-sigurnost.md)
</content>
