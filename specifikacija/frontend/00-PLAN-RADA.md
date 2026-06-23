# Plan rada — Frontend (Vue.js) za platformu TO Teslić

> Agent zadužen za **planiranje i izradu frontenda**. Tehnologija: **čisti Vue.js** (Vue 3, bez Nuxt-a).
> Ulazni materijal: `specifikacija/` (sadržaj, stranice, tokeni, komponente) + `pencil/*.pen` (vizuelni dizajn).
> **Lokacije:** ovaj plan živi u `specifikacija/frontend/`; **Vue projekat je u `frontend/`** (u korijenu projekta). Pokretanje: Node preko `nvm use node` (trenutno v26.x).
> Ovaj dokument je nadređeni plan. Detalji: [`01-KOMPONENTE.md`](01-KOMPONENTE.md) (mapiranje dizajn → Vue komponente) i [`02-TASKOVI.md`](02-TASKOVI.md) (taskovi po fazama).

---

## 1. Cilj

Izgraditi **javni dio platforme** (10 stranica + globalni header/footer) kao Vue 3 aplikaciju, 1:1 prema usvojenom Pencil dizajnu i specifikaciji. Admin panel, prijava i korisnički dashboardi su **izvan opsega** (vidi `specifikacija/ui-workflow/README.md`).

Opseg stranica (javne):
`01 Početna · 02 O projektu · 03 Domaće je najbolje (+profil biznisa) · 04 Turizam (+detalj lokaliteta) · 05 Događaji (lista/kalendar/detalj) · 06 Oglasi (+detalj) · 07 Mapa · 08 Priče (+detalj) · 09 Pridruži se (forme) · 10 Kontakt` + pravne stranice iz footera.

---

## 2. Tehnološke odluke

| Oblast | Izbor | Razlog |
|--------|-------|--------|
| Framework | **Vue 3** (Composition API, `<script setup>`, SFC) | Zahtjev: čisti Vue. |
| Build | **Vite** | Standard za Vue 3, brz dev/HMR. |
| Routing | **Vue Router 4** | Višestranична platforma s detalj-rutama. |
| State | **Pinia** (minimalno — UI stanje, filteri, cookie consent) | Lagan, zvanični Vue store. Izbjegavati pretjeranu upotrebu. |
| Stilizacija | **Tailwind CSS v4** (`@tailwindcss/vite`) + `@theme` design tokeni | Standard u Vue/Vite. Tokeni iz `00-design-tokens.md` mapirani 1:1 u `@theme` (`bg-primary`, `text-heading`, `rounded-md`…). Utility-first; `scoped` SFC stilovi samo izuzetno. |
| Ikone | **lucide-vue-next** | Dizajn već koristi `lucide` ikone (vidi Foundations). |
| Mapa | **Leaflet** (+ marker cluster) | Open-source, bez API ključa, pokriva pinove/clustere/popup. |
| Font | **Inter** (`font-sans` i `font-heading`) | Token iz dizajna. Self-host (woff2) radi performansi i privatnosti. |
| Sadržaj/jezik | **Ijekavica**, lokalni primjeri (Teslić, Banja Vrućica, Borja, Očauš) | Pravilo konzistentnosti. |
| Podaci | **Servisni sloj + mock JSON** danas → lako zamjenjiv pravim API-jem | Backend još nije gotov; UI ne smije biti vezan za izvor. |

> Tailwind: odabran kao osnova (changelog već navodi da su tokeni „mapirani 1:1 na Tailwind tokene”). Tokeni se definišu u `src/assets/main.css` kroz `@theme` blok (Tailwind v4), pa su sve dizajn-vrijednosti dostupne i kao utility klase i kao CSS varijable (`var(--color-primary)`).

---

## 3. Arhitektura i struktura projekta

