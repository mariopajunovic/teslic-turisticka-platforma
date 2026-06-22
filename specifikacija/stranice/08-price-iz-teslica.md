# 08 — Priče iz Teslića (blog)

📌 **TS 4.8** · **Pristup:** javno (čitanje); unos — autor/admin (uz moderaciju)

## Svrha
Blog/urednička sekcija: intervjui, reportaže, priče domaćina, biznisa i svakodnevice. Daje platformi „ljudski” ton i povezuje sadržaj (autori ↔ lokacije ↔ biznisi ↔ događaji).

## Podstranice / kategorije (📌 TS 4.2)
- **Domaćini pričaju**
- **Ljudi i biznisi**
- **Naša svakodnevica**

---

## A) Blog listing / kategorija
**Ruta:** `/price`, `/price/{kategorija}`

### Raspored
```
[ Naslov + istaknuta (featured) priča ]
[ FILTER: kategorija ▾ · autor ▾ · pretraga ⌕ ]
[ GRID KARTICA PRIČA:                          ]
   ┌───────────────────────┐
   │ [slika]               │
   │ Kategorija            │
   │ Naslov priče          │
   │ Autor · datum         │
   │ kratak izvod          │
   └───────────────────────┘
[ Paginacija / „učitaj još” ]
```

### Funkcionalnosti (🔴 — 📌 TS 4.8)
- Objava tekstualnih sadržaja u blog formatu.
- Filtriranje po kategoriji i autoru, pretraga.
- Prikaz autora i kategorije na kartici.

---

## B) Detalj priče
**Ruta:** `/prica/{slug}`

### Raspored
```
[ Naslov + kategorija + autor + datum ]
[ Naslovna slika / hero ]
┌──────────────────────────────────────────────────────────┐
│ TIJELO PRIČE (tekst, podnaslovi, citati, slike u tekstu)  │
│ + galerija fotografija / video                            │
└──────────────────────────────────────────────────────────┘
[ O autoru (kratka bio + foto) ]
[ POVEZANO: biznis(i) · lokacija · događaj iz priče ]
[ Srodne priče ]
```

### Sadržaj i veze (📌 TS 4.8)
- Unos intervjua, reportaža, priča domaćina, biznisa i svakodnevice.
- **Povezivanje priče s autorima, lokacijama, biznisima ili događajima.**
- Dodavanje galerija i video sadržaja.
- Prikaz autora priče i kategorije.

## Moderacija (🔴 — 📌 TS 4.8 / TS 8)
Sve priče prolaze **moderaciju i odobravanje prije objave**. Autor kreira/uređuje **vlastite** priče bez direktnog objavljivanja. Workflow: [12 — Uloge i workflow](../administracija/12-korisnicke-uloge-i-workflow.md).
> 🟡 Komentari su opcioni; ako se uključe, podliježu moderaciji (📌 TS 8).

## Komponente i interakcije
- Bogati tekst (WYSIWYG), slike u tekstu, citati, galerija, video.
- Blok „O autoru” s vezom na ostale priče autora.
- Povezani entiteti kao kartice (biznis/lokalitet/događaj).
- Dijeljenje na društvene mreže 🟡.

## Stanja
- Priča u statusu nacrt/na odobrenju — vidljiva samo autoru/adminu uz badge.
- Prazna kategorija → prazno stanje.

## 🔗 Veze
[Profil biznisa](03-domace-je-najbolje.md) · [Lokalitet](04-turizam-u-teslicu.md) · [Događaji](05-dogadjaji.md) · [Uključi se kao autor](09-pridruzi-se.md)
