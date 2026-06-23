# Inventar komponenti — analiza `.pen` → Vue komponente

> Rezultat analize `pencil/00_Foundations.pen` (reusable komponente) + recepata stranica.
> Princip: jedna Pencil komponenta `Komponenta/Varijanta` → jedna Vue komponenta `Komponenta` s `variant` prop-om.
> Legenda: ✅ već postoji kao reusable u `00_Foundations.pen` · 🧩 kompozitna (sklapa se iz atoma, definisana kroz recepte) · 🗺 mapa · 📅 kalendar.

---

## A) Atomi (`src/components/base/`)

| Vue komponenta | Pencil izvor | Props (ključni) | Stanja | Status |
|----------------|--------------|-----------------|--------|--------|
| `BaseButton` | Dugme/{Primary, Secondary, Ghost, Akcent, Sekundarna} | `variant`, `size` (md 44 / sm 36), `icon`, `iconPosition`, `disabled`, `href/to` | default·hover·focus·pressed·disabled | ✅ |
| `BaseChip` | Chip/{Filter, Kategorija, Uklonjiv} | `variant`, `label`, `icon`, `active`, `removable` (×) | default·hover·active | ✅ |
| `BaseBadge` | Badge/Status | `variant` (Objavljeno/NaOdobrenju/Nacrt/Isteklo/Odbijeno/Preporučeno), `label` | — (tinted: tačkica + tekst) | ✅ |
| `BaseIcon` | `icon` (lucide) | `name`, `size`, `color` | — | (wrapper za lucide) |
| `FormField` | Polje/Tekst | `label`, `modelValue`, `helper`, `error`, `required`, `type` | default·focus·error·disabled | ✅ |
| `FormSelect` | Polje/Select | `label`, `options`, `modelValue`, `helper`, `error` | zatvoren·otvoren·odabran·disabled | ✅ |
| `FormTextarea` | Polje/Textarea | `label`, `modelValue`, `maxlength`, `helper`, `error` | default·focus·error | ✅ |
| `FormCheckbox` | Checkbox | `label`, `modelValue`, `required` | un/checked·focus | ✅ |
| `FormCaptcha` | Captcha | (placeholder widget) | — | ✅ |
| `BaseAlert` | Alert/Uspjeh (+greška/info) | `variant` (uspjeh/greška/info), `title`, `text` | — | ✅ (uspjeh; dodati greška/info) |

---

## B) Layout / globalno (`src/components/layout/`)

| Vue komponenta | Pencil izvor | Napomena |
|----------------|--------------|----------|
| `AppHeader` | Header/Desktop + Header/Mobile | sticky (smanji + shadow na skrol); logo „teslić”; nav s dropdownima; pretraga; „Pridruži se” (Primary) + „Prijava” (Ghost, link u account sistem). |
| `NavDropdown` | (dio Header nav) | dropdown za: Domaće je najbolje, Turizam, Priče, Pridruži se. |
| `MobileDrawer` | Header/Mobile (hamburger → drawer) | puna navigacija + „Pridruži se”. |
| `AppFooter` | Footer | 4 kolone linkova + traka partnera + pravna traka (`primary-darker`). |
| `CookieBanner` | CookieBanner | tekst + „Prihvati” (Primary) + „Saznaj više” (Ghost); consent u Pinia/localStorage. |
| `AppContainer` | (grid 12, max 1200, padding 24/16) | wrapper širine sadržaja. |
| `CardGrid` | Grid | responsivno 4→2→1 (gutter 24/16); slot za kartice. |

---

## C) Kartice (`src/components/cards/`)

Sve dijele anatomiju (slika 16:9 · chip · naslov H3 · opis truncate · meta · opcioni badge) i hover `shadow-md`. Cijela kartica je link.

