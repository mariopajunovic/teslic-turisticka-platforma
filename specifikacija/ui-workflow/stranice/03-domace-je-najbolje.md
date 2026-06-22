# Recept: 03 — Domaće je najbolje (+ profil biznisa)

📄 Spec: [stranice/03-domace-je-najbolje.md](../../stranice/03-domace-je-najbolje.md) · Tokeni: [00](../00-design-tokens.md) · Komponente: [01](../01-komponente.md)

Dvije vrste ekrana: **A) Listing/kategorija** i **B) Profil biznisa (detalj)**.

## Artboardi
- `Domace – Listing – Desktop` (1440) / `– Mobile` (375)
- `Domace – Listing – Prazno` (prazna kategorija)
- `Domace – Listing – Ucitavanje` (Skeleton)
- `ProfilBiznisa – Default – Desktop` / `– Mobile`

---

## A) Listing / kategorija
### Blokovi
1. `Header` + `Breadcrumb`
2. **Hero/split** kratak: naslov kategorije + opis.
3. **Podsekcije** — `Chip`/pločice: Preporučeno · Zanatski proizvodi · Domaća hrana i piće · Usluge i servisi.
4. `FilterTraka` — kategorija ▾, podkategorija ▾, lokacija ▾, `Pretraga`, „Očisti filtere”.
5. `Grid` od `Kartica/Biznis` (3–4 kol). Preporučeni nose `Badge/Preporučeno`.
6. `Paginacija` ili `UcitajJos`.
7. `Footer`

### Stanja
- `PraznoStanje` (nema subjekata u kategoriji).
- `Skeleton` kartice tokom učitavanja.
- Filtrirano: aktivni `Chip/uklonjiv` iznad grida.

---

## B) Profil biznisa (detalj)
### Blokovi
1. `Header` + `Breadcrumb` (… / Domaće je najbolje / Naziv)
2. **Hero** — naslov (naziv) + `Galerija` (naslovna + sličice) + `Chip/kategorija` + opcioni `Badge/Preporučeno`.
3. **Dvokolonski layout:**
   - **Glavni stub:** detaljan opis (H2/H3 + body), `Galerija`, sekcija „Preporuke”.
   - **`InfoPanel` (bočno):** telefon, e-mail, web/mreže, radno vrijeme, adresa + `Dugme/Primary` „Pošalji upit” + `MiniMapa`.
4. **`PovezaniSadrzaj`** — događaji subjekta · priče · oglasi (redovi `Kartica/*`).
5. **Modal „Pošalji upit”** — `Forma` (ime, e-mail, poruka) + `Captcha` + `PorukaStanja`.
6. `Footer`

### Polja InfoPanela (obavezna iz spec-a)
telefon · e-mail · web/mreže · radno vrijeme · adresa · lokacija (mapa).

### Stanja
- Modal upita: default / greška polja / uspjeh (`PorukaStanja`).
- (Neobjavljen profil sa `Badge` statusa — relevantno za vlasnika/admina, ne za javni artboard.)

## Responsive
- Listing grid 4→2→1; `FilterTraka` → dugme „Filteri” + `Drawer/Filteri`.
- Profil: dvije kolone → jedna; `InfoPanel` ide ispod opisa, „Pošalji upit” lijepljiv (sticky) na dnu mobilnog.

## Checklist
- [ ] Listing: filteri, grid kartica, paginacija, prazno/učitavanje stanje.
- [ ] Profil: galerija, detaljan opis, InfoPanel sa svim obaveznim poljima, MiniMapa.
- [ ] „Pošalji upit” modal + Captcha + stanja.
- [ ] PovezaniSadrzaj.
- [ ] Preporučeno = accent badge.
- [ ] Desktop + Mobile za oba ekrana.
