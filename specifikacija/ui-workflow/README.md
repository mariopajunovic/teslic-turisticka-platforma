# UI Workflow — build-dokumentacija za agente (Pencil)

Ova dokumentacija je **uputstvo za agente** koji na osnovu [specifikacije](../README.md) izrađuju UI (wireframe / mockup) u **Pencil**-u, za svaku **javnu** stranicu platforme.

## Opseg (scope)
✅ **Ulazi u rad (javne stranice):**
`01 Početna · 02 O projektu · 03 Domaće je najbolje (+profil biznisa) · 04 Turizam (+detalj lokaliteta) · 05 Događaji · 06 Oglasi · 07 Mapa · 08 Priče (+detalj) · 09 Pridruži se (forme) · 10 Kontakt` + globalni **header/footer**.

❌ **Izvan opsega (ne crtati ovdje):**
Administrativni panel i management sistema/korisnika — [spec 11](../administracija/11-admin-panel.md), [12](../administracija/12-korisnicke-uloge-i-workflow.md), [13](../administracija/13-user-administracija.md). To je zaseban admin panel.
> Napomena: forme za registraciju na „Pridruži se” crtamo (javne su). Ali **prijava (login) i korisnički dashboardi** biznisa/autora idu u admin/account sistem → izvan opsega.

## Redoslijed čitanja za agenta (OBAVEZNO prije crtanja)
1. **[00 — Design tokens](00-design-tokens.md)** — boje (primarna `#00529c`), tipografija, razmaci, radijusi.
2. **[01 — Biblioteka komponenti](01-komponente.md)** — sve ponovljive komponente i njihove varijante/stanja.
3. **[02 — Globalni layout (header, footer, grid)](02-globalni-layout.md)** — okvir svake stranice.
4. **[03 — Konvencije fajlova i proces](03-konvencije-i-proces.md)** — kako segmentirati Pencil fajlove, verzionisanje i proces odobravanja.
5. **Recept stranice** iz [`stranice/`](stranice/) — konkretna stranica koja ti je dodijeljena.

## Workflow po stranici (kako agent radi)
```
KORAK 0  Radi u ZASEBNOM .pen fajlu za tu stranicu (ne zajednički fajl).
         Komponente referenciraj iz 00_Foundations. Vidi 03-konvencije-i-proces.md.
KORAK 1  Pročitaj spec stranice (link je u receptu) + ovaj recept.
KORAK 2  Postavi artboard-ove: Desktop 1440px I Mobile 375px (OBA su obavezna).
KORAK 3  Dodaj globalni Header (gore) i Footer (dole) iz komponenti.
KORAK 4  Slaži sekcije odozgo nadolje tačno po "Blokovi" listi recepta,
         koristeći POSTOJEĆE komponente iz 01-komponente.md (ne izmišljaj nove).
KORAK 5  Primijeni tokene (boje/tipografiju/razmake) iz 00-design-tokens.md.
KORAK 6  Nacrtaj tražena STANJA (prazno/učitavanje/greška/filtrirano) kao zasebne stranice u fajlu.
KORAK 7  Popuni placeholder sadržajem (realističan tekst na ijekavici, lokalni primjeri).
KORAK 8  Upiši status na fajl + zapis u CHANGELOG.md (hronologija).
KORAK 9  Provjeri "Checklist" na dnu recepta. Tek tada je stranica gotova.
```

> ⚠️ **Početna se radi prva i u 3 koncepta** → naručilac bira 1 → tek onda ostale stranice. Vidi [03 §4](03-konvencije-i-proces.md).
> ⚠️ **Mobilni prikaz je obavezan za svaku stranicu** — bez njega dizajn nije gotov. Vidi [03 §5](03-konvencije-i-proces.md).

## Pravila konzistentnosti (za sve agente)
- **Ne uvodi nove komponente** ako postoji odgovarajuća u [01-komponente.md](01-komponente.md). Ako stvarno fali — predloži dopunu te biblioteke, ne lokalnu varijantu.
- **Primarna boja `#00529c`** koristi se za primarne CTA, linkove, aktivna stanja, header akcente. Ne koristi proizvoljne boje.
- **Razmaci i grid** isključivo iz tokena (8px skala, 12-kolonski grid).
- **Naziv artboarda**: `Stranica – Varijanta – Breakpoint` (npr. `Pocetna – Default – Desktop`).
- **Naziv elementa** = ime komponente iz biblioteke (npr. `Kartica/Biznis`, `FilterTraka`, `Hero`).
- Sav tekst na **ijekavici**; lokalni primjeri (Teslić, Borje, Banja Vrućica…).

## Mapa dokumenata
| Dok | Sadržaj |
|-----|---------|
| [00-design-tokens.md](00-design-tokens.md) | boje, tipografija, razmaci, sjenke, radijusi, ikone |
| [01-komponente.md](01-komponente.md) | biblioteka UI komponenti + stanja |
| [02-globalni-layout.md](02-globalni-layout.md) | header, footer, grid, breakpointi |
| [03-konvencije-i-proces.md](03-konvencije-i-proces.md) | segmentacija fajlova, verzionisanje, proces odobravanja, 3 koncepta Početne, obavezni mobilni |
| [stranice/](stranice/) | recept za svaku javnu stranicu (01–10) |

## Definicija gotovog (Definition of Done) za stranicu
- [ ] **Zaseban `.pen` fajl** za stranicu (ne zajednički) — [03 §1](03-konvencije-i-proces.md).
- [ ] **Desktop 1440 + Mobile 375 artboard** (oba obavezna) — [03 §5](03-konvencije-i-proces.md).
- [ ] Header + Footer prisutni i tačni.
- [ ] Svi blokovi iz recepta postavljeni redom.
- [ ] Korišćene samo komponente iz biblioteke + tokeni.
- [ ] Sva tražena stanja nacrtana (kao zasebne stranice u fajlu).
- [ ] Primarna boja `#00529c` dosljedno primijenjena.
- [ ] Status upisan + zapis u CHANGELOG.md.
- [ ] Checklist recepta zadovoljen.
