# 06 — Poslovne prilike i oglasi

📌 **TS 4.7** · **Pristup:** javno (čitanje); unos — biznis korisnik/admin (uz odobrenje)

## Svrha
Objava javnih poziva, konkursa i oglasa poslodavaca za otvorena radna mjesta te drugih važnih poslovnih informacija. Oglasi imaju **rok važenja** i **automatski se arhiviraju** po isteku.

## A) Lista oglasa
**Ruta:** `/oglasi`

### Raspored
```
[ Naslov + opis sekcije ]
[ FILTER:  vrsta oglasa ▾ · lokacija ▾ · rok važenja ▾ · pretraga ⌕ ]
[ LISTA OGLASA (kartice/redovi):                              ]
   ┌──────────────────────────────────────────────┐
   │ Naslov oglasa                     [vrsta tag] │
   │ Izdavač · 📍 lokacija · ⏳ rok: dd.mm.gggg.   │
   │ kratak opis                                    │
   └──────────────────────────────────────────────┘
[ Prebacivač: Aktivni | Arhiva ]
[ Paginacija ]
```

### Funkcionalnosti (🔴 — 📌 TS 4.7)
- Unos i pregled oglasa / poslovnih prilika.
- **Kategorizacija**: zapošljavanje, saradnja, usluge, konkursi i sl.
- Prikaz u listi s osnovnim informacijama: **naslov, izdavač, lokacija, rok**.
- Filtriranje po vrsti oglasa, lokaciji i roku važenja.
- **Označavanje i automatsko arhiviranje isteklih oglasa.**
- Povezivanje oglasa s profilima poslovnih subjekata.
- Upravljanje i odobravanje objava od strane administratora.

---

## B) Detalj oglasa
**Ruta:** `/oglas/{slug}`

### Raspored
```
[ Naslov + vrsta (tag) + status (aktivan / istekao) ]
┌──────────────────────────────┬───────────────────────────┐
│ OPIS I USLOVI                 │ INFO PANEL                │
│ · detaljan opis               │ · izdavač (→ profil)      │
│ · uslovi / kvalifikacije      │ · 📍 lokacija + mini-mapa │
│ · način prijave               │ · ⏳ rok važenja          │
│                               │ · kontakt podaci          │
│                               │ [ Prijavi se / Kontakt ]  │
└──────────────────────────────┴───────────────────────────┘
```

### Obavezna polja (📌 TS 4.7)
opis · uslovi · lokacija · rok · kontakt podaci · vrsta · veza ka profilu izdavača.

## Komponente i interakcije
- Veza ka [profilu biznisa](03-domace-je-najbolje.md) koji je izdavač.
- Automatsko arhiviranje po isteku roka (oglas prelazi u „Arhiva”, ostaje čitljiv ali označen kao istekao).
- Filter „rok važenja” (npr. ističe ove sedmice / ovog mjeseca).

## Statusi
`nacrt → poslano na odobrenje → odobreno → objavljeno → odbijeno` → (po isteku roka) `arhivirano`.

## Stanja
- Nema aktivnih oglasa → prazno stanje + link na arhivu.
- Istekao oglas → badge „Isteklo”, onemogućena prijava.

## 🔗 Veze
[Profil biznisa](03-domace-je-najbolje.md) · [Mapa](07-mapa-ponude.md) · [Korisničke uloge / odobravanje](../administracija/12-korisnicke-uloge-i-workflow.md)
