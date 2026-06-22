# 00 — Design tokens

Vrijednosti koje agenti primjenjuju u Pencilu. **Ne odstupati** od ovih vrijednosti bez dopune ovog dokumenta.

## Boje

### Primarna (brend) — transformativni teal
> **2026-06-22:** smjer brenda: institucionalna plava (#00529C) → kratko šumska zelena → **deep teal** (usklađeno s 2026 trendovima). Teal („Transformative Teal", WGSN/Coloro 2026) spaja Banju Vrućicu (termalna voda) i šume/planine, djeluje premium i „pouzdano za rezervacije". **Uparena s logom TO Teslić** (slovo „t" je teal), uz lime kao sekundarnu (vidi ispod). ⚠️ Potvrditi s naručiocem (tender je referencirao #00529C).
| Token | HEX | Upotreba |
|-------|-----|----------|
| `primary` | **#0E8275** | primarna CTA dugmad, linkovi, aktivna navigacija, header akcenti, naslovi sekcija (po potrebi) |
| `primary-dark` | **#0A645A** | hover/pressed na primarnim elementima |
| `primary-darker` | **#06443D** | footer pozadina (opciono), pressed |
| `primary-tint` | **#E1F4F1** | svijetle pozadine sekcija, hover redova, chip pozadina |
| `primary-tint-2` | **#BCE6DF** | borderi/odvajanja u teal zonama |

### Sekundarna — logo lime 🆕
> Uparena s logom TO Teslić (teal „t" + lime). Lime je „pop" akcent; uvijek **tamni tekst** (lime je presvijetla za bijeli).
| Token | HEX | Upotreba |
|-------|-----|----------|
| `secondary` | **#C8D848** | sekundarne CTA (npr. „Pridruži se"), highlight, dekorativni akcenti, aktivni map-pinovi |
| `secondary-dark` | **#A7B82E** | hover na sekundarnom |
| `secondary-tint` | **#F2F6D2** | svijetle lime pozadine/sekcije |

### Accent — vedra logo narandža
| Token | HEX | Upotreba |
|-------|-----|----------|
| `accent` | **#E88828** | „Preporučeno iz prve ruke” oznake, istaknuti badge događaja, CTA naglasci. Vedra logo-narandža; na punom accentu = **tamni tekst** (`heading`, AA 6.9) |
| `accent-dark` | **#C46E12** | hover na punom accentu (tamni tekst, AA) |
| `accent-deep` | **#8F5210** | tekst „Preporučeno" badge-a na `accent-tint`; bijeli-tekst konteksti |

> **2026-06-22:** accent usklađen s logom TO Teslić — vedra narandža (#E88828). Puni accent koristi tamni tekst; badge koristi `accent-tint` + `accent-deep` tekst + svijetlu tačkicu.

### Neutralne
| Token | HEX | Upotreba |
|-------|-----|----------|
| `text` | #20242C | osnovni tekst (hladna slate skoro-crna) |
| `heading` | #12151C | naslovi (hladna duboka slate) |
| `text-muted` | #5C6573 | meta, sekundarni tekst (cool slate siva) |
| `border` | #DCE0E6 | linije, okviri kartica (cool light) |
| `surface` | #FFFFFF | kartice, pozadina sadržaja |
| `surface-alt` | #F3F5F8 | pozadina stranice / izmjeničnih sekcija (cool off-white) |
| `overlay` | rgba(18,21,28,.6) | lightbox/modal pozadina |

> **Hladne neutralne** (slate) odabrane namjerno: čine da vivid teal/lime/narandža iskaču — vesela atmosfera kao u logu.

### Statusne (badge, poruke)
| Token | HEX | Značenje |
|-------|-----|----------|
| `success` | #1E7D3C | objavljeno / uspjeh (vivid zelena) |
| `warning` | #8C5810 | na odobrenju / upozorenje (amber) |
| `error` | #C62828 | odbijeno / greška (vivid crvena) |
| `info` | #1C68B5 | informacije (vivid plava) |
| `neutral-badge` | #5C6573 | nacrt / isteklo (cool slate) |

> **Tinted stil (badge/alert):** status oznake i poruke se crtaju kao **svijetla tint pozadina + jak tekst iste boje + tačkica** — veselije i lakše od punih tamnih blokova, uz AA kontrast.

### Tintovi (svijetle pozadine) 🆕
| Token | HEX | Upotreba |
|-------|-----|----------|
| `accent-tint` | #FCEBCF | pozadina „Preporučeno", topli highlight |
| `success-tint` | #DCF3E2 | pozadina success badge/alert |
| `warning-tint` | #FBEECB | pozadina warning badge/alert |
| `error-tint` | #FBE3E3 | pozadina error badge/alert |
| `info-tint` | #DEEDFB | pozadina info badge/alert |
| `neutral-tint` | #E9EBEF | pozadina neutral badge (nacrt/isteklo) |

## Tipografija
- **Font:** sans-serif, humanistički (npr. *Inter*, *Source Sans*, *Open Sans*) — podržava naša slova (č ć đ š ž).
- Naslovi mogu koristiti isti font, bold; opciono jedan „karakterniji” za hero naslov.

| Stil | Veličina / line-height | Težina |
|------|------------------------|--------|
| H1 / Hero | 40–48px / 1.15 | 700 |
| H2 (sekcija) | 30–32px / 1.2 | 700 |
| H3 (kartica/podnaslov) | 22–24px / 1.3 | 600 |
| H4 | 18px / 1.4 | 600 |
| Body | 16px / 1.6 | 400 |
| Small / meta | 14px / 1.5 | 400 |
| Caption / label | 12–13px / 1.4 | 500 (uppercase za labele) |

Mobile: H1 28–32px, H2 24px, body ostaje 16px.

## Razmaci (8px skala)
`4 · 8 · 12 · 16 · 24 · 32 · 48 · 64 · 96` (px)
- Razmak između sekcija: **64px desktop / 40px mobile**.
- Unutrašnji padding kartice: **16–24px**.
- Razmak u gridu (gutter): **24px desktop / 16px mobile**.

## Radijusi
| Token | px | Upotreba |
|-------|----|----------|
| `radius-sm` | 6 | dugmad, inputi, chipovi |
| `radius-md` | 10 | kartice |
| `radius-lg` | 16 | hero, veliki paneli |
| `radius-pill` | 999 | tagovi/filter chip, badge |

## Sjenke (elevation)
| Token | Vrijednost (smjernica) | Upotreba |
|-------|------------------------|----------|
| `shadow-sm` | 0 1px 2px rgba(0,0,0,.06) | kartice u mirovanju |
| `shadow-md` | 0 4px 12px rgba(0,0,0,.10) | hover kartice, dropdown |
| `shadow-lg` | 0 12px 32px rgba(0,0,0,.16) | modal/lightbox, popup mape |

## Ikone
- Linijske (outline), debljina ~1.5–2px, uglovi blago zaobljeni.
- Set kategorija (za mapu i filtere): zanat 🛠 · hrana&piće 🍽 · usluge 🧰 · priroda 🌲 · kultura 🏛 · smještaj 🛏 · događaj 📅. (U Pencilu koristiti odgovarajuće ikone iz biblioteke; emoji su samo orijentir.)

## Dugmad — brze specifikacije
| Tip | Pozadina | Tekst | Border | Hover |
|-----|----------|-------|--------|-------|
| Primary | `primary` #00529C | bijela | — | `primary-dark` |
| Secondary | bijela | `primary` | 1px `primary` | `primary-tint` pozadina |
| Ghost/tekst | transparent | `primary` | — | podvlačenje |
| Akcent (rijetko) | `accent` | bijela | — | `accent-dark` |
Visina dugmeta: 44px (desktop), min. dodirna meta 44×44 na mobilnom. Padding 12×20.

## Stanja interaktivnih elemenata (obavezno predvidjeti)
`default · hover · focus (vidljiv fokus ring u primary) · pressed · disabled`