| Vue komponenta | Pencil izvor | Specifičnost |
|----------------|--------------|--------------|
| `BusinessCard` | Kartica/Biznis | slika, chip kategorije, badge „Preporučeno”, meta 📍. |
| `LocationCard` | (Kartica/Lokalitet = instanca Biznis) | vizuelno srodna; tip lokaliteta kao chip. Može biti `BusinessCard` s `variant="lokalitet"`. |
| `EventCard` | Kartica/Dogadjaj | datumski blok (dan/mjesec) overlay/lijevo, vrijeme, 📍. |
| `AdCard` | Kartica/Oglas | kompaktna, bez velike slike; izdavač · 📍 · ⏳ rok; stanje „Isteklo” (prigušeno + badge). |
| `StoryCard` | Kartica/Prica | autor + datum, izvod 2–3 reda. |
| `StoryFeaturedCard` | Kartica/Prica-Featured | široka, slika lijevo + tekst desno. |

---

## D) Kompozitne / zajedničke (`src/components/common/`)

| Vue komponenta | Pencil izvor | Props/varijante | Status |
|----------------|--------------|-----------------|--------|
| `Breadcrumb` | Breadcrumb | `items[]` (zadnji nije link) | ✅ |
| `Pagination` | Paginacija | `total`, `current`; + varijanta `LoadMore` | ✅ |
| `Skeleton` | Skeleton | `variant` (kartica/red), `count` | ✅ |
| `EmptyState` | PraznoStanje | `icon`, `title`, `text`, `cta` | ✅ |
| `CTASection` | CTASekcija | `title`, `text`, `buttons[]` (primary pozadina) | ✅ |
| `Hero` | Hero/Stranica | `variant` (`slika-pozadina` / `split`), `title`, `subtitle`, `image`, `actions[]` | 🧩 |
| `FilterBar` | FilterTraka | `dropdowns[]`, search, „Očisti filtere”; aktivni filteri kao `Chip/uklonjiv`; mobilni → `FilterDrawer` | 🧩 |
| `FilterDrawer` | Drawer/Filteri (mobilni) | sadržaj FilterBar-a u drawer-u | 🧩 |
| `SearchInput` | Pretraga | lupa, placeholder, clear ×; globalna verzija → overlay rezultata | 🧩 |
| `Gallery` | Galerija | mreža sličica → `Lightbox`; `Carousel` varijanta; inline `VideoPlayer` | 🧩 |
| `Lightbox` | Lightbox | overlay, strelice, zatvori, tastatura/swipe | 🧩 |
| `InfoPanel` | InfoPanel | `items[]` (ikona+label+vrijednost), CTA dugme; na mobilnom ispod sadržaja | 🧩 |
| `MiniMap` | MiniMapa | isječak + 1 pin + „Prikaži na mapi” (vodi na `/mapa`) | 🧩 |
| `RelatedContent` | PovezaniSadrzaj | naslov + red `Kartica/*` (slot) | 🧩 |
| `AuthorBlock` | BlokOAutoru | avatar + ime + bio + link na priče | 🧩 |
| `Stepper` | (Pridruži se „Kako teče proces”) | koraci 1–2–3; horizontalni/vertikalni | 🧩 |
| `SegmentControl` | (Događaji „Lista/Kalendar”) | `options[]`, `modelValue` | 🧩 |

---

## E) Mapa (`src/components/map/`) — Leaflet 🗺

| Vue komponenta | Pencil izvor | Napomena |
|----------------|--------------|----------|
| `MapInteractive` | MapaInteraktivna | platno mape; učitava markere; sinhronizacija s filterima/listom. |
| `MapPin` | Pin | ikona po kategoriji (zanat/hrana/usluge/priroda/kultura/smještaj/događaj). |
| `MapCluster` | Cluster | grupisanje na odjavljenom zoomu. |
| `MapPopup` | MapaPopup | slika · naziv · chip kategorije · „Detalji →”. |
| `MapFilterPanel` | FilterPanel | checkbox slojevi/kategorije + `Pretraga` + legenda ikona; mobilni → bottom-sheet/Drawer. |
| `ResultsList` | ListaRezultata | (opc.) lista sinhronizovana s mapom. |

---

## F) Kalendar (`src/components/calendar/`) 📅

| Vue komponenta | Pencil izvor | Napomena |
|----------------|--------------|----------|
| `EventCalendar` | (Događaji — Kalendar) | mjesečna mreža; tačka/akcent na danima s događajima; klik na dan → lista događaja tog dana; mobilni kompaktan. |

---

## G) Forme (`src/components/forms/`)

