# 11 — Administrativni panel (backend)

📌 **TS 4.11 / TS 8** · **Pristup:** samo administrator (prijava + 2FA — 📌 TS 6)

## Svrha
Zatvoreni administrativni dio za potpuno samostalno upravljanje platformom od strane naručioca — sadržajem, korisnicima, odobravanjem, mapom, medijima i postavkama — **bez potrebe za programerskim intervencijama** za osnovne radnje (📌 TS 4.1).

## Glavni meni admin panela (predlog strukture)
```
🏠 Kontrolna tabla (Dashboard)
📝 Sadržaj
   ├─ Stranice (statične: Početna, O projektu…)
   ├─ Biznisi / profili
   ├─ Turistički lokaliteti
   ├─ Događaji
   ├─ Oglasi
   ├─ Priče (blog)
   └─ Vijesti
✅ Odobravanja (red čekanja: na odobrenju)
👥 Korisnici i uloge
🗺️ Mapa / Lokacije
🖼️ Medijska biblioteka
🏷️ Kategorije, oznake, podkategorije
📊 Logovi aktivnosti
⚙️ Postavke sistema
```

## Obavezne funkcije (🔴 — 📌 TS 4.11)
1. Upravljanje svim stranicama i sadržajima.
2. Upravljanje korisnicima i korisničkim ulogama.
3. Pregled i odobravanje sadržaja biznis korisnika i autora.
4. Upravljanje događajima, mapom i medijskim sadržajem.
5. **Pregled logova aktivnosti korisnika.**
6. Osnovno upravljanje postavkama sistema.
7. Dodavanje novih stranica i vijesti.
8. Upravljanje kategorijama, oznakama i lokacijama.

---

## Ključni ekrani (za dizajn)

### A) Kontrolna tabla (Dashboard)
```
[ Brojači: sadržaj na odobrenju · novi korisnici · aktivni oglasi · događaji ]
[ Red čekanja za odobravanje (najnovije) ]
[ Posljednje aktivnosti (log izvod) ]
[ Brze akcije: + Nova stranica · + Događaj · + Vijest ]
```

### B) Lista sadržaja (univerzalni obrazac)
```
[ Filteri: status ▾ · kategorija ▾ · autor ▾ · pretraga ⌕ ]
[ Tabela: Naslov | Tip | Autor | Status (badge) | Datum | Akcije ]
   Akcije: Pregledaj · Uredi · Odobri · Odbij · Objavi · Arhiviraj · Obriši
[ Masovne akcije (bulk) ]
```

### C) Ekran odobravanja (📌 TS 8)
```
[ Pregled predloženog sadržaja (preview kao na frontu) ]
[ Meta: autor, datum, tip, kategorija ]
[ Akcije:  ✅ Odobri i objavi  ·  ↩️ Vrati na doradu (sa razlogom)  ·  ❌ Odbij (sa razlogom) ]
[ Polje za komentar/razlog (obavezno pri odbijanju/vraćanju) ]
```

### D) Upravljanje korisnicima
```
[ Lista: Ime | E-mail | Uloga | Status (aktivan/blokiran) | Zadnja prijava ]
[ Akcije: Uredi ulogu · Blokiraj/Deaktiviraj · Resetuj lozinku ]
```
Vidi [12 — Uloge i workflow](12-korisnicke-uloge-i-workflow.md) i [13 — User administracija](13-user-administracija.md).

### E) Mapa / lokacije
- Dodavanje/uređivanje tačaka, unos koordinata (klik na mapu ili unos lat/lng), dodjela kategorije i veze ka entitetu (📌 TS 4.9).

### F) Medijska biblioteka
- Upload, organizacija i pregled fotografija/videa (uklj. produkcijske i dronske materijale); dodjela medija sadržaju.

### G) Kategorije / oznake / lokacije
- CRUD za kategorije i podkategorije po modulima, oznake (tagovi), lokacije.

### H) Logovi aktivnosti (📌 TS 4.11 / TS 6)
```
[ Filteri: korisnik ▾ · tip akcije ▾ · datum ▾ ]
[ Tabela: Vrijeme | Korisnik | Akcija | Entitet | IP 🟡 ]
```
Evidencija prijava i ključnih administrativnih radnji.

### I) Postavke sistema
- Osnovne postavke (logo, kontakt, društvene mreže, footer linkovi, partneri), upravljanje pravnim stranicama, (priprema za) jezike.

## Stanja i pravila
- Red čekanja prazan → poruka „nema sadržaja na odobravanju”.
- Pri odbijanju/vraćanju razlog je obavezan (ide autoru).
- Sve radnje upisuju se u log.

## 🔗 Veze
[Uloge i workflow](12-korisnicke-uloge-i-workflow.md) · [User administracija](13-user-administracija.md) · [Sigurnost](../15-sigurnost-i-pristup.md) · sve javne stranice (izvor sadržaja)
