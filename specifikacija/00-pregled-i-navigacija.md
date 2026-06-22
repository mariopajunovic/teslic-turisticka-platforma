# 00 — Pregled, navigacija i informaciona arhitektura

## Šta je platforma (📌 TS 1–2)
Centralno digitalno mjesto za promociju Teslića: lokalne zajednice, domaćih proizvoda, uslužnih djelatnosti, turističkih sadržaja, događaja i autentičnih priča — uz aktivno učešće registrovanih biznisa, domaćina i autora kroz **administrativno kontrolisan proces objavljivanja**.

Tri stuba sadržaja:
1. **Domaća ponuda** — biznisi, proizvodi, usluge.
2. **Turizam** — atrakcije, lokaliteti, smještaj, događaji.
3. **Priče i zajednica** — blog, ljudi, svakodnevica.

---

## Tipovi korisnika (ko koristi platformu)
| Korisnik | Pristup | Šta radi |
|----------|---------|----------|
| **Posjetilac (javnost)** | bez registracije | pregleda sav objavljeni sadržaj, pretražuje, koristi mapu, šalje upite/kontakt |
| **Biznis korisnik** | registracija + prijava | upravlja vlastitim profilom i objavama (bez direktnog objavljivanja) |
| **Autor** | registracija + prijava | kreira vlastite priče/blog (bez direktnog objavljivanja) |
| **Administrator** | prijava (backend) | upravlja svime, odobrava sadržaj |

Detalji prava: [12 — Korisničke uloge i workflow](administracija/12-korisnicke-uloge-i-workflow.md).

---

## Glavna navigacija (🔴 OBAVEZNO — 📌 TS 4.2)

```
Početna
O projektu
Domaće je najbolje ▾
   ├─ Preporučeno iz prve ruke
   ├─ Zanatski proizvodi
   ├─ Domaća hrana i piće
   └─ Usluge i servisi
Turizam u Tesliću ▾
   ├─ Prirodne atrakcije
   ├─ Kulturne manifestacije
   ├─ Planine, šume i sela
   └─ Gdje odsjesti
Događaji i dešavanja
Poslovne prilike i oglasi
Mapa ponude
Priče iz Teslića ▾
   ├─ Domaćini pričaju
   ├─ Ljudi i biznisi
   └─ Naša svakodnevica
Pridruži se ▾
   ├─ Registruj biznis
   └─ Uključi se kao autor
Kontakt
```

> „Poslovne prilike i oglasi” = objave javnih poziva, konkursa i oglasa poslodavaca za otvorena radna mjesta i drugih važnih informacija.

---

## Globalni header (na svim stranicama)
```
[ LOGO ]   Početna · Domaće je najbolje ▾ · Turizam ▾ · Događaji · Oglasi · Mapa · Priče ▾ · O projektu · Kontakt   [ ⌕ Pretraga ] [ Pridruži se ] [ Prijava/Profil ]
```
- Logo (lijevo) → vodi na Početnu.
- Glavni meni sa padajućim podmenijima za sekcije koje imaju podstranice.
- Ikona/polje **pretrage** kroz sav sadržaj.
- Istaknuto dugme **„Pridruži se”** (CTA).
- **Prijava / Moj profil** (za biznise i autore); kad je korisnik prijavljen prikazuje pristup vlastitom panelu.
- Mobilni: hamburger meni, sticky header.

## Globalni footer
Vidi [14 — Footer i globalni elementi](14-footer-i-globalni-elementi.md).

---

## Sitemap (kompletan)
```
/                              Početna
/o-projektu                    O projektu
/domace-je-najbolje            Listing (sve kategorije)
   /preporuceno-iz-prve-ruke   Kurirani izbor
   /zanatski-proizvodi         Kategorija
   /domaca-hrana-i-pice        Kategorija
   /usluge-i-servisi           Kategorija
   /biznis/{slug}              Profil biznisa (detalj)
/turizam                       Listing turizma
   /prirodne-atrakcije
   /kulturne-manifestacije
   /planine-sume-i-sela
   /gdje-odsjesti
   /lokalitet/{slug}           Detalj lokaliteta
/dogadjaji                     Lista + kalendar
   /dogadjaj/{slug}            Detalj događaja
/oglasi                        Lista oglasa
   /oglas/{slug}               Detalj oglasa
/mapa                          Interaktivna mapa
/price                         Blog listing
   /domacini-pricaju
   /ljudi-i-biznisi
   /nasa-svakodnevica
   /prica/{slug}               Detalj priče
/pridruzi-se                   Hub
   /registruj-biznis           Forma
   /ukljuci-se-kao-autor       Forma
/kontakt                       Kontakt forma

[Korisnički]  /prijava · /registracija · /moj-profil (dashboard biznisa/autora)
[Admin]       /admin (backend panel)
[Pravno]      /politika-privatnosti · /politika-kolacica · /uslovi-koristenja
```

---

## Sadržajni entiteti (osnova za dizajn kartica i detaljnih stranica)
Tokom dizajna svaki entitet ima **karticu** (u listama) i **detaljnu stranicu**:

| Entitet | Kartica (lista) | Detaljna stranica |
|---------|-----------------|-------------------|
| Biznis | naziv, kategorija, naslovna slika, kratak opis, lokacija | [03 — Profil biznisa](stranice/03-domace-je-najbolje.md) |
| Turistički lokalitet | naziv, tip, slika, kratak opis | [04 — Detalj lokaliteta](stranice/04-turizam-u-teslicu.md) |
| Događaj | datum, naziv, lokacija, slika | [05 — Detalj događaja](stranice/05-dogadjaji.md) |
| Oglas | naslov, izdavač, lokacija, rok | [06 — Detalj oglasa](stranice/06-poslovne-prilike-oglasi.md) |
| Priča | naslov, autor, kategorija, slika | [08 — Detalj priče](stranice/08-price-iz-teslica.md) |

Svi entiteti s lokacijom prikazuju se i na [Mapi ponude](stranice/07-mapa-ponude.md) i međusobno se povezuju (biznis ↔ događaj ↔ priča ↔ lokalitet).

---

## Globalna stanja (za sve liste/detalje) — bitno za dizajn
- **Prazno stanje** (nema rezultata / nema sadržaja u kategoriji).
- **Učitavanje** (skeleton/spinner).
- **Greška** (poruka + ponovni pokušaj).
- **Filtrirano stanje** (prikaz aktivnih filtera + „očisti filtere”).
- **Neobjavljen sadržaj** (vidljiv samo vlasniku/adminu uz oznaku statusa).

## Proširivost (📌 TS 9)
Dizajn predvidjeti tako da se lako dodaju nove stranice, kategorije, oznake, lokacije i vijesti, te da je rješenje **spremno za višejezičnost** (predvidjeti mjesto za prebacivanje jezika u headeru, makar i kasnije).