```
frontend/                      Vue projekat (scaffold: create-vue, Vite + Router + Pinia + ESLint/Prettier)
├── index.html
├── vite.config.js
├── package.json
└── src/
        ├── main.js            bootstrap (app, router, pinia)
        ├── App.vue            app shell (Header + <RouterView> + Footer + CookieBanner)
        ├── router/
        │   └── index.js       sve rute (vidi §4)
        ├── assets/
        │   ├── styles/
        │   │   ├── tokens.css     CSS varijable iz design tokena
        │   │   ├── base.css       reset, tipografija, fokus-ring, util klase
        │   │   └── index.css
        │   ├── fonts/            Inter woff2
        │   └── images/
        ├── components/
        │   ├── base/          atomi (BaseButton, BaseChip, BaseBadge, polja…)
        │   ├── layout/        AppHeader, AppFooter, NavDropdown, MobileDrawer, AppContainer, CardGrid, CookieBanner
        │   ├── cards/         BusinessCard, EventCard, AdCard, StoryCard, StoryFeaturedCard, LocationCard
        │   ├── common/        Hero, FilterBar, SearchInput, Gallery, Lightbox, InfoPanel, MiniMap, RelatedContent, Pagination, EmptyState, Skeleton, CTASection, Breadcrumb, Stepper, SegmentControl, AuthorBlock
        │   ├── map/           MapInteractive, MapPin, MapPopup, MapFilterPanel, ResultsList
        │   ├── calendar/      EventCalendar
        │   └── forms/         FormContainer, BusinessForm, AuthorForm, FileUpload
        ├── views/            stranice (route-level): HomeView, AboutView, …
        ├── composables/      useFilters, useFetch, useBreakpoint, useCookieConsent, useLightbox…
        ├── services/         api.js (apstrakcija) + mock fetchers
        ├── data/             mock JSON (biznisi, događaji, priče, oglasi, lokaliteti)
        ├── stores/           pinia (ui.js, filters.js, consent.js)
        └── constants/        kategorije, ikone kategorija, nav-struktura
```

**Atomic-design pristup**: `base` (atomi) → `cards`/`common` (molekule/organizmi) → `views` (stranice). Svaka Vue komponenta odgovara imenovanju iz Foundations (`Komponenta/Varijanta` → `Komponenta` s `variant` prop-om).

---

## 4. Rutiranje (Vue Router)

| Ruta | View | Napomena |
|------|------|----------|
| `/` | HomeView | Početna (bez breadcrumba) |
| `/o-projektu` | AboutView | |
| `/domace-je-najbolje` | LocalListingView | listing + filteri + podsekcije (zanat/hrana/usluge) |
| `/domace-je-najbolje/:slug` | BusinessProfileView | profil biznisa |
| `/turizam` | TourismListingView | 4 podsekcije + listing |
| `/turizam/:slug` | LocationDetailView | detalj lokaliteta |
| `/dogadjaji` | EventsView | query `?prikaz=lista|kalendar` |
| `/dogadjaji/:slug` | EventDetailView | |
| `/oglasi` | AdsListingView | |
| `/oglasi/:slug` | AdDetailView | |
| `/mapa` | MapView | query za fokus na entitet/filter |
| `/price` | StoriesListingView | |
| `/price/:slug` | StoryDetailView | |
| `/pridruzi-se` | JoinHubView | hub |
| `/pridruzi-se/biznis` | RegisterBusinessView | forma |
| `/pridruzi-se/autor` | RegisterAuthorView | forma |
| `/kontakt` | ContactView | |
| `/politika-privatnosti`, `/politika-kolacica`, `/uslovi-koristenja` | LegalView | iz footera |
| `*` (catch-all) | NotFoundView | 404 |

- Sticky header je dio `App.vue` (van `RouterView`).
- `scrollBehavior`: scroll na vrh pri promjeni rute (osim sačuvane pozicije na back).
- Breadcrumb na svim stranicama osim Početne.

---

## 5. Design tokeni → Tailwind `@theme` ✅ (postavljeno)

Sve vrijednosti iz `specifikacija/ui-workflow/00-design-tokens.md` (potvrđene iz `00_Foundations.pen`) definisane su u **`frontend/src/assets/main.css`** kroz Tailwind v4 `@theme` blok. Time su dostupne istovremeno kao **utility klase** (`bg-primary`, `text-heading`, `border-border`, `rounded-md`, `shadow-md`, `font-heading`) i kao **CSS varijable** (`var(--color-primary)`). Komponente koriste isključivo tokene — bez „magičnih” boja/razmaka.

