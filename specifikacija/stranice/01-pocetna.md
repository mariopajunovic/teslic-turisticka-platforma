# 01 — Početna stranica

📌 **TS 4.3** · **Ruta:** `/` · **Pristup:** javno

## Svrha
Ulazna tačka i izlog platforme. U jednom scroll-u predstavlja Teslić kroz sve tri grupe sadržaja (domaća ponuda, turizam, priče) i usmjerava posjetioca dublje u sajt te poziva biznise/autore na registraciju.

## Sadržaj i raspored (blokovi odozgo nadolje — osnova za wireframe)

```
┌──────────────────────────────────────────────────────────┐
│ HEADER (logo · navigacija · pretraga · Pridruži se · Prijava)
├──────────────────────────────────────────────────────────┤
│ 1. HERO BANER                                              │
│    veliki vizual + slogan + promotivna poruka + CTA dugmad │
├──────────────────────────────────────────────────────────┤
│ 2. ISTAKNUTE KATEGORIJE SADRŽAJA                           │
│    4–6 pločica (Domaće, Turizam, Događaji, Mapa, Priče…)   │
├──────────────────────────────────────────────────────────┤
│ 3. LOKALNI PROIZVODI I USLUGE                              │
│    grid/carousel istaknutih biznisa + „Vidi sve”           │
├──────────────────────────────────────────────────────────┤
│ 4. PREPORUČENO IZ PRVE RUKE                                │
│    kurirani izbor (admin bira) — istaknute kartice         │
├──────────────────────────────────────────────────────────┤
│ 5. TURISTIČKE ATRAKCIJE                                    │
│    grid lokaliteta + „Vidi sve”                            │
├──────────────────────────────────────────────────────────┤
│ 6. INTERAKTIVNA MAPA (isječak) ili izdvojeni pregled lokacija │
├──────────────────────────────────────────────────────────┤
│ 7. NADOLAZEĆI DOGAĐAJI                                     │
│    3–4 kartice (najbliži datum) + „Kalendar događaja”      │
├──────────────────────────────────────────────────────────┤
│ 8. PRIČE IZ TESLIĆA                                        │
│    najnovije/istaknute objave bloga                        │
├──────────────────────────────────────────────────────────┤
│ 9. GALERIJA FOTOGRAFIJA / VIDEO                            │
│    multimedijalni materijali (uklj. dronski snimci)        │
├──────────────────────────────────────────────────────────┤
│ 10. CTA REGISTRACIJA                                       │
│     „Registruj svoj biznis” + „Postani autor”              │
├──────────────────────────────────────────────────────────┤
│ FOOTER                                                     │
└──────────────────────────────────────────────────────────┘
```

## Obavezni elementi (🔴 — 📌 TS 4.3)
1. Glavni vizuelni baner sa sloganom i promotivnom porukom.
2. Istaknute kategorije sadržaja.
3. Sekcija za lokalne proizvode i usluge.
4. Sekcija za turističke atrakcije.
5. Sekcija sa pričama iz Teslića.
6. Sekcija sa nadolazećim događajima.
7. Poziv za registraciju lokalnih biznisa i autora.
8. Galerija fotografija i/ili video sadržaja.
9. Sekcija „Preporučeno iz prve ruke”.
10. Prikaz interaktivne mape ili izdvojeni pregled lokacija.

## Komponente i interakcije
- **Hero**: 1–2 CTA dugmeta (npr. „Istraži ponudu”, „Pridruži se”); admin uređuje sliku/slogan/poruku.
- **Kartice** vode na odgovarajuće detaljne stranice.
- **„Nadolazeći događaji”**: automatski sortirano po datumu, isključuje protekle.
- **Carousel/grid** prebacivi na mobilni (horizontalni swipe).
- Svaki blok ima naslov sekcije + link „Vidi sve”.

## Stanja
- Ako u nekoj sekciji nema sadržaja — sekcija se sakriva ili prikazuje prazno stanje (odluka u dizajnu).
- Galerija: lazy-load, lightbox za fotografije, inline player za video.

## 🔗 Veze
[Domaće je najbolje](03-domace-je-najbolje.md) · [Turizam](04-turizam-u-teslicu.md) · [Mapa](07-mapa-ponude.md) · [Događaji](05-dogadjaji.md) · [Priče](08-price-iz-teslica.md) · [Pridruži se](09-pridruzi-se.md)
