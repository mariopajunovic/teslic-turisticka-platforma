# Detaljni taskovi — Frontend (Vue.js)

> Checkbox-taskovi po fazama iz [`00-PLAN-RADA.md`](00-PLAN-RADA.md) §7. Komponente: [`01-KOMPONENTE.md`](01-KOMPONENTE.md).
> Redoslijed je obavezujući za F0–F4 (temelji); F5–F7 se mogu paralelizovati; F8–F10 zavise od prethodnih.

---

## F0 — Setup projekta
- [x] `create-vue` scaffold u `frontend/` (Vue 3 + Vite + Router + Pinia + ESLint/Prettier).
- [x] Node preko nvm — najnoviji (`nvm use node`, v26.x) + `default` alias.
- [x] Instaliraj: `lucide-vue-next`, `leaflet`, `leaflet.markercluster` (router/pinia već iz scaffolda).
- [x] **Tailwind CSS v4** + `@tailwindcss/vite` (plugin u `vite.config.js`).
- [x] Skripte iz scaffolda: `dev`, `build`, `preview`, `lint`, `format`.
- [x] Struktura foldera iz plana (§3): `components/{base,layout,cards,common,map,calendar,forms}`, `composables`, `services`, `data`, `constants`.
- [x] Očišćen boilerplate (HelloWorld/TheWelcome/icons/logo, counter store).
- [x] `App.vue` shell (privremeni header/nav + RouterView + footer + CookieBanner) — **pravi Header/Footer u F3**.
- [x] Self-host Inter preko `@fontsource-variable/inter` (import u `main.js`, token `Inter Variable`).
- [x] Router: sve rute (10 stranica + detalji + pravne + `/_dev` + 404), lazy import, `scrollBehavior`.
- [x] Konstante: `navigation.js` (nav + footer + kontakt), `categories.js`; `services/api.js` (apstrakcija nad mock `data/*.json`); `stores/consent.js`.

## F1 — Tokeni i baza
- [x] Design tokeni u `src/assets/main.css` kroz Tailwind `@theme` (boje, radijusi, sjenke, font); fokus-ring + base tipografija u `@layer base`.
- [x] `BaseIcon.vue` (wrapper za lucide) + kurirana mapa ikona u `constants/icons.js` (čuva tree-shaking).
- [x] `AppContainer.vue` (max 1200, padding 24/16) i `CardGrid.vue` (4→2→1, gutter tokeni).
- [x] `useBreakpoint` composable (mobile/tablet/desktop).
- [ ] Util/helper po potrebi (line-clamp za truncate kartica i sl.) — dodaje se uz kartice u F4.

## F2 — Atomi ✅
- [x] `BaseButton` — 5 varijanti, `size` md/sm, ikona L/D, stanja, `to`/`href`/`button`, `block`.
- [x] `BaseChip` — Filter/Kategorija/Uklonjiv (+ `active`, `remove` emit, a11y `aria-pressed`).
- [x] `BaseBadge` — 7 statusnih varijanti (tinted: tačkica + tekst).
- [x] `FormField` / `FormSelect` / `FormTextarea` (+counter) / `FormCheckbox` — `defineModel`, stanja focus/error/disabled, `useId` labele.
- [x] `FormCaptcha` (placeholder), `BaseAlert` (uspjeh/greška/info).
- [x] „Kitchen sink” ruta `/_dev` (`DevView.vue`) — showcase svih atoma.
- [x] Provjera: `npm run build` ✓ i `npm run lint` ✓ prolaze.

