# 04 — Turizam u Tesliću

📌 **TS 4.5** · **Pristup:** javno (čitanje); unos — admin

Turistička sekcija: prikaz prirodnih i kulturnih atrakcija, lokaliteta na mapi, smještaja i informacija za posjetioce.

## Podstranice (📌 TS 4.2)
- **Prirodne atrakcije**
- **Kulturne manifestacije**
- **Planine, šume i sela**
- **Gdje odsjesti** (smještajni i turistički kapaciteti)

---

## A) Listing turizma / kategorija
**Ruta:** `/turizam`, `/turizam/{kategorija}`

### Raspored
```
[ Hero sekcije + kratak opis Teslića kao destinacije ]
[ Prečice na 4 podsekcije (velike pločice s vizualima) ]
[ FILTER: kategorija ▾ · lokacija ▾ · pretraga ⌕ ]
[ GRID KARTICA LOKALITETA: slika · naziv · tip · kratak opis · 📍 ]
[ Izdvojeni prikaz na mapi (isječak) → Mapa ponude ]
[ Preporučene lokacije ]
```

### Funkcionalnosti (🔴 — 📌 TS 4.5)
- Prikaz prirodnih i kulturnih atrakcija.
- Galerije fotografija.
- Prikaz turističkih lokaliteta na mapi.
- Povezivanje sa događajima i pratećim sadržajima.
- Prikaz preporučenih lokacija.
- Pregled smještajnih i turističkih kapaciteta (podstranica „Gdje odsjesti”).
- Pregled informacija relevantnih za posjetioce.

---

## B) Detalj lokaliteta / atrakcije
**Ruta:** `/lokalitet/{slug}`

### Raspored
```
[ Naslov + hero galerija (foto/video, dronski snimci) ]
┌──────────────────────────────┬───────────────────────────┐
│ OPIS LOKALITETA               │ INFO PANEL                │
│ · šta je, zašto posjetiti     │ · tip (priroda/kultura…)  │
│ · kako doći / pristup         │ · lokacija + mini-mapa    │
│ · savjeti za posjetioce       │ · radno vrijeme/sezona    │
│                               │ · ulaznice/cijene 🟡      │
└──────────────────────────────┴───────────────────────────┘
[ POVEZANO: događaji na ovoj lokaciji · obližnji smještaj · priče ]
[ GALERIJA ]
```

### Polja lokaliteta (predlog za dizajn)
- Naziv, tip/kategorija, kratak i detaljan opis, galerija, lokacija (koordinate), info za posjetioce (sezona, pristup), povezani događaji/biznisi/priče.

### Podstranica „Gdje odsjesti”
- Lista smještajnih kapaciteta (kartice: naziv, tip, slika, lokacija, kontakt). Može koristiti iste profile kao biznis modul (kategorija smještaj) ili zaseban tip — odluka u dizajnu, ali vizuelno konzistentno s biznis karticama.

## Komponente i interakcije
- Mini-mapa + link na [Mapu ponude](07-mapa-ponude.md).
- Povezivanje sa [Događajima](05-dogadjaji.md) (događaji na lokaciji) i [Pričama](08-price-iz-teslica.md).
- Galerija s lightboxom, video player.

## 🔗 Veze
[Mapa](07-mapa-ponude.md) · [Događaji](05-dogadjaji.md) · [Priče](08-price-iz-teslica.md) · [Domaće je najbolje (smještaj/usluge)](03-domace-je-najbolje.md)