| Vue komponenta | Pencil izvor | Napomena |
|----------------|--------------|----------|
| `FormContainer` | Forma | naslov + slot polja + Checkbox saglasnosti + Captcha + Submit; inline validacija; stanje slanja (disabled+spinner) i uspjeh (`BaseAlert`). |
| `BusinessForm` | (Recept 09 B) | sva polja registracije biznisa + upload + obavijest o obradi. |
| `AuthorForm` | (Recept 09 C) | polja autora + upload/link. |
| `FileUpload` | Polje tip „upload” (drag&drop) | drag&drop fotografija/medija, preview, validacija. |

---

## H) Stranice (`src/views/`) → komponente koje koriste

| # | View | Glavne komponente |
|---|------|-------------------|
| 01 | HomeView | Hero · BaseChip pločice · CardGrid+BusinessCard · CTASection (Preporučeno) · LocationCard · MiniMap · EventCard · StoryCard/Featured · Gallery · CTASection |
| 02 | AboutView | Breadcrumb · Hero(split) · tekst sekcije · grid ciljeva · 3 kartice (Posjetioci/Biznisi/Autori) · traka partnera · CTASection |
| 03 | LocalListingView | Breadcrumb · FilterBar · podsekcije · CardGrid+BusinessCard · Pagination · stanja (Skeleton/EmptyState) |
| 03d | BusinessProfileView | Hero · Gallery · 2-kol (sadržaj + InfoPanel) · MiniMap · RelatedContent · Modal „Pošalji upit” (FormContainer+Captcha) |
| 04 | TourismListingView | Hero · 4 pločice podsekcija · FilterBar · CardGrid+LocationCard · MiniMap · stanja |
| 04d | LocationDetailView | Hero · Gallery · 2-kol (O lokaciji/Kako doći/Savjeti + InfoPanel) · MiniMap · RelatedContent |
| 05 | EventsView | SegmentControl(Lista/Kalendar) · FilterBar · CardGrid+EventCard / EventCalendar · Pagination |
| 05d | EventDetailView | Hero · opis+Gallery · InfoPanel (datum/vrijeme/lokacija/MiniMap/„Dodaj u kalendar”) · RelatedContent |
| 06 | AdsListingView | FilterBar · stack AdCard (+Isteklo) · Pagination · stanja |
| 06d | AdDetailView | naslov · opis · InfoPanel (izdavač/rok/kontakt) · RelatedContent |
| 07 | MapView | MapFilterPanel · MapInteractive · MapPopup · ResultsList · (mobilni sheet) |
| 08 | StoriesListingView | StoryFeaturedCard · FilterBar · CardGrid+StoryCard · Pagination |
| 08d | StoryDetailView | Hero · sadržaj · Gallery · AuthorBlock · RelatedContent |
| 09 | JoinHubView | Hero(split) · 2 CTASection putanje · benefiti · Stepper |
| 09b/c | RegisterBusinessView / RegisterAuthorView | FormContainer + BusinessForm/AuthorForm + Captcha + stanja |
| 10 | ContactView | Breadcrumb · kontakt info · FormContainer · MiniMap |
| — | LegalView | tekstualne pravne stranice (privatnost/kolačići/uslovi) |
| — | NotFoundView | EmptyState + CTA na Početnu |

---

## I) Mapiranje stanja (obavezno svuda)

- **Liste:** `default · prazno (EmptyState) · učitavanje (Skeleton) · filtrirano · greška (BaseAlert)`.
- **Forme:** `default · greška polja (inline) · uspjeh (BaseAlert) · slanje (disabled + spinner)`.
- **Interaktivno:** `hover · focus (ring primary) · pressed · disabled`.

---

## J) Sažetak brojanja

- **Atomi:** 10 · **Layout:** 7 · **Kartice:** 6 · **Kompozitne:** 17 · **Mapa:** 6 · **Kalendar:** 1 · **Forme:** 4 → **~51 komponenta**.
- Od toga **≈20 već postoji kao reusable u `00_Foundations.pen`** (atomi + kartice + dio common-a) → direktno mapiranje 1:1.
- **Kompozitne (🧩) i mapa/kalendar** su definisane kroz recepte stranica i grade se iz atoma — to je glavnina nove implementacije.