```css
@import 'tailwindcss';
@theme {
  --color-primary:#0e8275; --color-primary-dark:#0a645a; /* … */
  --color-accent:#e88828; --color-heading:#12151c; --color-border:#dce0e6; /* … */
  --radius-sm:6px; --radius-md:10px; --radius-lg:16px; --radius-pill:999px;
  --shadow-sm:0 1px 2px rgb(0 0 0/.06); /* md, lg … */
  --font-sans:'Inter',…; --font-heading:'Inter',…;
}
```

Razmaci (8px skala) i breakpointi koriste Tailwind default skalu (`p-4`=16px, `p-6`=24px, `p-16`=64px), što pokriva tokene. Fokus-ring (`:focus-visible`, primary) i osnovne tipografske osobine u `@layer base`.

Stanja interaktivnih elemenata (obavezno): `default · hover · focus (vidljiv ring u primary) · pressed · disabled`. Dodirne mete min. 44×44px.

---

## 6. Šta se ponavlja (ključni nalaz analize)

Iz `.pen` fajlova i recepata jasno se izdvajaju **obrasci koji se ponavljaju kroz gotovo sve stranice** — to su prioritetne, jednom-napravljene komponente:

1. **Globalni okvir** — `Header` (desktop + mobilni drawer, dropdown nav, sticky) i `Footer` na **svakoj** stranici; `Breadcrumb` na svim osim Početne; `CookieBanner`.
2. **Kartica + Grid** — listinzi (Domaće, Turizam, Događaji, Oglasi, Priče, Početna) svi koriste isti obrazac: `Grid` (4→2→1) + odgovarajuća `Kartica/*`. Sve kartice dijele anatomiju: slika 16:9 · chip kategorije · naslov H3 · opis (truncate) · meta red · opcioni badge.
3. **Filtriranje** — `FilterTraka` (desktop) / `Drawer/Filteri` (mobilni) + `Pretraga` + `Dropdown` se ponavlja na svim listinzima.
4. **Stanja liste** — `Skeleton` (učitavanje), `PraznoStanje` (prazno/filtrirano), greška, `Paginacija`/`UcitajJos` — isti set na svakom listingu.
5. **Detalj-obrazac** — `Hero` + dvokolonski layout (glavni sadržaj + `InfoPanel`) + `Galerija`/`Lightbox` + `MiniMapa` + `PovezaniSadrzaj` — identičan kostur na: profil biznisa, detalj lokaliteta, detalj događaja, detalj oglasa, detalj priče.
6. **CTA registracija** — `CTASekcija` (primary pozadina, „Registruj biznis / Postani autor”) ponavlja se na Početnoj, O projektu, Pridruži se.
7. **Forme** — `Forma` + `Polje/*` + `Checkbox` + `Captcha` + `Alert/PorukaStanja` (uspjeh/greška) na Pridruži se i u modalima upita.
8. **Tokeni** — boje/razmaci/radijusi/tipografija identični svuda (već centralizovani kao Pencil varijable).

Zaključak: ~30 reusable komponenti pokriva svih 10 stranica. Detaljan inventar i mapiranje: [`01-KOMPONENTE.md`](01-KOMPONENTE.md).

---

## 7. Faze rada (redoslijed)

> Redoslijed je „odozdo nagore”: prvo temelji (tokeni, atomi, layout, kartice), pa kompozitne komponente, pa stranice. Time se izbjegava dupliranje i osigurava konzistentnost — tačno kao što Pencil prvo radi `00_Foundations`.

