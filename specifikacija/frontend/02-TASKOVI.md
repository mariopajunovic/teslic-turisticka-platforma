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

## F5 — Kompozitne komponente ✅ (4 paralelna agenta)
- [x] `Hero` — `slika-pozadina` (slika+overlay, fallback gradient, kicker lime) i `split` (tekst+slika, kicker accent-deep); slot za akcije.
- [x] `FilterBar` (desktop traka) + `FilterDrawer` (mobilni bottom-sheet, matchMedia da se slot ne duplira) + aktivni filteri kao uklonjivi chipovi + „Očisti filtere”.
- [x] `SearchInput` (lupa, clear ×, submit) — reusable input.
- [x] `Gallery` (grid/carousel) + `Lightbox` (strelice/tastatura/Esc/wrap/scroll-lock) + inline `VideoPlayer` (native + placeholder).
- [x] `InfoPanel` (ikona+label+vrijednost+href, CTA slot), `MiniMap` (faux isječak + pin + „Prikaži na mapi” → `/mapa`).
- [x] `RelatedContent` (CardGrid slot), `AuthorBlock` (avatar+bio+link), `CTASection` (primary, slot dugmad), `Stepper` (1·2·3, vert. na mobilnom), `SegmentControl` (`v-model`).
- [x] Sve prezentovano na `/_dev`; build ✓, lint ✓; vizuelno potvrđeno (desktop screenshot).
- [ ] (F11) `useFilters` composable (sinhron s URL query) — uvodi se uz listinge.
- [ ] (F3 done) globalni search overlay već u `AppHeader`; ovdje je `SearchInput` za listinge.

## F6 — Mapa (Leaflet)
## F6 — Mapa (Leaflet) ✅ (agent)
- [x] `MapInteractive` (OSM tiles, centar Teslić, props items/activeCategories/center/zoom/height, emit `select`, cleanup).
- [x] Pinovi po kategoriji preko `markerIcon.js` (`categoryIcon`/`categoryColor`, boja po kategoriji) + `L.markerClusterGroup` (clustering).
- [x] `MapPopup` (CardImage + naziv + chip + „Detalji →”).
- [x] `MapFilterPanel` (`v-model` aktivne kategorije, FormCheckbox slojevi + SearchInput + legenda u boji); `ResultsList` (sinhron s mapom, emit `select`).
- [x] Potvrđeno na `/_dev` (tiles + pin + legenda + rezultati). Build ✓, lint ✓.
- [ ] (F8 MapView) full-screen mobilni + filteri/popup u bottom-sheet (raspored stranice; komponente spremne).

## F7 — Kalendar ✅ (agent)
- [x] `EventCalendar` — mjesečna mreža (6×7, sedmica od ponedjeljka), ijekavski mjeseci/dani, navigacija mjeseci, tačke na danima s događajima, današnji + odabrani dan istaknuti.
- [x] `v-model` (YYYY-MM-DD) + emit `select-day` ({date, events}); a11y (dugmad, aria). Potvrđeno na `/_dev`.
- [ ] (F8 EventsView) integracija sa `SegmentControl` (Lista/Kalendar) + lista događaja dana.

## F8 — Stranice: listinzi i statične ✅ (agent + paralelno s F9/audit)
- [x] **HomeView** — Koncept A, svih ~11 blokova (Hero slika-pozadina, kategorije, Lokalni proizvodi, Preporučeno na primary-tint, Atrakcije, Mapa isječak, Događaji, Priče, Galerija, CTA) + loading/error stanja. Bez breadcrumba.
- [x] **AboutView** — Hero split, Misija, Ciljevi grid, „Kome je namijenjeno” 3 kartice (users/store/pen), partneri, CTASection.
- [x] **ContactView** — kontakt info (iz constants) + forma (atomi + validacija + BaseAlert) + MiniMap.
- [x] **LocalListingView / TourismListingView / AdsListingView / StoriesListingView** — Breadcrumb + Hero/naslov + FilterBar (FormSelect + SearchInput + chipovi) + CardGrid + Pagination + stanja (Skeleton/EmptyState/error). Klijentsko filtriranje.
- [x] **EventsView** — SegmentControl (Lista/Kalendar) + FilterBar; Lista = EventCard grid; Kalendar = EventCalendar + lista dana.
- [x] **LegalView** (privatnost/kolačići/uslovi) — prop `doc`, placeholder pravni tekst.
- [x] Svi povezani na data sloj (`useFetch`+`api`); build ✓, lint ✓; vizuelno potvrđeno (home/listing/detail/mobile).

## F9 — Stranice: detalji ✅ (agent)
- [x] **BusinessProfileView** — Breadcrumb + Hero + Gallery + 2-kol + InfoPanel (kontakt) + „Pošalji upit” (BaseAlert) + MiniMap + RelatedContent „Slično”.
- [x] **LocationDetailView** — Hero + Gallery + 2-kol (O lokaciji/Kako doći/Savjeti) + InfoPanel (tip/sezona/radno vrijeme/ulaznice) + MiniMap + RelatedContent.
- [x] **EventDetailView** — Hero (datum) + opis + Gallery + InfoPanel + „Dodaj u kalendar” (BaseAlert) + „Završeno” badge + RelatedContent.
- [x] **AdDetailView** — naslov + Chip + opis + InfoPanel (izdavač/rok/kontakt) + „Isteklo” + RelatedContent.
- [x] **StoryDetailView** — Hero + prozni sadržaj + Gallery + AuthorBlock + RelatedContent.
- [x] Stanja: loading / nije pronađeno (EmptyState) / error (BaseAlert). Dvokolonski → stack na mobilnom.
- [ ] (kasnije) „Pošalji upit” / „Dodaj u kalendar” kao pravi modal/.ics umjesto BaseAlert potvrde.

### Audit (paralelni agent, read-only) — nalaz
- ✅ Nema 🔴 prekršaja; codebase dosljedno koristi token-klase, a11y/alt uredni.
- 🟡 sitno: `markerIcon.js` duplira HEX tokena (Leaflet divIcon — nužno; rizik drifta), par off-scale font veličina (`text-[10/11/15/17px]`), `AppFooter` placeholder partneri/social, `z-[60]` u Lightboxu. Za adresirati po želji (nije blokirajuće).

## F10 — Forme (Pridruži se)
- [ ] **JoinHubView** — Hero split + 2 putanje (CTASection) + benefiti + Stepper.
- [ ] `FormContainer` + inline validacija (required/email/tel) + stanje slanja (disabled+spinner).
- [ ] **RegisterBusinessView** — sva polja + `FileUpload` (drag&drop) + saglasnost + Captcha + obavijest o obradi.
- [ ] **RegisterAuthorView** — polja autora + upload/link + saglasnost + Captcha.
- [ ] Stanja: greška polja · `Pridruzi – Forma – Uspjeh` · `– Greska` (BaseAlert).

## F11 — Podatkovni sloj (povučen ranije, uz F8/F9)
- [x] `services/api.js` (`list`/`get` nad mock JSON, AbortSignal) + `useFetch` composable (data/loading/error/retry).
- [x] `data/*.json` — mock: biznisi, lokaliteti, dogadjaji, oglasi, price (ijekavica, detaljna polja); kategorije već u `constants/categories.js`.
- [x] Svi listinzi/detalji povezani na servis; Skeleton/EmptyState/error svuda.
- [x] Detalj rute po `:slug` (`api.get` lookup; EmptyState „nije pronađeno” ako nema).
- [ ] Zamjena mock-a pravim API-jem (samo izmjena u `services/api.js`) kad backend bude spreman.

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
