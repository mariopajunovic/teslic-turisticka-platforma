# 00 — Design tokens

Vrijednosti koje agenti primjenjuju u Pencilu. **Ne odstupati** od ovih vrijednosti bez dopune ovog dokumenta.

## Boje

### Primarna (brend) — plava
| Token | HEX | Upotreba |
|-------|-----|----------|
| `primary` | **#00529C** | primarna CTA dugmad, linkovi, aktivna navigacija, header akcenti, naslovi sekcija (po potrebi) |
| `primary-dark` | **#003E78** | hover/pressed na primarnim elementima |
| `primary-darker` | **#002B52** | footer pozadina (opciono), pressed |
| `primary-tint` | **#E6EEF6** | svijetle pozadine sekcija, hover redova, chip pozadina |
| `primary-tint-2` | **#CFE0EF** | borderi/odvajanja u plavim zonama |

### Akcent (topla, za isticanje) 🟡 prijedlog
| Token | HEX | Upotreba |
|-------|-----|----------|
| `accent` | **#E8A317** | „Preporučeno iz prve ruke” oznake, istaknuti badge događaja, sekundarni naglasci |
| `accent-dark` | **#B97F0C** | hover na akcentu |

> Akcent je prijedlog; ako naručilac ima drugu sekundarnu boju, mijenja se samo ovdje.

### Neutralne
| Token | HEX | Upotreba |
|-------|-----|----------|
| `text` | #1F2937 | osnovni tekst |
| `heading` | #111827 | naslovi |
| `text-muted` | #6B7280 | meta, sekundarni tekst |
| `border` | #E1E5EA | linije, okviri kartica |
| `surface` | #FFFFFF | kartice, pozadina sadržaja |
| `surface-alt` | #F5F7FA | pozadina stranice / izmjeničnih sekcija |
| `overlay` | rgba(17,24,39,.6) | lightbox/modal pozadina |

### Statusne (badge, poruke)
| Token | HEX | Značenje |
|-------|-----|----------|
| `success` | #2E7D32 | objavljeno / uspjeh |
| `warning` | #C77700 | na odobrenju / upozorenje |
| `error` | #C0392B | odbijeno / greška |
| `info` | #00529C | informacije (= primary) |
| `neutral-badge` | #6B7280 | nacrt / isteklo |

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
| Akcent (rijetko) | `accent` | #1F2937 | — | `accent-dark` |
Visina dugmeta: 44px (desktop), min. dodirna meta 44×44 na mobilnom. Padding 12×20.

## Stanja interaktivnih elemenata (obavezno predvidjeti)
`default · hover · focus (vidljiv fokus ring u primary) · pressed · disabled`
