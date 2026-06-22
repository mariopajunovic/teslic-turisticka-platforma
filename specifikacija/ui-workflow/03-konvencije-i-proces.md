# 03 — Konvencije fajlova i proces dizajna

Ovaj dokument definiše **kako organizujemo Pencil fajlove** (da ništa nije „nabacano” u jedan fajl), **hronologiju/verzionisanje**, i **proces odobravanja** (uključujući 3 predloga za Početnu).

---

## 1. Segmentacija: jedan Pencil fajl po stranici (OBAVEZNO)

- Ekstenzija fajlova je **`.pen`**.
- ❌ NE: sve stranice u jednom `.pen` fajlu.
- ✅ DA: **jedan `.pen` fajl = jedna stranica/cjelina**. Zajedničke stvari u zasebnom „Foundations” fajlu.

### Lokacija (OBAVEZNO)
Svi `.pen` fajlovi idu u folder **`pencil/` u korijenu projekta — IZVAN `specifikacija/`**:
```
Turisticka/                  (korijen projekta)
├── specifikacija/           ← dokumentacija (NE stavljati .pen ovdje)
└── pencil/                  ← svi .pen fajlovi (struktura ispod)
```
Iz `ui-workflow/` dokumenata relativna putanja do dizajna je `../../pencil/`.

### Struktura foldera `pencil/`
```
pencil/
├── 00_Foundations.pen        ← tokeni, header, footer, master komponente
├── 01_Pocetna.pen
├── 02_O-projektu.pen
├── 03_Domace-je-najbolje.pen ← listing + profil biznisa (povezane cjeline)
├── 04_Turizam.pen            ← listing + detalj lokaliteta
├── 05_Dogadjaji.pen          ← lista + kalendar + detalj
├── 06_Oglasi.pen             ← lista + detalj
├── 07_Mapa.pen
├── 08_Price.pen              ← listing + detalj
├── 09_Pridruzi-se.pen        ← hub + forme
├── 10_Kontakt.pen
├── _koncepti/                   ← faza istraživanja (vidi §4)
│   └── 01_Pocetna_Koncepti.pen
├── _arhiva/                     ← stare verzije (vidi §3)
└── CHANGELOG.md                 ← hronologija odluka i verzija
```

### Unutar jednog `.pen` fajla — stranice (pages/tabovi)
Pencil podržava više **stranica** u fajlu. Koristimo ih za varijante stanja i breakpointe iste cjeline:
```
03_Domace-je-najbolje.pen
 ├─ Listing — Desktop
 ├─ Listing — Mobile
 ├─ Listing — Prazno
 ├─ Listing — Ucitavanje
 ├─ ProfilBiznisa — Desktop
 ├─ ProfilBiznisa — Mobile
 └─ ProfilBiznisa — Modal upita (uspjeh/greska)
```
Pravilo: **breakpointi i stanja = zasebne stranice u istom fajlu**, ne gomilanje na jednom platnu.

---

## 2. Konvencija imenovanja

| Nivo | Šablon | Primjer |
|------|--------|---------|
| Fajl | `NN_Naziv[_Sufiks].pen` | `01_Pocetna.pen` |
| Stranica (tab) u fajlu | `Cjelina — Breakpoint` ili `Cjelina — Stanje` | `Listing — Mobile` |
| Artboard | `Stranica – Varijanta – Breakpoint` | `Pocetna – KonceptA – Desktop` |
| Element/grupa | `Komponenta/Varijanta` (iz [01-komponente](01-komponente.md)) | `Kartica/Biznis`, `Hero`, `FilterTraka` |

- Bez razmaka u nazivu fajla (koristi `-` i `_`); brojčani prefiks `NN_` čuva redoslijed.
- Naziv elementa = ime komponente iz biblioteke (radi konzistentnosti i lakšeg pregleda).

---

## 3. Hronologija i verzionisanje

- **CHANGELOG.md** (u `pencil/`) je obavezan dnevnik: datum, fajl, šta je promijenjeno, ko/koji agent, status (`u izradi` / `na pregledu` / `odobreno`).
- **Verzije fajla:** kad se radi veća revizija, prethodnu verziju premjesti u `_arhiva/` sa sufiksom datuma: `01_Pocetna_2026-06-22.pen`. Aktivni fajl uvijek nosi čisto ime (`01_Pocetna.pen`).
- **Status na prvoj stranici fajla:** mali tekst-blok u uglu: `Status: na pregledu · v2 · 22.06.2026`.
- Ovako imamo hronologiju (šta je kad rađeno i odobreno) bez da je sve u jednom fajlu.

