# 01 — Biblioteka komponenti

Sve stranice grade se od OVIH komponenti. Agent koristi postojeću komponentu; nove se ne uvode bez dopune ovog dokumenta. Svaka komponenta navodi: namjenu, anatomiju (dijelove), varijante i stanja. Tokeni → [00-design-tokens.md](00-design-tokens.md).

Naziv elementa u Pencilu = `Komponenta/Varijanta` (npr. `Dugme/Primary`, `Kartica/Biznis`).

---

## Globalne

### `Header` (vidi [02](02-globalni-layout.md))
Logo · glavna navigacija (s dropdownima) · pretraga · dugme „Pridruži se” (Primary) · „Prijava”.
Stanja: default, sticky (smanjen), mobilni (hamburger → drawer), otvoren dropdown.

### `Footer` (vidi [02](02-globalni-layout.md))
4 kolone linkova · traka logotipa partnera · donja pravna traka.

### `Dugme`
Varijante: `Primary` · `Secondary` · `Ghost` · `Akcent`. Veličine: `md` (44px), `sm` (36px). Stanja: default/hover/focus/pressed/disabled. Opcionalno ikona lijevo/desno.

### `Chip / Tag`
Pill oblik. Varijante: `filter` (klikabilan, aktivno = `primary` pozadina, bijeli tekst), `kategorija` (statična oznaka), `uklonjiv` (s ×).

### `Badge/Status`
Pill s tekstom. Varijante po statusu: `Objavljeno` (success), `Na odobrenju` (warning), `Nacrt`/`Isteklo` (neutral), `Odbijeno` (error), `Preporučeno` (accent). (Na javnim stranicama uglavnom `Preporučeno` i `Isteklo`.)

### `Breadcrumb`
Putanja: `Početna / Sekcija / Stranica`. Razdvajač „/”. Zadnji element nije link.

---

## Pretraga i filtriranje

### `FilterTraka`
Horizontalna traka iznad listinga. Sadrži: 1–3 `Dropdown` (kategorija/podkategorija/lokacija/rok), polje `Pretraga`, dugme „Očisti filtere” (Ghost).
Varijante: desktop (u redu), mobile (dugme „Filteri” → otvara `Drawer/Filteri`).
Stanja: neutralno, s aktivnim filterima (prikaz `Chip/uklonjiv` aktivnih izbora).

### `Pretraga` (input)
Polje s ikonom lupe; placeholder; clear ×. Globalna verzija u headeru otvara overlay rezultata.

### `Dropdown/Select`
Label + polje + lista opcija. Stanja: zatvoren/otvoren/odabran/disabled.

---

## Kartice (liste)

### `Kartica/Biznis`
Anatomija: slika (16:9) · `Chip/kategorija` · naslov (H3) · kratak opis (2 reda, truncate) · meta red (📍 lokacija) · opcioni `Badge/Preporučeno`. Cijela kartica je link. Hover: `shadow-md`.

### `Kartica/Lokalitet`
Slika · tip (chip) · naslov · kratak opis · 📍. (Vizuelno srodna Biznis kartici.)

### `Kartica/Dogadjaj`
Datumski blok (dan/mjesec, lijevo ili overlay na slici) · naslov · 📍 lokacija · vrijeme · kratak opis. Hover `shadow-md`.

### `Kartica/Oglas`
Naslov · `Chip` vrste oglasa · red meta: izdavač · 📍 lokacija · ⏳ rok. Bez velike slike (kompaktan red/kartica). Stanje „Isteklo” = prigušeno + `Badge/Isteklo`.

### `Kartica/Prica`
Slika · `Chip/kategorija` · naslov · autor + datum · izvod (2–3 reda). Varijanta `Featured` (velika, preko cijele širine).

### `Grid`
Responzivni raspored kartica: 3–4 kol. desktop / 2 tablet / 1 mobile; gutter po tokenima.

### `Paginacija` / `UcitajJos`
Dvije varijante navigacije kroz liste.

---

## Detaljne stranice

### `Hero/Stranica`
Veliki naslov + (opciono) podnaslov + naslovna slika/galerija. Varijante: `slika-pozadina` (s overlay tekstom) i `split` (tekst lijevo, slika desno).

### `Galerija`
Mreža sličica → `Lightbox` (overlay, strelice, zatvori). Podržava i video (`VideoPlayer` inline). Varijanta `Carousel` za uske prostore.

### `InfoPanel` (bočni)
Kartica sa stavkama: ikona + label + vrijednost (telefon, e-mail, web/mreže, radno vrijeme, adresa, datum/vrijeme, rok…). Sadrži CTA dugme (npr. „Pošalji upit”). Na mobilnom ide ispod glavnog sadržaja.

### `MiniMapa`
Mali isječak mape s jednim pinom + dugme „Prikaži na mapi”. Vodi na `07 Mapa` fokusiranu na entitet.

### `PovezaniSadrzaj`
Sekcija „Povezano” s redom `Kartica/*` (događaji, priče, biznisi, lokaliteti).

### `BlokOAutoru`
Avatar + ime autora + kratka bio + link na ostale priče. (Detalj priče.)

---

## Forme

### `Forma` (kontejner)
Naslov · niz `Polje` · `Checkbox` saglasnosti · `Captcha` · `Dugme/Primary` (Pošalji). Validacija inline.

### `Polje`
Label · input/textarea/select · pomoćni tekst · stanje greške (crveni border + poruka) · obavezno (*). Tipovi: tekst, e-mail, telefon, textarea, select, **upload** (drag&drop fotografija/medija).

### `Captcha`
Placeholder blok (npr. hCaptcha/reCAPTCHA widget). Obavezan na svim javnim formama.

### `PorukaStanja` (alert)
Varijante: `uspjeh` (success), `greška` (error), `info`. Za potvrde slanja i greške.

---

## Mapa

### `MapaInteraktivna`
Veliko platno mape · `Pin` po kategorijama (ikone iz tokena) · `Cluster` (grupisanje) · `MapaPopup` (slika, naziv, kategorija, „Detalji →”). Uz mapu: `FilterPanel` (slojevi/kategorije, checkbox) + opciona `ListaRezultata` sinhronizovana s mapom.

---

## Pomoćne / stanja

### `PraznoStanje`
Ikona + poruka + (opciono) CTA. Za liste bez rezultata / prazne kategorije.

### `Skeleton`
Sive plejsholder forme kartica/redova tokom učitavanja.

### `CookieBanner`
Donja traka: tekst + „Prihvati” (Primary) + „Saznaj više” (Ghost → politika kolačića).

### `CTASekcija`
Široki blok (često `primary`/`primary-tint` pozadina): naslov + tekst + 1–2 dugmeta. Za pozive na registraciju.

---

## Obavezna stanja po komponenti (podsjetnik)
- Liste: `default · prazno · učitavanje (Skeleton) · filtrirano · greška`.
- Forme: `default · greška polja · uspjeh · slanje (disabled+spinner)`.
- Interaktivno: `hover · focus · pressed · disabled`.
