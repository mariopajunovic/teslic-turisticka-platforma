# 03 — Domaće je najbolje (lokalni proizvodi i usluge)

📌 **TS 4.4** · **Pristup:** javno (čitanje); unos — biznis korisnik / admin

Glavni modul lokalne ponude. Sastoji se od: **listinga**, **podstranica po kategorijama**, sekcije **„Preporučeno iz prve ruke”** i **detaljnog profila biznisa**.

## Podstranice (📌 TS 4.2)
- **Preporučeno iz prve ruke** — kurirani izbor (admin ručno ističe subjekte/objave).
- **Zanatski proizvodi**
- **Domaća hrana i piće**
- **Usluge i servisi**

(Podkategorije se dodaju iz admina.)

---

## A) Listing / kategorija
**Ruta:** `/domace-je-najbolje`, `/domace-je-najbolje/{kategorija}`

### Raspored
```
[ Naslov sekcije + opis ]
[ FILTER TRAKA:  kategorija ▾ · podkategorija ▾ · lokacija ▾ · pretraga ⌕ ]
[ (opciono) prečice na podkategorije / tagove ]
[ GRID KARTICA BIZNISA ]
   ┌───────────────┐  svaka kartica:
   │ [slika]       │  · naslovna fotografija
   │ Naziv         │  · naziv subjekta
   │ Kategorija    │  · kategorija/podkategorija
   │ kratak opis   │  · kratak opis
   │ 📍 lokacija   │  · lokacija + (oznaka „Preporučeno”)
   └───────────────┘
[ Paginacija / „učitaj još” ]
```

### Funkcionalnosti (🔴 — 📌 TS 4.4)
- Kategorizovan prikaz subjekata i ponude.
- Filtriranje po kategorijama i podkategorijama.
- Sortiranje (najnoviji / abecedno) i pretraga.
- Kartica → profil biznisa.

---

## B) Profil biznisa (detaljna stranica) 🔴
**Ruta:** `/biznis/{slug}`

### Raspored
```
[ Naslov + naslovna fotografija/galerija (hero) ]
[ Kratak opis / oznaka kategorije + „Preporučeno iz prve ruke” ]
┌──────────────────────────────┬───────────────────────────┐
│ DETALJAN OPIS (glavni stub)   │ KONTAKT PANEL (bočno)     │
│ · tekst, podnaslovi           │ · telefon                 │
│ · galerija fotografija/video  │ · e-mail                  │
│ · preporuke                   │ · web / društvene mreže   │
│                               │ · radno vrijeme           │
│                               │ · adresa                  │
│                               │ [ Dugme: Pošalji upit ]   │
│                               │ [ MINI-MAPA s lokacijom ] │
└──────────────────────────────┴───────────────────────────┘
[ POVEZANI SADRŽAJI: događaji subjekta · priče · oglasi ]
```

### Obavezna polja profila (📌 TS 4.4)
| Polje | Obavezno | Namjena u dizajnu |
|-------|----------|-------------------|
| Naziv subjekta | 🔴 | naslov |
| Kratak opis | 🔴 | kartica/hero |
| Detaljan opis | 🔴 | glavni stub (WYSIWYG) |
| Kategorija | 🔴 | filter/oznaka |
| Podkategorija | 🔴 | filter/oznaka |
| Adresa | 🔴 | kontakt panel |
| Lokacija (koordinate) | 🔴 | mini-mapa + [Mapa ponude](07-mapa-ponude.md) |
| Kontakt telefon | 🔴 | kontakt panel |
| E-mail | 🔴 | kontakt panel / upit |
| Web ili društvene mreže | 🔴 | kontakt panel |
| Radno vrijeme | 🔴 | kontakt panel |
| Fotografije i prateći mediji | 🔴 | galerija |
| Preporuke | 🟡 | sekcija preporuka |

### Komponente i interakcije
- **„Pošalji upit”** — forma/dugme (ime, e-mail, poruka) sa CAPTCHA zaštitom (📌 TS 6). Šalje upit subjektu/adminu.
- **Mini-mapa** s pinom; klik → otvara [Mapu ponude](07-mapa-ponude.md) fokusiranu na subjekt.
- Galerija s lightboxom; video inline.
- Dijeljenje na društvene mreže 🟡.

## Statusi objave (📌 TS 4.4)
`nacrt → poslano na odobrenje → odobreno → objavljeno → odbijeno`
Profil kreira/uređuje biznis korisnik (**samo vlastiti**); objava prolazi [odobrenje admina](../administracija/12-korisnicke-uloge-i-workflow.md). Vidi i [User administracija](../administracija/13-user-administracija.md).

## Stanja
- Prazna kategorija (nema subjekata).
- Profil u statusu nacrt/na odobrenju — vidljiv samo vlasniku/adminu uz badge statusa.

## 🔗 Veze
[Mapa](07-mapa-ponude.md) · [Događaji](05-dogadjaji.md) · [Oglasi](06-poslovne-prilike-oglasi.md) · [Priče](08-price-iz-teslica.md) · [Registruj biznis](09-pridruzi-se.md)
