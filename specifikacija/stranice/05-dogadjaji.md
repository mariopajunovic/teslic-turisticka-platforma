# 05 — Događaji i dešavanja

📌 **TS 4.6** · **Pristup:** javno (čitanje); unos — admin (i/ili biznis uz odobrenje)

## Svrha
Pregled svih događaja i dešavanja u Tesliću, u **listi i kalendarskom formatu**, s filtriranjem i detaljnim stranicama.

## A) Pregled događaja
**Ruta:** `/dogadjaji`

### Raspored
```
[ Naslov + prebacivač prikaza:  [ Lista ] [ Kalendar ] ]
[ FILTER:  datum/period ▾ · kategorija ▾ · lokacija ▾ · pretraga ⌕ ]

PRIKAZ LISTA:                      PRIKAZ KALENDAR:
┌──────────────────────────┐      ┌─────────────────────────┐
│ [datum] Naziv događaja    │      │  Mjesečni kalendar      │
│ 📍 lokacija · vrijeme     │      │  s tačkama na danima    │
│ [slika] kratak opis       │      │  klik na dan → događaji │
└──────────────────────────┘      └─────────────────────────┘
[ Paginacija ]
```

### Funkcionalnosti (🔴 — 📌 TS 4.6)
- Unos i pregled događaja.
- Prikaz u **listi i kalendarskom formatu** (prebacivanje).
- Filtriranje po datumu, kategoriji ili lokaciji.
- Protekli događaji odvojeni/arhivirani; istaknuti nadolazeći.

---

## B) Detalj događaja
**Ruta:** `/dogadjaj/{slug}`

### Raspored
```
[ Hero: naziv + naslovna slika ]
┌──────────────────────────────┬───────────────────────────┐
│ OPIS DOGAĐAJA                 │ INFO PANEL                │
│ · detaljan opis programa      │ · 📅 datum                │
│ · galerija                    │ · ⏰ vrijeme              │
│                               │ · 📍 lokacija + mini-mapa │
│                               │ · kategorija              │
│                               │ · kontakt organizatora    │
│                               │ [ Dodaj u kalendar 🟡 ]   │
└──────────────────────────────┴───────────────────────────┘
[ POVEZANO: lokalitet · biznis-organizator · priče ]
```

### Obavezna polja detalja (📌 TS 4.6)
opis · datum · vrijeme · lokacija · galerija · kontakt organizatora.

## Komponente i interakcije
- Prebacivač lista/kalendar.
- Mini-mapa lokacije → [Mapa ponude](07-mapa-ponude.md).
- Povezivanje sa [lokalitetom](04-turizam-u-teslicu.md), [biznisom](03-domace-je-najbolje.md) i [pričama](08-price-iz-teslica.md).
- 🟡 dijeljenje, „dodaj u kalendar” (.ics).

## Stanja
- Nema nadolazećih događaja → prazno stanje + link na arhivu.
- Protekli događaj → vizuelno označen kao „završeno”.

## 🔗 Veze
[Turizam](04-turizam-u-teslicu.md) · [Mapa](07-mapa-ponude.md) · [Domaće je najbolje](03-domace-je-najbolje.md) · [Priče](08-price-iz-teslica.md)
