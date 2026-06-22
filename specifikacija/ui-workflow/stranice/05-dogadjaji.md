# Recept: 05 — Događaji i dešavanja (+ detalj)

📄 Spec: [stranice/05-dogadjaji.md](../../stranice/05-dogadjaji.md) · Tokeni: [00](../00-design-tokens.md) · Komponente: [01](../01-komponente.md)

## Artboardi
- `Dogadjaji – Lista – Desktop` / `– Mobile`
- `Dogadjaji – Kalendar – Desktop` / `– Mobile`
- `Dogadjaji – Detalj – Desktop` / `– Mobile`
- `Dogadjaji – Prazno`

---

## A) Pregled (lista / kalendar)
### Blokovi
1. `Header` + `Breadcrumb`
2. **Naslov + prebacivač prikaza** — segment kontrola `[ Lista ] [ Kalendar ]`.
3. `FilterTraka` — period/datum ▾, kategorija ▾, lokacija ▾, `Pretraga`.
4. **Prikaz LISTA:** `Grid`/stack `Kartica/Dogadjaj` (datumski blok istaknut).
   **Prikaz KALENDAR:** mjesečna mreža s tačkama na danima; klik na dan → lista događaja tog dana.
5. `Paginacija`.
6. `Footer`

---

## B) Detalj događaja
### Blokovi
1. `Header` + `Breadcrumb`
2. **Hero** — naziv + naslovna slika.
3. **Dvokolonski:**
   - Glavni stub: detaljan opis programa, `Galerija`.
   - `InfoPanel`: 📅 datum, ⏰ vrijeme, 📍 lokacija + `MiniMapa`, kategorija (chip), kontakt organizatora, `Dugme/Secondary` „Dodaj u kalendar”.
4. **`PovezaniSadrzaj`** — lokalitet · biznis-organizator · priče.
5. `Footer`

## Stanja
- Nema nadolazećih → `PraznoStanje` + link na arhivu.
- Protekli događaj → `Badge` „Završeno”, prigušeno.
- Kalendar: dan bez događaja neutralan; dan s događajima ima tačku/akcent.

## Responsive
- Prebacivač lista/kalendar ostaje; kalendar na mobilnom = kompaktan mjesečni prikaz ili lista po danu.
- Detalj dvije kolone → jedna.

## Checklist
- [ ] Lista i Kalendar prikaz (prebacivač).
- [ ] Filteri datum/kategorija/lokacija.
- [ ] Detalj: opis, datum, vrijeme, lokacija, galerija, kontakt organizatora.
- [ ] MiniMapa + PovezaniSadrzaj.
- [ ] Stanja (prazno, protekli).
- [ ] Desktop + Mobile.