## F3 — Layout / shell ✅
- [x] `AppHeader` desktop: logo + nav + `NavDropdown` (Domaće/Turizam/Priče) + pretraga (overlay) + Prijava/Pridruži se; aktivna ruta `primary`.
- [x] Sticky ponašanje (smanjenje visine + `shadow-sm` na skrol).
- [x] `AppHeader` mobilni: logo + pretraga + hamburger → `MobileDrawer` (puna nav s akordeon podsekcijama + Pridruži se/Prijava, scroll-lock).
- [x] `AppFooter` — responzivno (desktop 4 kolone → mobilni stack + 2-kol linkovi, prema `Footer/Mobile` iz 05_Dogadjaji.pen): brend+social, Brzi linkovi, Istraži, Kontakt, traka partnera, pravna traka (`primary-darker`).
- [x] `CookieBanner` + `stores/consent.js` (localStorage), prikaz pri prvom posjetu. *(urađeno u F0)*
- [x] Router `scrollBehavior` + 404 ruta. *(urađeno u F0)*
- [x] `App.vue` prešao s privremenog na prave `AppHeader`/`AppFooter`.
- [ ] (F5) Pravi `SearchInput` + overlay s rezultatima — trenutno placeholder pretraga vodi na `/mapa?q=`.

## F4 — Kartice + stanja liste ✅
- [x] `BusinessCard`, `LocationCard` (reuse + ruta /turizam), `EventCard` (datumski blok + Završeno), `AdCard` (kompaktna + Isteklo), `StoryCard`, `StoryFeaturedCard` (horizontalna, stack na mobilnom).
- [x] `CardImage` (16:10, placeholder, lazy slike, hover zoom); truncate opisa (`line-clamp`), hover `shadow-md`, cijela kartica je RouterLink.
- [x] `Skeleton` (count, animate-pulse), `EmptyState` (ikona+naslov+tekst+CTA slot), `Pagination` (prozor + elipsa, `v-model`), `Breadcrumb`.
- [x] Sve prezentovano na `/_dev` (kartice u `CardGrid`, sva stanja). Build ✓, lint ✓; popravljen header bug (mobilni skrivao desktop CTA).
- [ ] (opc.) `LoadMore` varijanta paginacije — dodati uz listinge u F8 po potrebi.

## F5 — Kompozitne komponente
- [ ] `Hero` — `slika-pozadina` (overlay tekst) i `split` (tekst+slika); mobilni overlay.
- [ ] `FilterBar` (desktop) + `FilterDrawer` (mobilni) + aktivni filteri kao uklonjivi chipovi + „Očisti”.
- [ ] `useFilters` composable (sinhron s URL query).
- [ ] `SearchInput` + globalni search overlay (iz headera).
- [ ] `Gallery` + `Lightbox` (strelice/tastatura/swipe/zatvori) + inline `VideoPlayer` + `Carousel` varijanta.
- [ ] `InfoPanel` (ikona+label+vrijednost, CTA; mobilni ispod sadržaja, opc. sticky CTA).
- [ ] `MiniMap` (statički isječak + pin + link na `/mapa`).
- [ ] `RelatedContent`, `AuthorBlock`, `CTASection`, `Stepper`, `SegmentControl`.

## F6 — Mapa (Leaflet)
- [ ] `MapInteractive` init (OSM tiles, centar Teslić, zoom granice).
- [ ] `MapPin` ikone po kategoriji + `MapCluster` (marker cluster).
- [ ] `MapPopup` (slika/naziv/chip/„Detalji →”).
- [ ] `MapFilterPanel` (checkbox slojevi + pretraga + legenda); sinhronizacija pin↔filter↔(`ResultsList`).
- [ ] Mobilni: full-screen mapa + filteri/popup u bottom-sheet.

## F7 — Kalendar
- [ ] `EventCalendar` — mjesečna mreža, tačke na danima s događajima, navigacija mjeseci.
- [ ] Klik na dan → lista događaja; mobilni kompaktan prikaz; integracija sa `SegmentControl` na `/dogadjaji`.

## F8 — Stranice: listinzi i statične
- [ ] **HomeView** (PRVA, prema usvojenom Konceptu A) — svih 12 blokova + stanja sekcija.
- [ ] **AboutView** — Hero split, misija, ciljevi grid, 3 kartice publike, partneri, CTASection.
- [ ] **ContactView** — kontakt info + forma + MiniMap.
- [ ] **LocalListingView** (Domaće) — FilterBar + podsekcije + grid + stanja.
- [ ] **TourismListingView** — 4 pločice podsekcija + grid lokaliteta + stanja.
- [ ] **EventsView** — Lista/Kalendar prebacivač + FilterBar + stanja.
- [ ] **AdsListingView** — FilterBar + stack oglasa (+Isteklo) + stanja.
- [ ] **StoriesListingView** — Featured + grid priča + stanja.
- [ ] **LegalView** (privatnost/kolačići/uslovi).