### Primjer zapisa u CHANGELOG.md
```
## 2026-06-22
- 00_Foundations.pen — postavljeni tokeni (#00529c) + header/footer + kartice. [odobreno]
- 01_Pocetna_Koncepti.pen — 3 koncepta Početne (A/B/C). [na pregledu]

## 2026-06-23
- 01_Pocetna.pen — usvojen Koncept B, prebačen u produkciju. [odobreno]
```

---

## 4. Proces dizajna i odobravanja

### Faza 0 — Foundations (prvo, jednom)
Napravi `00_Foundations.pen`: tokeni, header, footer, sve master komponente iz [01-komponente](01-komponente.md). Sve ostale stranice referenciraju ove komponente. → odobrenje prije nastavka.

### Faza 1 — Početna: 3 predloga → izbor 1 (OBAVEZNO)
Za **Početnu** prvo se rade **3 različita koncepta** dizajna:
```
_koncepti/01_Pocetna_Koncepti.pen
 ├─ Pocetna – KonceptA – Desktop   (+ KonceptA – Mobile)
 ├─ Pocetna – KonceptB – Desktop   (+ KonceptB – Mobile)
 └─ Pocetna – KonceptC – Desktop   (+ KonceptC – Mobile)
```
- Sva 3 koncepta koriste **iste tokene i komponente** (varira raspored, hijerarhija, ton hero sekcije, raspored sekcija) — ne izmišljaju se novi stilovi.
- Svaki koncept ima **i Desktop i Mobile** (vidi §5).
- **Pregled → naručilac/vlasnik bira 1.** Tek kad je izbor potvrđen:
  - usvojeni koncept se prebacuje u `01_Pocetna.pen` (produkcija) i dovršava sa svim stanjima,
  - odluka se upiše u CHANGELOG.md,
  - ostala 2 koncepta idu u `_arhiva/`.
- **Tek nakon usvajanja Početne** prelazi se na ostale stranice — usvojeni vizuelni smjer postaje obrazac za sve.

### Faza 2 — Ostale stranice (01-pocetna usvojen kao predložak)
Po jednu stranicu, redoslijedom iz [README workflow-a](README.md). Svaka: izrada → status `na pregledu` → odobrenje → CHANGELOG.

> Napomena: 3 predloga radimo **samo za Početnu** (zadaje vizuelni smjer). Ostale stranice se rade u 1 verziji prema usvojenom smjeru, osim ako se eksplicitno ne zatraži više varijanti.

---

## 5. Mobilni prikaz — OBAVEZNO za svaku stranicu

🔴 **Svaka stranica MORA imati i mobilni prikaz.** Dizajn nije gotov dok ne postoje oba:
- **Desktop 1440px** (sadržaj do 1200px)
- **Mobile 375px**
- Tablet 768px po potrebi.

Pravila (vidi i [02-globalni-layout](02-globalni-layout.md)):
- Header → hamburger + drawer; gridovi 4→2→1; `FilterTraka` → dugme „Filteri” + `Drawer`.
- Dodirne mete min. 44×44px; body tekst ostaje 16px.
- Bočni `InfoPanel` ide ispod glavnog sadržaja; primarni CTA može biti „sticky” na dnu.
- Mapa: full-screen + filteri/popup u bottom-sheet.

**Provjera pri pregledu (review):** ako nedostaje mobilni artboard za bilo koju cjelinu → stranica se vraća na doradu.

---

## Checklist procesa (po stranici)
- [ ] Zaseban `.pen` fajl (ne zajednički).
- [ ] Komponente referencirane iz `00_Foundations`.
- [ ] Desktop **i** Mobile prisutni.
- [ ] Sva tražena stanja kao zasebne stranice u fajlu.
- [ ] Status-blok na fajlu + zapis u CHANGELOG.md.
- [ ] (Početna) 3 koncepta → usvojen 1 → arhiva ostalih.
