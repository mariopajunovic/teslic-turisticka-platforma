# Digitalna platforma za promociju turizma Teslića — Specifikacija za dizajn

> **Tender br. 106-1/26** — JU Turistička organizacija općine Teslić
> Predmet: izrada digitalne platforme za promociju turističke ponude grada Teslića, lokalnih proizvoda i usluga.

Ova dokumentacija razrađuje **šta platforma i svaka pojedinačna stranica treba da sadrži**, kao **pripremu za pencil / wireframe dizajn**. Fokus je na sadržaju, rasporedu sekcija, komponentama, poljima i interakcijama — ne na konkretnoj tehnologiji (izbor tehnologije je na ponuđaču).

Svaki dokument prati istu logiku, korisnu za skiciranje:
1. **Svrha** stranice i ko je koristi
2. **Sadržaj i raspored** (blokovi odozgo nadolje — osnova za wireframe)
3. **Komponente i interakcije**
4. **Polja / podaci** (gdje je relevantno)
5. **Stanja** (prazno, učitavanje, greška, neobjavljeno…)
6. **Veze** ka drugim stranicama
7. 📌 referenca na tačku tehničke specifikacije (TS)

---

## 📑 Sadržaj

### Osnova
- [00 — Pregled, navigacija i informaciona arhitektura](00-pregled-i-navigacija.md)

### 🛠 UI Workflow za agente (Pencil) — gradnja UI-a
> Build-dokumentacija koju koriste agenti za izradu UI-a/komponenti u Pencilu za svaku **javnu** stranicu (admin panel je izvan opsega). Primarna boja **#00529c**.
- [ui-workflow/](ui-workflow/README.md) — start (workflow, opseg, redoslijed)
- [ui-workflow/00 — Design tokens](ui-workflow/00-design-tokens.md) · [01 — Komponente](ui-workflow/01-komponente.md) · [02 — Globalni layout](ui-workflow/02-globalni-layout.md)
- [ui-workflow/stranice/](ui-workflow/stranice/) — recepti za stranice 01–10

### Javne stranice (stranica po stranica)
| # | Stranica | Podstranice / detalj | Fajl |
|---|----------|----------------------|------|
| 01 | Početna | — | [stranice/01-pocetna.md](stranice/01-pocetna.md) |
| 02 | O projektu | — | [stranice/02-o-projektu.md](stranice/02-o-projektu.md) |
| 03 | Domaće je najbolje | Preporučeno iz prve ruke · Zanatski proizvodi · Domaća hrana i piće · Usluge i servisi · **Profil biznisa** | [stranice/03-domace-je-najbolje.md](stranice/03-domace-je-najbolje.md) |
| 04 | Turizam u Tesliću | Prirodne atrakcije · Kulturne manifestacije · Planine, šume i sela · Gdje odsjesti · **Detalj lokaliteta** | [stranice/04-turizam-u-teslicu.md](stranice/04-turizam-u-teslicu.md) |
| 05 | Događaji i dešavanja | Lista · Kalendar · **Detalj događaja** | [stranice/05-dogadjaji.md](stranice/05-dogadjaji.md) |
| 06 | Poslovne prilike i oglasi | **Detalj oglasa** | [stranice/06-poslovne-prilike-oglasi.md](stranice/06-poslovne-prilike-oglasi.md) |
| 07 | Mapa ponude | — | [stranice/07-mapa-ponude.md](stranice/07-mapa-ponude.md) |
| 08 | Priče iz Teslića | Domaćini pričaju · Ljudi i biznisi · Naša svakodnevica · **Detalj priče** | [stranice/08-price-iz-teslica.md](stranice/08-price-iz-teslica.md) |
| 09 | Pridruži se | Registruj biznis · Uključi se kao autor | [stranice/09-pridruzi-se.md](stranice/09-pridruzi-se.md) |
| 10 | Kontakt | — | [stranice/10-kontakt.md](stranice/10-kontakt.md) |

### Administracija
- [11 — Administrativni panel (backend)](administracija/11-admin-panel.md)
- [12 — Korisničke uloge i workflow odobravanja](administracija/12-korisnicke-uloge-i-workflow.md)
- [13 — User administracija (registracija, prijava, korisnički nalozi biznisa i autora)](administracija/13-user-administracija.md)

### Globalno i smjernice
- [14 — Footer i globalni elementi](14-footer-i-globalni-elementi.md)
- [15 — Sigurnost i kontrola pristupa (sa stanovišta korisnika)](15-sigurnost-i-pristup.md)
- [16 — Dizajn i UX smjernice](16-dizajn-i-ux-smjernice.md)
- [17 — Tokovi i dijagrami (user flows)](17-tokovi-i-dijagrami.md)

---

## Legenda
- 🔴 **Obavezno** — eksplicitno traženo tenderom
- 🟡 **Preporuka** — dopuna radi kvaliteta/UX
- 🔗 **Veza** — povezanost s drugom stranicom/modulom
- 📌 **TS x.x** — referenca na tačku tehničke specifikacije iz tendera