| Faza | Naziv | Sadržaj (kratko) |
|------|-------|------------------|
| **F0** | Setup | Vite + Vue 3 + Router + Pinia, struktura foldera, lint/format, Inter font, base reset. |
| **F1** | Tokeni i baza | `tokens.css`, `base.css`, `AppContainer`, `CardGrid`, Icon wrapper, util klase, fokus-ring. |
| **F2** | Atomi | BaseButton (5 varijanti, 2 veličine, stanja), BaseChip (3), BaseBadge (5), polja (Tekst/Select/Textarea/Checkbox), Captcha, Alert. |
| **F3** | Layout / shell | AppHeader (desktop + mobile drawer + dropdown + sticky + search), AppFooter, CookieBanner, App.vue shell. |
| **F4** | Kartice + stanja liste | 6 tipova kartica, CardGrid responsivnost, Skeleton, EmptyState, Pagination/LoadMore, Breadcrumb. |
| **F5** | Kompozitne komponente | Hero (2 var.), FilterBar (+mobile Drawer), SearchInput + globalni search overlay, Gallery + Lightbox + VideoPlayer, InfoPanel, MiniMap, RelatedContent, CTASection, Stepper, SegmentControl, AuthorBlock. |
| **F6** | Mapa | Leaflet MapInteractive, MapPin (ikone po kategoriji), Cluster, MapPopup, MapFilterPanel, ResultsList; mobilni bottom-sheet. |
| **F7** | Kalendar | EventCalendar (mjesečna mreža, tačke na danima, klik→lista). |
| **F8** | Stranice — listinzi i statične | Početna (prva), O projektu, Kontakt, pa listinzi: Domaće, Turizam, Događaji, Oglasi, Priče. |
| **F9** | Stranice — detalji | Profil biznisa, detalj lokaliteta, detalj događaja, detalj oglasa, detalj priče. |
| **F10** | Forme | Pridruži se hub + RegisterBusiness + RegisterAuthor + validacija + stanja (greška/slanje/uspjeh) + FileUpload. |
| **F11** | Podatkovni sloj | `services/api.js` apstrakcija + mock JSON + composable `useFetch`; ubaciti loading/empty/error svuda. |
| **F12** | QA / polish | Responsive provjera (375/768/1440), a11y (AA kontrast, fokus, tastatura, alt), performanse (lazy slike, code-split ruta), 404, meta/SEO osnovno. |

Detaljni checkbox-taskovi po fazama: [`02-TASKOVI.md`](02-TASKOVI.md).

---

## 8. Definicija gotovog (DoD) po komponenti / stranici

**Komponenta:**
- [ ] Koristi isključivo design tokene (CSS varijable).
- [ ] Sve varijante i stanja iz dizajna (`hover/focus/pressed/disabled`, te list-stanja gdje važi).
- [ ] Props/emits dokumentovani; pristupačnost (ARIA, fokus, 44px meta).
- [ ] Responsivna (mobilni 375 + desktop 1440).

**Stranica:**
- [ ] Header + Footer + (Breadcrumb osim Početne).
- [ ] Svi blokovi iz recepta, redom; samo postojeće komponente.
- [ ] Stanja: učitavanje (Skeleton), prazno, greška (gdje važi).
- [ ] Desktop + Mobile + (Tablet gdje je relevantno).
- [ ] Sadržaj ijekavica, lokalni primjeri.

---

## 9. Otvorena pitanja za naručioca / tim

1. **Brend boja** — dizajn je na teal `#0E8275`; tender je referencirao `#00529C`. Treba potvrda (vidi napomenu u tokenima).
2. **Usvojeni koncept Početne** — changelog kaže usvojen **Koncept A** („Klasičan/info”), ali je produkcijski `01_Pocetna.pen` obrisan (backup u `_arhiva/`). Frontend Početne radimo prema Konceptu A iz arhive — potvrditi.
3. **Logo** — trenutno tekst „teslić” (teal). Postoji li finalni logo fajl za header/footer?
4. **Izvor podataka / API** — postoji li backend ugovor (REST/GraphQL) ili gradimo na mock-u dok ne stigne?
5. **Mapa** — Leaflet (OSM) prihvatljiv, ili se traži Google Maps?
6. **Višejezičnost** — samo ijekavica, ili je predviđena lokalizacija (npr. EN za turiste)?
