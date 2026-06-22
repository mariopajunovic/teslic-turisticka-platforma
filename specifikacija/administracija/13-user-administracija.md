# 13 — User administracija (nalozi biznisa i autora — frontend)

📌 **TS 4.10 / TS 5 / TS 6** · **Pristup:** registrovani biznis korisnici i autori

Ovaj dokument pokriva **korisnički (frontend) dio** upravljanja nalogom — ono što biznis korisnik i autor vide nakon registracije/prijave. Razlika od [admin panela](11-admin-panel.md): ovdje korisnik upravlja **samo svojim** sadržajem, bez prava objavljivanja.

## Korisnički tok (lifecycle)
```
Registracija (Pridruži se) → prijava na obradu kod admina → odobrenje naloga
   → prijava (login) → korisnički panel → kreiranje sadržaja (nacrt)
   → slanje na odobrenje → (admin) → objavljeno / vraćeno / odbijeno
```

---

## A) Registracija
**Ruta:** `/registracija` (i forme na [Pridruži se](../stranice/09-pridruzi-se.md))
- Dva tipa naloga: **biznis** i **autor**.
- Polja prema [Pridruži se](../stranice/09-pridruzi-se.md); obavezna saglasnost s uslovima i obradom podataka; **CAPTCHA** 🔴.
- Nakon slanja: poruka da prijava ide na pregled administratora (nalog neaktivan do odobrenja).

## B) Prijava (Login)
**Ruta:** `/prijava`
- Polja: e-mail/korisničko ime + lozinka.
- Linkovi: „Zaboravljena lozinka”, „Nemaš nalog? Pridruži se”.
- 🔴 Jake lozinke; zaštita od brute-force (rate limiting) (📌 TS 6).
- (Admini dodatno: 2FA — 📌 TS 6.)

## C) Korisnički panel — Biznis korisnik
**Ruta:** `/moj-profil`
```
[ Sidebar: Moj profil · Moje objave · Oglasi · Mediji · Postavke naloga ]
┌──────────────────────────────────────────────────────────┐
│ MOJ BIZNIS PROFIL                                          │
│  · uređivanje svih polja profila (vidi 03)                 │
│  · upload fotografija/medija                               │
│  · [ Sačuvaj kao nacrt ]  [ Pošalji na odobrenje ]         │
├──────────────────────────────────────────────────────────┤
│ MOJE OBJAVE (status badge: nacrt/na odobrenju/objavljeno/  │
│              odbijeno + razlog)                            │
│ MOJI OGLASI (kreiranje, rok važenja, status)               │
└──────────────────────────────────────────────────────────┘
```
- Upravlja **isključivo vlastitim** profilom i objavama (📌 TS 5).
- Vidi statuse i razloge odbijanja/vraćanja; može dorađivati i ponovo slati.

## D) Korisnički panel — Autor
**Ruta:** `/moj-profil`
```
[ Sidebar: Moje priče · Nova priča · Moj autorski profil · Postavke naloga ]
┌──────────────────────────────────────────────────────────┐
│ NOVA / UREDI PRIČA (WYSIWYG, galerija, povezivanje sa      │
│   biznisom/lokacijom/događajem)                            │
│  [ Sačuvaj nacrt ]  [ Pošalji na odobrenje ]               │
│ MOJE PRIČE (status badge + razlog ako odbijeno)            │
│ AUTORSKI PROFIL (bio, foto — prikazuje se uz priče)        │
└──────────────────────────────────────────────────────────┘
```
- Kreira/uređuje **vlastite** priče bez direktnog objavljivanja (📌 TS 5, TS 4.8).

## E) Postavke naloga (oba tipa)
- Izmjena osnovnih podataka, e-maila, lozinke.
- Obavijesti o statusu objava (e-mail) 🟡.

## Stanja i pravila
- Nalog „na odobrenju” → ograničen pristup dok admin ne odobri.
- **Blokiran/deaktiviran nalog** (od strane admina, 📌 TS 6) → korisnik se ne može prijaviti; jasna poruka.
- Korisnik nikad ne vidi tuđi sadržaj u panelu, niti dugme „Objavi”.
- Sesije zaštićene; odjava; istek sesije (📌 TS 6).

## 🔗 Veze
[Pridruži se](../stranice/09-pridruzi-se.md) · [Uloge i workflow](12-korisnicke-uloge-i-workflow.md) · [Admin panel](11-admin-panel.md) · [Profil biznisa](../stranice/03-domace-je-najbolje.md) · [Priče](../stranice/08-price-iz-teslica.md) · [Sigurnost](../15-sigurnost-i-pristup.md)
