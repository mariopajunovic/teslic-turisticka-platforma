# 01 — Model podataka

> Izveden iz postojećih mock JSON-a (`frontend/src/data/*.json`) + specifikacije stranica i uloga.
> Cilj: backend tačno hrani oblik podataka koji postojeće Vue komponente/kartice već očekuju.

## Pregled entiteta

```
KORISNICI                         SADRŽAJ (sve ima status workflow)
  users    (biznis, autor)          business   (biznis profil)
  admins   (Filament)               location   (turistički lokalitet)
                                     event      (događaj)
TAKSONOMIJA                         ad         (oglas)
  categories                        story      (priča / blog)
  tags                              news       (vijest)
  places (mapa tačke)
                                  CMS / MODULARNOST
MEDIJI                              pages    + blocks
  media (medialibrary)              menus    + menu_items
                                    settings (key-value grupe)
SISTEM
  activity_log · sessions · password_resets · roles · permissions
```

---

## 1) Sadržajni entiteti

Svi sadržajni modeli dijele zajedničke osobine (traits):
- **`HasStatus`** — `status` (enum), `published_at`, scope `published()`.
- **`HasOwner`** — `user_id` (vlasnik: biznis/autor; null za admin-kreirano).
- **`Sluggable`** — `slug` iz `naslov`.
- **`InteractsWithMedia`** — naslovna slika + kolekcija `galerija`.
- **`Mappable`** (gdje ima lokaciju) — `lat`, `lng`, veza na `place`.
- **`HasCategory`** — veza na `categories` (+ `tags`).

