# Recept: 06 — Poslovne prilike i oglasi (+ detalj)

📄 Spec: [stranice/06-poslovne-prilike-oglasi.md](../../stranice/06-poslovne-prilike-oglasi.md) · Tokeni: [00](../00-design-tokens.md) · Komponente: [01](../01-komponente.md)

## Artboardi
- `Oglasi – Lista – Desktop` / `– Mobile`
- `Oglasi – Detalj – Desktop` / `– Mobile`
- `Oglasi – Arhiva` (istekli) · `Oglasi – Prazno`

---

## A) Lista oglasa
### Blokovi
1. `Header` + `Breadcrumb`
2. **Naslov + opis** sekcije.
3. `FilterTraka` — vrsta oglasa ▾ (zapošljavanje/saradnja/usluge/konkursi), lokacija ▾, rok važenja ▾, `Pretraga`.
4. **Prebacivač** `[ Aktivni ] [ Arhiva ]`.
5. **Lista** `Kartica/Oglas` (kompaktni redovi): naslov, `Chip` vrste, izdavač · 📍 lokacija · ⏳ rok.
6. `Paginacija`.
7. `Footer`

---

## B) Detalj oglasa
### Blokovi
1. `Header` + `Breadcrumb`
2. **Naslov** + `Chip` vrste + `Badge` statusa (aktivan/`Isteklo`).
3. **Dvokolonski:**
   - Glavni stub: opis, uslovi/kvalifikacije, način prijave.
   - `InfoPanel`: izdavač (link → profil biznisa), 📍 lokacija + `MiniMapa`, ⏳ rok važenja, kontakt, `Dugme/Primary` „Prijavi se / Kontakt”.
4. `Footer`

## Stanja
- Aktivni / Arhiva (prebacivač).
- Istekao oglas → `Badge/Isteklo`, prigušen, akcija prijave onemogućena (`disabled`).
- `PraznoStanje` ako nema aktivnih → link na arhivu.

## Responsive
- Lista kao stack redova; `FilterTraka` → „Filteri” + `Drawer`.
- Detalj dvije kolone → jedna.

## Checklist
- [ ] Lista s naslovom, izdavačem, lokacijom, rokom.
- [ ] Kategorizacija (vrste) i filter po roku.
- [ ] Aktivni/Arhiva prebacivač + stanje „Isteklo”.
- [ ] Detalj: opis, uslovi, lokacija, rok, kontakt, veza na izdavača.
- [ ] Desktop + Mobile.
