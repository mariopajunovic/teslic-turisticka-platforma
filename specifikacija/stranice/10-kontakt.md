# 10 — Kontakt

📌 **TS 4.2** · **Ruta:** `/kontakt` · **Pristup:** javno

## Svrha
Direktan kanal za komunikaciju posjetilaca s turističkom organizacijom. Javna forma zaštićena CAPTCHA mehanizmom.

## Sadržaj i raspored
```
[ Naslov + kratak uvod ]
┌──────────────────────────────┬───────────────────────────┐
│ KONTAKT FORMA                 │ KONTAKT INFORMACIJE       │
│ · Ime i prezime 🔴            │ · Naziv ustanove          │
│ · E-mail 🔴                   │ · Adresa                  │
│ · Tema/predmet                │ · Telefon                 │
│ · Poruka 🔴                   │ · E-mail                  │
│ · ☑ saglasnost obrade 🔴      │ · Radno vrijeme           │
│ · CAPTCHA 🔴                  │ · Linkovi društvenih mreža│
│ [ Pošalji ]                   │                           │
└──────────────────────────────┴───────────────────────────┘
[ MAPA s lokacijom ustanove ]
```

## Funkcionalnosti
- Slanje poruke (na e-mail organizacije + evidencija u adminu 🟡).
- **CAPTCHA** na formi 🔴 (📌 TS 6) i rate limiting protiv spama.
- Validacija polja, inline greške.
- Potvrda uspješnog slanja / poruka greške.

## Podaci ustanove (iz tendera)
- JU Turistička organizacija općine Teslić
- Adresa: Svetog Save 15, 74270 Teslić
- Tel: +387 (0)53 / 430-058
- E-mail: turistorg.teslic@gmail.com

## Stanja
- Uspješno poslano (zelena potvrda).
- Greška validacije / CAPTCHA neuspješna.
- Greška slanja (pokušaj ponovo).

## 🔗 Veze
[Footer / pravne stranice](../14-footer-i-globalni-elementi.md) · [Sigurnost formi](../15-sigurnost-i-pristup.md)
