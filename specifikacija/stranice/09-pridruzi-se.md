# 09 — Pridruži se

📌 **TS 4.10** · **Pristup:** javno · **Ruta:** `/pridruzi-se`

## Svrha
Ulazna tačka za uključivanje zajednice. Sadrži kratko objašnjenje koristi i dvije forme: **registracija biznisa** i **prijava autora**. Obje prijave idu na administrativnu obradu (nema automatskog javnog objavljivanja).

## A) Hub stranica
### Raspored
```
[ Naslov + kratak motivacioni uvod ]
[ DVIJE PUTANJE (kartice/CTA):                       ]
   ┌─────────────────────────┐   ┌─────────────────────────┐
   │ 🏪 Registruj biznis     │   │ ✍️ Uključi se kao autor │
   │ koristi za biznise…     │   │ koristi za autore…       │
   │ [ Registruj se → ]      │   │ [ Prijavi se → ]         │
   └─────────────────────────┘   └─────────────────────────┘
[ „Koristi za korisnike koji se priključe” (lista benefita) ]
[ Kako teče proces (1. prijava → 2. pregled → 3. odobrenje) ]
```

---

## B) Forma „Registruj biznis”
**Ruta:** `/pridruzi-se/registruj-biznis`

### Polja (📌 TS 4.4 + TS 4.10 — osnovni podaci)
- Naziv subjekta 🔴
- Kategorija / podkategorija 🔴
- Kratak i detaljan opis
- Adresa i lokacija 🔴
- Kontakt telefon 🔴
- E-mail 🔴
- Web / društvene mreže
- Radno vrijeme
- Fotografije / prateći mediji (upload)
- Podaci kontakt osobe (ime, e-mail za nalog)
- ☑ Saglasnost s [uslovima](../14-footer-i-globalni-elementi.md) i obradom podataka 🔴
- **CAPTCHA** 🔴 (📌 TS 6)

## C) Forma „Uključi se kao autor”
**Ruta:** `/pridruzi-se/ukljuci-se-kao-autor`

### Polja
- Ime i prezime 🔴
- E-mail 🔴
- Kratka biografija / oblast interesa
- Primjer rada / link 🟡
- Prilaganje dodatnih informacija (upload/tekst)
- ☑ Saglasnost s uslovima i obradom podataka 🔴
- **CAPTCHA** 🔴

## Obavezni elementi stranice (📌 TS 4.10)
- Forma za registraciju biznisa.
- Forma za prijavu autora.
- Polja za unos osnovnih podataka.
- Mogućnost prilaganja dodatnih informacija.
- **Obavijest o načinu obrade prijave** (šta se dešava nakon slanja).
- Kratak prikaz koristi za korisnike koji se priključe.

## Interakcije i stanja
- Validacija polja, prikaz grešaka inline.
- Nakon slanja: poruka potvrde + objašnjenje da prijava ide na pregled administratora.
- Veza ka prijavi (login) za one koji već imaju nalog.
- Po odobrenju, korisnik dobija pristup [vlastitom panelu](../administracija/13-user-administracija.md).

## 🔗 Veze
[User administracija](../administracija/13-user-administracija.md) · [Uloge i workflow](../administracija/12-korisnicke-uloge-i-workflow.md) · [Profil biznisa](03-domace-je-najbolje.md) · [Priče](08-price-iz-teslica.md)
