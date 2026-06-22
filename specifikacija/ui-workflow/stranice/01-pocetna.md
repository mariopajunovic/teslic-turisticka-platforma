# Recept: 01 — Početna

📄 Spec: [stranice/01-pocetna.md](../../stranice/01-pocetna.md) · Tokeni: [00](../00-design-tokens.md) · Komponente: [01](../01-komponente.md) · Proces: [03](../03-konvencije-i-proces.md)

## ⚠️ Posebno: 3 koncepta → izbor 1
Početna se radi PRVA i u **3 koncepta** u fajlu `_koncepti/01_Pocetna_Koncepti.pen` (stranice: `KonceptA/B/C – Desktop` **i** `– Mobile`). Sva tri koriste iste tokene i komponente — variraju raspored, hijerarhiju i ton hero sekcije. Naručilac bira 1 → usvojeni se prebacuje u `01_Pocetna.pen` i dovršava sa svim stanjima; ostala 2 idu u `_arhiva/`; odluka u CHANGELOG.md. Tek tada kreću ostale stranice. Detalji: [03 §4](../03-konvencije-i-proces.md).

### Smjernice za 3 koncepta (da budu zaista različita)
- **Koncept A — „Klasičan/info”**: jak hero sa slikom + pločice kategorija odmah; struktura naglašava preglednost.
- **Koncept B — „Vizuelni/imerzivan”**: veliki foto/video hero preko cijele širine, sekcije s puno slike, mapa istaknuta.
- **Koncept C — „Sadržajni/storytelling”**: hero s naglaskom na priče i „Preporučeno iz prve ruke”, topliji ton.

## Artboardi (po usvajanju koncepta, u `01_Pocetna.pen`)
- `Pocetna – Default – Desktop` (1440)
- `Pocetna – Default – Mobile` (375) 🔴 obavezno

## Blokovi (odozgo nadolje) — komponente
1. `Header` (bez breadcrumba na Početnoj)
2. **Hero** — `Hero/Stranica` var. `slika-pozadina`: slogan (H1), promo poruka, 2 dugmeta (`Dugme/Primary` „Istraži ponudu”, `Dugme/Secondary` „Pridruži se”).
3. **Istaknute kategorije** — red od 4–6 `Chip`/pločica s ikonama (Domaće, Turizam, Događaji, Mapa, Priče, Oglasi).
4. **Lokalni proizvodi i usluge** — naslov H2 + `Grid` od 3–4 `Kartica/Biznis` + `Dugme/Ghost` „Vidi sve”.
5. **Preporučeno iz prve ruke** — `Grid` `Kartica/Biznis` s `Badge/Preporučeno` (accent). Pozadina `primary-tint`.
6. **Turističke atrakcije** — H2 + `Grid` `Kartica/Lokalitet` + „Vidi sve”.
7. **Mapa (isječak)** — `MiniMapa`/isječak `MapaInteraktivna` + „Otvori mapu”.
8. **Nadolazeći događaji** — H2 + 3–4 `Kartica/Dogadjaj` + „Kalendar događaja”.
9. **Priče iz Teslića** — H2 + `Grid` `Kartica/Prica` (3) + „Sve priče”.
10. **Galerija** — `Galerija` (mreža foto/video, dronski snimci).
11. **CTA registracija** — `CTASekcija` (`primary` pozadina): „Registruj svoj biznis” + „Postani autor”.
12. `Footer`

## Sadržaj (placeholderi)
Lokalni primjeri: med, rakija, domaći sir; Banja Vrućica, planina Borje, Očauš; manifestacije (npr. ljetni festival). Slogan tipa „Teslić — domaće, autentično, blizu”.

## Stanja (zasebni artboardi po potrebi)
- Sekcija bez sadržaja → sakriti ili `PraznoStanje`.
- `Skeleton` za dinamičke sekcije (proizvodi/događaji/priče).

## Responsive
- Hero: tekst preko slike → na mobilnom tekst ispod/preko s tamnijim overlay.
- Gridovi: 4→2→1 kolona. Carousel sa swipe na mobilnom za istaknute sekcije.

## Checklist
- [ ] 3 koncepta (A/B/C), svaki Desktop + Mobile, u `_koncepti/`.
- [ ] Usvojen 1 → prebačen u `01_Pocetna.pen`, ostali u `_arhiva/`, odluka u CHANGELOG.
- [ ] Svih 10 obaveznih elemenata spec-a prisutno.
- [ ] „Preporučeno” koristi accent badge.
- [ ] Svaka sekcija ima naslov + „Vidi sve”.
- [ ] CTA registracija u `primary`.
- [ ] Desktop + Mobile (oba obavezna).
