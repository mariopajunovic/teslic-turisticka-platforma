# Recept: 09 — Pridruži se (hub + forme)

📄 Spec: [stranice/09-pridruzi-se.md](../../stranice/09-pridruzi-se.md) · Tokeni: [00](../00-design-tokens.md) · Komponente: [01](../01-komponente.md)

> Crtamo **javne forme** (registracija biznisa/autora). Login i korisnički dashboardi su izvan opsega (account sistem).

## Artboardi
- `Pridruzi – Hub – Desktop` / `– Mobile`
- `Pridruzi – RegistrujBiznis – Desktop` / `– Mobile`
- `Pridruzi – Autor – Desktop` / `– Mobile`
- `Pridruzi – Forma – Uspjeh` · `Pridruzi – Forma – Greska`

---

## A) Hub
### Blokovi
1. `Header` + `Breadcrumb`
2. **Hero/split** — naslov + motivacioni uvod.
3. **Dvije putanje** — 2 velike `CTASekcija`/kartice: „🏪 Registruj biznis” i „✍️ Uključi se kao autor”, svaka s `Dugme/Primary`.
4. **Koristi** — lista benefita (ikona+tekst).
5. **Kako teče proces** — 3 koraka (1. prijava → 2. pregled → 3. odobrenje), horizontalni stepper.
6. `Footer`

---

## B) Forma „Registruj biznis”
`Forma` s `Polje`-ima (obavezna označena *):
- Naziv subjekta* · Kategorija* / Podkategorija* · Kratak i detaljan opis
- Adresa i lokacija* · Telefon* · E-mail* · Web/mreže · Radno vrijeme
- **Upload** fotografija/medija (drag&drop)
- Podaci kontakt osobe (ime, e-mail naloga)
- ☑ Saglasnost s uslovima i obradom podataka* (`Checkbox`)
- `Captcha`*
- `Dugme/Primary` „Pošalji prijavu”
- Ispod: **obavijest o načinu obrade prijave** (info tekst).

## C) Forma „Uključi se kao autor”
`Forma`:
- Ime i prezime* · E-mail* · Kratka biografija/oblast · Primjer rada/link
- Prilaganje dodatnih info (upload/tekst)
- ☑ Saglasnost* · `Captcha`* · `Dugme/Primary`

## Stanja
- Default · greška polja (inline, crveni border) · `slanje` (dugme disabled+spinner) · **Uspjeh** (`PorukaStanja` success: „Prijava primljena, ide na pregled administratora”).

## Responsive
- Hub dvije putanje 2→1; forme jedna kolona, polja puna širina; stepper vertikalan na mobilnom.

## Checklist
- [ ] Hub s dvije putanje + benefiti + proces.
- [ ] Obje forme sa svim poljima i upload-om.
- [ ] Saglasnost + Captcha na obje.
- [ ] Obavijest o obradi prijave.
- [ ] Stanja: greška + uspjeh.
- [ ] Desktop + Mobile.
