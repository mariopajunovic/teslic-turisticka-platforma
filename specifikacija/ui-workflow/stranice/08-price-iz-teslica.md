# Recept: 08 — Priče iz Teslića (+ detalj priče)

📄 Spec: [stranice/08-price-iz-teslica.md](../../stranice/08-price-iz-teslica.md) · Tokeni: [00](../00-design-tokens.md) · Komponente: [01](../01-komponente.md)

## Artboardi
- `Price – Listing – Desktop` / `– Mobile`
- `Price – Detalj – Desktop` / `– Mobile`
- `Price – Prazno`

---

## A) Blog listing / kategorija
### Blokovi
1. `Header` + `Breadcrumb`
2. **Istaknuta priča** — `Kartica/Prica` var. `Featured` (puna širina).
3. **Podsekcije** — `Chip`: Domaćini pričaju · Ljudi i biznisi · Naša svakodnevica.
4. `FilterTraka` — kategorija ▾, autor ▾, `Pretraga`.
5. `Grid` `Kartica/Prica` (3 kol).
6. `Paginacija` / `UcitajJos`.
7. `Footer`

---

## B) Detalj priče
### Blokovi
1. `Header` + `Breadcrumb`
2. **Zaglavlje** — naslov H1, `Chip/kategorija`, autor + datum.
3. **Naslovna slika / Hero.**
4. **Tijelo priče** — bogat tekst (podnaslovi, citati, slike u tekstu) + `Galerija`/video. Širina čitanja ~720px.
5. **`BlokOAutoru`** — avatar, bio, link na ostale priče.
6. **`PovezaniSadrzaj`** — biznis(i) · lokacija · događaj iz priče.
7. **Srodne priče** — `Grid` `Kartica/Prica`.
8. `Footer`

## Stanja
- Prazna kategorija → `PraznoStanje`; učitavanje → `Skeleton`.
- (Neobjavljena priča sa `Badge` statusa — za autora/admina, ne za javni artboard.)

## Responsive
- Listing 3→2→1; detalj jedna kolona; tipografija čitljiva (body 16px).

## Checklist
- [ ] Featured priča + 3 podsekcije + filter (kategorija/autor).
- [ ] Detalj: tijelo, galerija/video, blok o autoru, povezani sadržaj, srodne priče.
- [ ] Desktop + Mobile.
