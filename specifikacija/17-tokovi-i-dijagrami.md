# 17 — Tokovi i dijagrami (user flows)

📌 Sinteza preko TS 4–8 · Svrha: prikaz kompletnih korisničkih putanja prije skiciranja ekrana.

Legenda: `(ekran)` · `[akcija]` · `<odluka>` · `→` tok · `⇢` automatski/sistemski.

---

## 1. Biznis korisnik — od registracije do objave (glavni tok)
```
(Pridruži se) → [Registruj biznis: popuni formu + CAPTCHA] → [Pošalji]
   ⇢ prijava ide adminu, nalog "na odobrenju"
   → (Potvrda: prijava primljena)

(Admin: Korisnici) → <odobriti nalog?>
   ├─ DA  → nalog aktivan ⇢ e-mail korisniku
   └─ NE  → odbijen (razlog)

[Korisnik se prijavi] → (Moj profil)
   → [Uredi biznis profil: opis, galerija, kontakt, lokacija]
   → <sačuvati ili poslati?>
        ├─ [Sačuvaj nacrt]        → status: NACRT
        └─ [Pošalji na odobrenje] → status: POSLANO NA ODOBRENJE

(Admin: Odobravanja) → [Pregled] → <odluka>
   ├─ [Odobri i objavi] → OBJAVLJENO ⇢ javno na sajtu + na mapi
   ├─ [Vrati na doradu (razlog)] → NACRT (korisnik dorađuje → ponovo šalje)
   └─ [Odbij (razlog)] → ODBIJENO ⇢ obavijest korisniku
```

---

## 2. Autor — kreiranje priče
```
(Pridruži se) → [Uključi se kao autor + CAPTCHA] → [Pošalji]
   ⇢ admin odobrava nalog → [prijava] → (Moj profil – Autor)
   → [Nova priča: tekst, galerija, poveži biznis/lokaciju/događaj]
   → [Pošalji na odobrenje] → (Admin moderacija)
        ├─ Odobri → OBJAVLJENO (priča vidljiva, autor prikazan)
        ├─ Vrati  → dorada
        └─ Odbij  → obavijest s razlogom
```

---

## 3. Posjetilac (javnost) — istraživanje ponude
```
(Početna)
   ├─ → (Domaće je najbolje) → [filter kategorija] → (Profil biznisa)
   │        → [Pošalji upit + CAPTCHA] ⇢ upit ide subjektu/adminu
   ├─ → (Turizam) → (Detalj lokaliteta) → povezani (Događaji)/(Priče)
   ├─ → (Mapa) → [klik na pin] → popup → (Detaljna stranica)
   ├─ → (Događaji) → [Lista/Kalendar] → (Detalj događaja)
   ├─ → (Oglasi) → [filter] → (Detalj oglasa) → [Prijavi se/Kontakt]
   └─ → (Priče) → (Detalj priče)
(svuda) → [Pretraga] · (Kontakt) → [forma + CAPTCHA]
```

---

## 4. Admin — moderacija (centralni tok kontrole)
```
(Admin login + 2FA) → (Dashboard: red čekanja + brojači + log)
   → (Odobravanja) → po stavci [Pregled] → <Odobri | Vrati | Odbij>
   → (Korisnici) → [odobri nalog | blokiraj/deaktiviraj | uloga]
   → (Mapa) → [dodaj/uredi lokaciju + koordinate]
   → (Kategorije/Oznake) → [CRUD]
   → (Mediji) → [upload/organizuj]
   ⇢ svaka radnja se upisuje u (Logove aktivnosti)
```

---

## 5. Životni ciklus sadržaja (status mašina)
Primjenjivo na: biznis profil · oglas · priča.
```
        ┌────────── vrati na doradu (razlog) ──────────┐
        ▼                                              │
   ┌─────────┐  pošalji   ┌──────────────────┐  odluka │
   │  NACRT  │ ─────────► │ POSLANO NA ODOBR. │ ────────┤
   └─────────┘            └──────────────────┘         │
        ▲                          │ odobri            │ odbij (razlog)
        │ dorada                   ▼                   ▼
        │                    ┌──────────┐        ┌──────────┐
        └─────────────────── │ OBJAVLJENO│       │ ODBIJENO │
                             └────┬─────┘        └──────────┘
                  (samo oglas)    │ istek roka
                                  ▼
                            ┌────────────┐
                            │ ARHIVIRANO │
                            └────────────┘
```

---

## 6. Oglas — ciklus roka važenja
```
[Biznis kreira oglas + rok] → (odobrenje) → OBJAVLJEN (Aktivni)
   ⇢ <datum > rok važenja?>
        └─ DA → ⇢ AUTOMATSKO ARHIVIRANJE → prikaz u "Arhiva", badge "Isteklo",
                 prijava onemogućena
```

---

## 7. Mapiranje statusa na vidljivost (za dizajn badge-eva)
| Status | Javnost vidi? | Vlasnik/Autor vidi? | Admin vidi? | Badge |
|--------|:-------------:|:-------------------:|:-----------:|-------|
| Nacrt | ❌ | ✅ | ✅ | sivi „Nacrt” |
| Poslano na odobrenje | ❌ | ✅ | ✅ (red čekanja) | žuti „Na odobrenju” |
| Objavljeno | ✅ | ✅ | ✅ | zeleni / bez badge-a |
| Odbijeno | ❌ | ✅ (+razlog) | ✅ | crveni „Odbijeno” |
| Arhivirano (oglas) | ✅ (arhiva) | ✅ | ✅ | sivi „Isteklo” |

## 🔗 Veze
[Uloge i workflow](administracija/12-korisnicke-uloge-i-workflow.md) · [User administracija](administracija/13-user-administracija.md) · [Admin panel](administracija/11-admin-panel.md) · [Oglasi](stranice/06-poslovne-prilike-oglasi.md)