### business (Biznis profil) — `biznisi.json`
| Polje | Tip | Napomena |
|------|-----|----------|
| id, slug | | |
| naslov | string | |
| opis | string | kratki (kartica) |
| opis_dug | text | detalj |
| category_id | FK | „zanat/hrana/usluge…" |
| lokacija | string | tekst (npr. „Borje, Teslić") |
| preporuceno | bool | kurirani izbor (početna/listing) |
| kontakt | json | `{telefon,email,web,radnoVrijeme,adresa}` |
| lat, lng / place_id | | za mapu |
| naslovna slika, galerija | media | |
| status, user_id, published_at | | workflow + vlasnik |

### location (Turistički lokalitet) — `lokaliteti.json`
Kao business +: `kako_doci`, `savjeti`, `sezona`, `radno_vrijeme`, `ulaznice`. Kategorije: priroda/kultura/planine/smjestaj.

### event (Događaj) — `dogadjaji.json`
`naslov, datum (date), vrijeme (string), lokacija, organizator, opis_dug, zavrseno (computed iz datuma), lat/lng, galerija`. Iz `datum` se izvode `dan`/`mjesec` za karticu (ne čuvati duplo).

### ad (Oglas) — `oglasi.json`
`naslov, vrsta (kategorija: posao/nekretnine/poziv…), izdavac, lokacija, rok (date), opis_dug, kontakt{osoba,telefon,email}`. Status dodatno: **arhivirano** automatski po isteku `rok` (📌 spec. 12).

### story (Priča / blog) — `price.json`
`naslov, kategorija (domacini/ljudi/svakodnevica/izdvojeno), autor (→ user), datum, izvod, sadrzaj (rich HTML), featured (bool), autor_bio`. Povezivanje s biznisom/lokalitetom/događajem (📌 spec. 13D).

### news (Vijest)
Lagani članak za admin objave (📌 admin panel f.7): `naslov, slug, izvod, sadrzaj, datum, naslovna slika, status`.

> **Polimorfne veze sadržaja** (`content_links`): povezivanje biznis ↔ događaj ↔ priča ↔ lokalitet (📌 00-pregled, „RelatedContent"). `morphedByMany` ili pivot `linkable_a / linkable_b`.

---

## 2) Workflow statusa (📌 TS 8, spec. 12)

`enum ContentStatus`: **nacrt · poslano · odobreno · objavljeno · odbijeno · arhivirano**

```
 nacrt ──pošalji──► poslano ──admin odobri──► odobreno ──objavi──► objavljeno
   ▲                   │                                              │
   └── vrati/odbij ◄────┘ (admin unosi RAZLOG → vidljiv vlasniku)     └─(oglas: rok istekao)─► arhivirano
```

- Prelaze izvode **Action klase** (`SubmitForReview`, `Approve`, `Reject`, `Publish`, `Archive`) — koriste ih i Inertia (vlasnik) i Filament (admin). Svaki prelaz se **loguje**.
- `rejection_reason` (text) obavezan pri odbijanju/vraćanju.
- Vidljivost: `published` javno; ostali statusi samo vlasniku + adminu (badge statusa na frontu).
- Primjenjuje se na: **business, ad, story** (+ news admin-side). Event/location uglavnom admin-kreirani (mogu ići direktno u `objavljeno`).

---

## 3) Taksonomija i lokacije

- **categories** — `key, label, icon, type` (`type` = kojem modulu pripada: domace/turizam/price/oglasi). Postojeći set u `constants/categories.js` je seed.
- **tags** — slobodne oznake (`taggables` polimorfno).
- **places** — tačke na mapi: `naziv, lat, lng, category_id, linkable_type, linkable_id` (veza ka entitetu). Hrani [Mapu](../stranice/07-mapa-ponude.md) i `MiniMap` na detaljima (📌 TS 4.9). Svaki entitet s `lat/lng` se projektuje u `places` (ili ima inline koordinate + scope za mapu).

---

## 4) CMS tabele (modularnost — detalji u [03](03-cms-modularnost.md))

### pages
`id, title, slug, status, template, meta_title, meta_description, og_image, is_system, sort`
- `is_system` = true za stranice koje imaju namjenske rute (Početna, listinzi) — uređuju im se blokovi i meta, ali ruta je fiksna.
- ostale (nove) stranice rješava catch-all `/{slug}`.

### blocks
`id, page_id, type (enum BlockType), sort, data (json), settings (json), visible (bool)`
- `type` → mapira na Vue komponentu (Hero, CardGrid, CTA, RichText, Gallery, Map, EventsList, CategoryNav, Video, Related, Form…).
- `data` → sadržaj/parametri (npr. za CardGrid: `{resource:'business', category:'zanat', mode:'auto|manual', items:[...], limit:8, cols:4}`).
- Blokovi su **sortabilni** i mogu se isključiti (`visible`).

### menus + menu_items
- **menus**: `key` (`main`, `footer-brzi`, `footer-istrazi`, `footer-pravno`), `name`.
- **menu_items**: `menu_id, parent_id (dropdown), label, type (route|url|page|entity), target, sort, visible`.
- Zamjenjuje statički `constants/navigation.js` — admin gradi navigaciju/footer iz panela.

### settings (grupe)
- **brand**: logo, logo-wordmark, naziv, boja (`primary`).
- **kontakt**: adresa, telefon, email.
- **social**: fb, ig, yt…
- **footer**: opis, partneri, copyright.
- **sistem**: jezici (priprema za i18n), maintenance, default meta.

---

## 5) Korisnici (vidi [05](05-auth-uloge-sigurnost.md))

### users  (web guard — Fortify + Inertia)
`id, ime, email, password, role (biznis|autor), status (na_odobrenju|aktivan|blokiran), email_verified_at, 2FA polja (opc.)`, profilna polja (bio, foto, telefon). Vlasnik je sadržaja preko `user_id`.

### admins  (admin guard — Filament)
`id, ime, email, password, 2FA (obavezno), is_super`. Odvojena tabela/guard; nema veze s javnim sadržajem osim kroz logove. Uloge: **administrator**, opc. **urednik** (Shield).

---

## ERD (sažeto)

```
admins ──(role-based via permission)            users 1───* business/ad/story  (user_id, owner)
                                                   │
categories 1───* business/location/event/ad/story │
tags *───* {entiteti} (taggables)                  │
places *───1 {entitet} (linkable)                  │
media *───1 {bilo koji model} (medialibrary)       │
content_links: {entitet} *───* {entitet}           ▼
pages 1───* blocks                              status workflow (Action + activity_log)
menus 1───* menu_items (self parent_id)
settings (group,key,value)
activity_log *───1 {causer: admin|user}
```

## Seed
`database/seeders/` puni bazu iz postojećih `frontend/src/data/*.json` (biznisi, lokaliteti, dogadjaji, oglasi, price) + `categories` iz `constants/categories.js` + početne `menus`/`pages`/`settings` koji reprodukuju trenutni statički front. Time front odmah radi na pravim podacima.

## 🔗 Veze
[Arhitektura](00-arhitektura-i-tech-stack.md) · [Filament](02-filament-admin.md) · [CMS](03-cms-modularnost.md) · [Uloge i workflow](../administracija/12-korisnicke-uloge-i-workflow.md)
</content>
