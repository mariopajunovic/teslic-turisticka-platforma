# 02 — Globalni layout (header, footer, grid)

Okvir koji se postavlja na **svaku** stranicu prije sekcija. Tokeni → [00](00-design-tokens.md), komponente → [01](01-komponente.md).

## Grid i širine
- **Grid:** 12 kolona. **Max širina sadržaja:** 1200px, centrirano; bočni padding 24px (desktop) / 16px (mobile).
- **Breakpointi (artboard širine):**
  - Mobile **375px** (obavezno)
  - Tablet 768px (po potrebi)
  - Desktop **1440px** (obavezno; sadržaj do 1200px)
- Vertikalni razmak između sekcija: 64px desktop / 40px mobile.

## `Header` (sticky, na svim stranicama)
```
DESKTOP (visina ~72px):
┌───────────────────────────────────────────────────────────────────────┐
│ [LOGO]   Početna  Domaće je najbolje▾  Turizam▾  Događaji  Oglasi       │
│          Mapa  Priče▾  O projektu  Kontakt        [⌕] [Pridruži se] [Prijava] │
└───────────────────────────────────────────────────────────────────────┘

MOBILE (visina ~56px):
┌─────────────────────────────────┐
│ [LOGO]              [⌕]   [≡]    │   ≡ → drawer s punom navigacijom + Pridruži se
└─────────────────────────────────┘
```
- Logo lijevo → Početna.
- Dropdown (▾) za sekcije s podstranicama: **Domaće je najbolje**, **Turizam**, **Priče**, **Pridruži se**.
- „Pridruži se” = `Dugme/Primary`. „Prijava” = `Dugme/Ghost` (vodi u account sistem — izvan opsega crtanja, ali link postoji).
- Sticky: pri skrolu blago smanjen + `shadow-sm`.
- Aktivna stavka navigacije obojena `primary`.

## `Footer` (na svim stranicama)
```
┌───────────────────────────────────────────────────────────────────────┐
│ [LOGO]            BRZI LINKOVI      ISTRAŽI           KONTAKT            │
│ kratak opis       Početna           Domaće je najbolje  Svetog Save 15   │
│ platforme         O projektu        Turizam             74270 Teslić     │
│ [FB] [IG] [YT]    Događaji          Mapa ponude         053/430-058      │
│                   Pridruži se       Priče               turistorg…@gmail │
├───────────────────────────────────────────────────────────────────────┤
│  LOGOTIPI PARTNERA PROJEKTA  (traka)                                    │
├───────────────────────────────────────────────────────────────────────┤
│  © 2026 TO Teslić · Politika privatnosti · Politika kolačića · Uslovi   │
└───────────────────────────────────────────────────────────────────────┘
```
- Obavezno (📌 spec): politika privatnosti, politika kolačića, uslovi korištenja, linkovi društvenih mreža, logotipi partnera.
- Pozadina: bijela ili `primary-darker` (tamna varijanta) — odabrati jednu i držati se dosljedno.
- Mobile: kolone se slažu vertikalno (akordeon ili stack).

## `CookieBanner`
Donja fiksna traka pri prvom posjetu (tekst + „Prihvati” + „Saznaj više”).

## Pravila postavljanja na artboard
1. Header gore (sticky), Footer dole — na svakoj stranici.
2. Sadržaj unutar 1200px kontejnera.
3. Razmaci i grid isključivo po tokenima.
4. Breadcrumb (`01-komponente`) na svim stranicama osim Početne.

## 🔗 Reference
[Spec: Pregled i navigacija](../00-pregled-i-navigacija.md) · [Spec: Footer](../14-footer-i-globalni-elementi.md)