## F9 — Stranice: detalji
- [ ] **BusinessProfileView** — Hero + Gallery + 2-kol + InfoPanel + MiniMap + RelatedContent + modal „Pošalji upit” (forma+Captcha, uspjeh/greška).
- [ ] **LocationDetailView** — Hero + Gallery + 2-kol (O lokaciji/Kako doći/Savjeti) + InfoPanel + RelatedContent.
- [ ] **EventDetailView** — Hero + opis + Gallery + InfoPanel (+„Dodaj u kalendar” .ics) + RelatedContent + stanje „Završeno”.
- [ ] **AdDetailView** — opis + InfoPanel (izdavač/rok/kontakt) + RelatedContent + stanje „Isteklo”.
- [ ] **StoryDetailView** — Hero + sadržaj + Gallery + AuthorBlock + RelatedContent.

## F10 — Forme (Pridruži se)
- [ ] **JoinHubView** — Hero split + 2 putanje (CTASection) + benefiti + Stepper.
- [ ] `FormContainer` + inline validacija (required/email/tel) + stanje slanja (disabled+spinner).
- [ ] **RegisterBusinessView** — sva polja + `FileUpload` (drag&drop) + saglasnost + Captcha + obavijest o obradi.
- [ ] **RegisterAuthorView** — polja autora + upload/link + saglasnost + Captcha.
- [ ] Stanja: greška polja · `Pridruzi – Forma – Uspjeh` · `– Greska` (BaseAlert).

## F11 — Podatkovni sloj
- [ ] `services/api.js` — apstrakcija (zamjenjiva pravim API-jem); `useFetch` composable (loading/error/data).
- [ ] `data/*.json` — mock: biznisi, lokaliteti, događaji, oglasi, priče, kategorije (ijekavica, lokalni primjeri).
- [ ] Poveži sve listinge/detalje na servis; ubaci Skeleton/EmptyState/error svuda.
- [ ] Detalj rute po `:slug` (lookup + 404 ako nema).

## F12 — QA / polish
- [ ] Responsive prolaz 375 / 768 / 1440 na svim stranicama.
- [ ] A11y: AA kontrast (već provjeren u tokenima), `focus-visible`, navigacija tastaturom (drawer/dropdown/lightbox/modal trap), `alt` tekstovi, semantičke oznake.
- [ ] Performanse: lazy slike, code-splitting ruta (`defineAsyncComponent`/dynamic import), lazy Leaflet.
- [ ] Meta/SEO osnovno: `<title>` po ruti, opisi, OpenGraph; `lang="sr"`.
- [ ] 404 i prazna stanja provjereni; smoke test svih ruta.
- [ ] `README.md` u `app/` (pokretanje, struktura, gdje su tokeni/komponente).

---

## Prioriteti / kritični put
1. **F0→F1→F2→F3→F4** je kritični temelj (bez njega ništa drugo ne ide).
2. **HomeView** (F8 prvi task) je rana validacija dizajn-sistema na stvarnoj stranici — raditi je čim su F1–F5 spremni.
3. **Mapa (F6)** i **Kalendar (F7)** su izolovani — mogu paralelno dok teku stranice.
4. **Podatkovni sloj (F11)** uvesti rano kao apstrakciju (čak i nad mock-om) da se stranice ne pišu dvaput.

## Procjena veličine (gruba, T-shirt)
| Faza | Veličina |
|------|----------|
| F0–F1 | S |
| F2 | M |
| F3 | M |
| F4 | M |
| F5 | L |
| F6 | M–L |
| F7 | M |
| F8 | L |
| F9 | L |
| F10 | M |
| F11 | M |
| F12 | M |
