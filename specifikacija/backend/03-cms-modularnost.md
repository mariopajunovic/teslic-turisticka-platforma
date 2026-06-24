# 03 — CMS modularnost (potpuni block-builder)

> Cilj (📌 TS 4.1, 4.11, TS 9): naručilac **sam** upravlja sajtom — stranice, navigacija, header, footer, sekcije i stavke na stranicama — **bez koda**. „Kao WordPress, ali jednostavnije."
> Odluka: **potpuni block-builder** — svaka stranica je niz blokova; svaki tip bloka renderuje **postojeća Vue komponenta**.

## Princip
```
Filament (admin slaže)            DB                     Inertia/Vue (render)
┌──────────────────┐     ┌────────────────────┐   ┌─────────────────────────┐
│ Stranica = lista │ ──► │ pages 1───* blocks  │──►│ PageRenderer.vue        │
│ blokova (builder)│     │ block.type + .data │   │  switch(type) → komponenta│
└──────────────────┘     └────────────────────┘   └─────────────────────────┘
```
- Admin u Filamentu koristi **Builder field** (`Filament\Forms\Components\Builder`) — dodaje/sortira/uklanja blokove, svaki blok ima svoju formu (polja iz `data`).
- Front ima **jednu** Inertia stranicu `Pages/PageRenderer.vue` koja prima `page.blocks[]` i za svaki blok renderuje odgovarajuću komponentu (registar `blockComponents`).
- **Nijedan novi tip sadržaja ne traži deploy** dok god koristi postojeće tipove blokova.

## Tipovi blokova → Vue komponente (postojeće!)

| BlockType | Renderuje (postojeća komponenta) | `data` (primjer parametara) |
|-----------|----------------------------------|------------------------------|
| `hero` | `common/Hero.vue` | naslov, podnaslov, slika, CTA dugmad, varijanta |
| `section_header` | `common/SectionHeader.vue` | naslov, link-tekst, to |
| `card_grid` | `layout/CardGrid.vue` + `cards/*` | `resource` (business/event/story/location/ad), `mode` (auto/manual), `category`, `limit`, `cols`, `items[]` |
| `category_nav` | chip lista (`BaseChip`/`BaseIcon`) | kategorije, ciljne rute |
| `cta` | `common/CTASection.vue` | naslov, tekst, dugmad |
| `rich_text` | render HTML (iz `RichEditor`) | html sadržaj |
| `gallery` | `common/Gallery.vue` + `Lightbox.vue` | media kolekcija |
| `video` | `common/VideoPlayer.vue` | url/embed |
| `map_teaser` / `map` | `map/MapInteractive.vue` / MiniMap | filter, kategorije, fokus |
| `events_list` | `EventCard` grid / `calendar/EventCalendar.vue` | prikaz lista/kalendar, limit |
| `info_panel` | `common/InfoPanel.vue` | parovi labela/vrijednost |
| `related` | `common/RelatedContent.vue` | izvor veza |
| `form` | `forms/*` (kontakt/upit) + CAPTCHA | tip forme, primalac |
| `breadcrumb` | `common/Breadcrumb.vue` | auto iz rute |
| `spacer/divider` | util | razmak/linija |

> **Svaka stranica iz `frontend/src/views` razlaže se u ove blokove.** Npr. `HomeView.vue` = `hero` + `category_nav` + više `card_grid` (proizvodi/preporučeno/atrakcije) + `map_teaser` + `events_list` + `card_grid(story)` + `gallery` + `cta`. To je tačno set blokova koji već postoji kao komponente — pa je migracija „razlaganje", ne pisanje novog UI-a.

## Dinamički vs ručni sadržaj u bloku
- **auto** — blok povlači žive podatke (npr. „8 najnovijih objavljenih biznisa kategorije zanat"). Query se izvodi server-side u kontroleru/servisu.
- **manual** — admin ručno bira konkretne stavke (`items[]` po slug/id).
- Tako i „glavne" stranice (početna, listinzi) ostaju **žive** (prate novi sadržaj) iako su sastavljene od blokova.

## Tipovi stranica
1. **Sistemske** (`is_system=true`): Početna, listinzi (Domaće, Turizam, Događaji, Oglasi, Priče), Mapa, Kontakt, Pridruži se — imaju **fiksnu rutu** i logiku, ali su im **blokovi i meta uredivi** iz Filamenta.
2. **Slobodne** (CMS): nove stranice koje admin kreira → ruta `/{slug}` preko catch-all → `PageRenderer`.
3. **Detalj-template** entiteta (biznis/lokalitet/događaj/oglas/priča): konfigurabilan **redoslijed sekcija** po tipu entiteta (Hero → sadržaj → InfoPanel → Galerija → MiniMap → Related), s podacima entiteta. Admin može uključiti/isključiti sekcije po tipu.

## Navigacija, header i footer (bez koda)
- **MenuResource** gradi stavke (`main`, `footer-*`) s dropdown (`parent_id`) i tipom linka (ruta / URL / stranica / entitet).
- `AppHeader.vue` i `AppFooter.vue` čitaju menije i `settings` (logo, kontakt, social) **iz props-a** (Inertia shared data) umjesto iz statičkog `constants/navigation.js`.
- Promjena menija/logoa/footera u Filamentu je odmah vidljiva na sajtu.

## Globalni podaci (Inertia shared)
`HandleInertiaRequests::share()` šalje na svaku stranicu: `menus` (main+footer), `settings` (brand/kontakt/social/footer), `auth` (korisnik+uloga). Tako header/footer/SEO rade globalno.

## SEO / proširivost (📌 TS 9)
- Po stranici: `meta_title`, `meta_description`, `og_image`, slug.
- Priprema za **višejezičnost**: `locale` kolona na pages/blocks/menus + prebacivač u headeru (kasnije).

## Granice (da ostane „jednostavnije" od WordPressa)
- **Fiksan, kuriran set blokova** (gore) — nema proizvoljnog HTML/PHP-a od korisnika (sigurnost: XSS).
- Stilizacija blokova samo kroz **design tokene** (varijante), ne slobodan CSS.
- Bez plugin-marketa; proširenje = novi BlockType + komponenta (developer).

## 🔗 Veze
[Inertia front](04-inertia-frontend.md) · [Filament](02-filament-admin.md) · [Model podataka](01-model-podataka.md) · [Pregled/navigacija](../00-pregled-i-navigacija.md) · [Footer](../14-footer-i-globalni-elementi.md)
</content>
