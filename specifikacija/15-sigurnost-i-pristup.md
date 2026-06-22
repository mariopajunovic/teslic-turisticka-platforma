# 15 — Sigurnost i kontrola pristupa

📌 **TS 6 / TS 7 / TS 8**

> Napomena: tender ostavlja izbor tehnologije ponuđaču (📌 TS 17). Ovaj dokument opisuje **šta sistem mora omogućiti** sa stanovišta korisnika i dizajna ekrana — ne propisuje konkretne alate.

## Sigurnosni zahtjevi (🔴 minimum — 📌 TS 6)
| Zahtjev | Uticaj na dizajn / ekrane |
|---------|---------------------------|
| Jake administratorske lozinke | pravila pri kreiranju/izmjeni lozinke (indikator jačine) |
| **2FA za administratorske naloge** | korak verifikacije pri prijavi admina |
| Razdvojene uloge i prava pristupa | vidljivost funkcija po ulozi ([12](administracija/12-korisnicke-uloge-i-workflow.md)) |
| Evidencija prijava i aktivnosti | ekran [logova](administracija/11-admin-panel.md) |
| **CAPTCHA na svim javnim formama** | kontakt, registracija biznisa/autora, upit biznisu |
| Rate limiting (anti-spam, brute-force) | poruke pri previše pokušaja prijave/slanja |
| Zaštita od neovlaštenog pristupa, SQL injection, XSS i sl. | (implementaciono; bez UI) |
| Sigurnosna konfiguracija admin dijela | odvojen, zaštićen pristup `/admin` |
| Zaštita sesija i kontrola pristupa | istek sesije, sigurna odjava |
| **Privremena blokada/deaktivacija naloga** od admina | akcija u [upravljanju korisnicima](administracija/11-admin-panel.md) |

## Javne forme koje moraju biti zaštićene (CAPTCHA + rate limiting)
- [Kontakt forma](stranice/10-kontakt.md)
- [Registruj biznis](stranice/09-pridruzi-se.md)
- [Uključi se kao autor](stranice/09-pridruzi-se.md)
- „Pošalji upit” na [profilu biznisa](stranice/03-domace-je-najbolje.md)

## Kontrola pristupa po zonama
```
JAVNO            → sav objavljeni sadržaj, forme
PRIJAVLJEN USER  → vlastiti panel (biznis/autor), vlastiti sadržaj
ADMIN (+2FA)     → /admin: sve funkcije, odobravanja, korisnici, logovi
```

## Hosting i kontinuitet (📌 TS 7) — kontekst, ne UI
- Aktivan SSL; dnevni i sedmični backup baze i sistema; backup na odvojenoj lokaciji; mogućnost povrata; firewall; stabilno produkciono okruženje.
- Po primopredaji naručilac dobija sve pristupne podatke i administrativna prava (📌 TS 15).

## 🔗 Veze
[Uloge i workflow](administracija/12-korisnicke-uloge-i-workflow.md) · [User administracija](administracija/13-user-administracija.md) · [Admin panel](administracija/11-admin-panel.md)
