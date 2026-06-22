# Recept: 04 — Turizam u Tesliću (+ detalj lokaliteta)

📄 Spec: [stranice/04-turizam-u-teslicu.md](../../stranice/04-turizam-u-teslicu.md) · Tokeni: [00](../00-design-tokens.md) · Komponente: [01](../01-komponente.md)

Ekrani: **A) Listing turizma/kategorija**, **B) Detalj lokaliteta**, + napomena za podstranicu **Gdje odsjesti**.

## Artboardi
- `Turizam – Listing – Desktop` / `– Mobile`
- `Turizam – DetaljLokaliteta – Desktop` / `– Mobile`
- `Turizam – Listing – Prazno`

---

## A) Listing turizma
### Blokovi
1. `Header` + `Breadcrumb`
2. **Hero** velik s vizualom Teslića + kratak opis destinacije.
3. **4 velike pločice podsekcija**: Prirodne atrakcije · Kulturne manifestacije · Planine, šume i sela · Gdje odsjesti (svaka s vizualom).
4. `FilterTraka` (kategorija/lokacija/pretraga).
5. `Grid` `Kartica/Lokalitet`.
6. **Mapa isječak** — `MiniMapa`/`MapaInteraktivna` → „Otvori mapu”.
7. **Preporučene lokacije** — `Grid` istaknutih.
8. `Footer`

---

## B) Detalj lokaliteta
### Blokovi
1. `Header` + `Breadcrumb`
2. **Hero** — naziv + `Galerija` (foto/video, dronski snimci).
3. **Dvokolonski:**
   - Glavni stub: opis (šta je, zašto posjetiti), „kako doći/pristup”, savjeti.
   - `InfoPanel`: tip (chip), lokacija + `MiniMapa`, sezona/radno vrijeme, (opc.) ulaznice.
4. **`PovezaniSadrzaj`** — događaji na lokaciji · obližnji smještaj · priče.
5. **`Galerija`** (puna).
6. `Footer`

---

## Podstranica „Gdje odsjesti”
- Isti `Grid` obrazac, koristi `Kartica/Lokalitet` (ili `Kartica/Biznis` za smještaj) — vizuelno konzistentno s biznis karticama.

## Stanja
- Prazna kategorija → `PraznoStanje`; učitavanje → `Skeleton`.

## Responsive
- 4 pločice 4→2→1; detalj dvije kolone → jedna; InfoPanel ispod opisa.

## Checklist
- [ ] 4 podsekcije kao pločice.
- [ ] Listing grid + filter + mapa isječak + preporučene.
- [ ] Detalj: galerija, opis, InfoPanel, povezani sadržaji.
- [ ] „Gdje odsjesti” obrazac.
- [ ] Desktop + Mobile.
