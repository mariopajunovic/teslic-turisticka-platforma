# Predlog dizajna — usklađivanje unutrašnjih stranica sa Početnom

> Cilj: sve unutrašnje stranice (02–13) da imaju **istu priču i vidljivu vezu** sa Početnom, kao da su „nastavak istog scrolla", a ne zasebni sajtovi. Ovo je predlog za odobravanje prije gradnje u `XX_Pages_Final.pen`.

---

## 1. Priča Početne (kičma koju nasljeđuju sve stranice)

Početna predstavlja Teslić kroz **3 stuba sadržaja** (domaća ponuda · turizam · priče) + događaji + mapa, toplim/lokalnim tonom, na dizajn-sistemu:
- **Brend teal `#0E8275`** · **lime sekundarna `#C8D848`** · **terakota accent** · tople cream/stone neutralne · Inter · 8px skala · tinted badge-evi.
- Ritam Početne: svaka sekcija = **naslov + kratak uvod + „Vidi sve →"** koji vodi na odgovarajuću unutrašnju stranicu.

**Ključ veze:** Početna je *hub*, a svaka sekcija su *vrata* ka jednoj unutrašnjoj stranici. Znači svaka unutrašnja stranica je „razvijena verzija" jedne sekcije Početne — i mora se vizuelno prepoznati kao takva.

---

## 2. Globalna pravila usklađivanja (važe za SVE stranice 02–13)

1. **Isti header i footer** kao na Početnoj (dvoetažni header v2 + složeni Footer/Mobile) — bez lokalnih kopija starog headera. *(CHANGELOG napomena: stranice 01–13 još drže stare kopije headera — rollout ovdje.)*
2. **Hero „eho" Početne** — svaka stranica otvara herom s istim jezikom: kicker (mala riječ u accent/terakota), H1, kratak uvod, ista scrim/overlay obrada slike. Razlikuje se samo slika + boja kickera po stubu (vidi §4).
3. **Iste komponente, nigdje nova varijanta:** Kartica/{Biznis,Dogadjaj,Oglas,Prica}, FilterTraka, InfoPanel, MiniMapa, CTASekcija, Breadcrumb, Paginacija, PraznoStanje, Skeleton — iz Foundations, identične kao na Početnoj.
4. **Breadcrumb počinje od „Početna"** na svakoj unutrašnjoj stranici (`Početna / Turizam / …`) — doslovna veza nazad.
5. **„PovezaniSadrzaj" blok pred footerom** — svaka stranica zatvara krug: 2–3 kartice iz *druga dva stuba* + link nazad na Početnu. Korisnik nikad nije u ćorsokaku.
6. **Ista CTA registracije** („Registruj biznis · Postani autor", teal/lime) iznad footera — identična onoj na Početnoj.
7. **Razmak sekcija 64px, kontejner 1200px** — isti ritam kao Početna (ne full-bleed osim hero/CTA).

---

## 3. „Veza" sistem — kako se stranice prepliću (storytelling spona)

Da priča bude jedna, uvodi se **dosljedan sistem unakrsnih veza**, isti raspored na svakoj stranici:

```
HERO (eho Početne)
  → Breadcrumb: Početna / [Stranica]
SADRŽAJ STRANICE (listing/detalj)
  → svaka kartica vodi dublje
POVEZANI SADRŽAJ  ← spona
  • iz druga 2 stuba (npr. na Turizmu: 1 biznis + 1 priča + 1 događaj u blizini)
  • „← Nazad na Početnu" / „Istraži sve kategorije"
CTA REGISTRACIJE (kao Početna)
FOOTER (kao Početna)
```

Boja kickera = „kod" stuba, isti na Početnoj i na stranici, pa korisnik podsvjesno povezuje:
- **Domaća ponuda** → teal
- **Turizam** → terakota accent
- **Događaji** → lime
- **Priče** → topla (terakota-tint)

---

## 4. Primjena po stranicama

| Stranica | Sekcija na Početnoj (vrata) | Šta uskladiti | Povezani sadržaj (spona) |
|---|---|---|---|
| **02 O projektu** | (footer/brend) | Hero-eho, isti partneri-traka kao footer Početne, CTA registracije | 3 puta: Posjetioci→Turizam · Biznisi→Domaće · Autori→Priče |
| **03 Domaće je najbolje** | „Lokalni proizvodi" + „Preporučeno" | Kartica/Biznis identična, isti Preporučeno badge, FilterTraka | Turistički lokalitet u blizini + priča o domaćinu |
| **04 Turizam** | „Atrakcije" + „Mapa" | Kartica/Lokalitet = ista Kartica/Biznis stil, MiniMapa kao na Početnoj | Biznis u blizini + događaj na lokaciji |
| **05 Događaji** | „Nadolazeći događaji" | Kartica/Dogadjaj s datumskim blokom = ista, lime kicker | Lokalitet događaja + organizator (biznis) + priča |
| **06 Oglasi** | (nije na Početnoj direktno) | Uvesti kao 4. „servisni" stub — isti hero-eho, neutralniji | Izdavač (biznis) + lokacija na mapi |
| **07 Mapa** | „Interaktivna mapa (isječak)" | Puna verzija isječka s Početne, iste pin-ikone/legenda | Popup → kartica → detalj (biznis/lokalitet/događaj) |
| **08 Priče** | „Priče iz Teslića" | Featured + grid isti kao na Početnoj, topli kicker | Povezani biznis/lokalitet/događaj iz priče + BlokOAutoru |
| **09 Pridruži se** | „CTA registracije" | Puna verzija CTA s Početne, isti stepper stil | Dvije putanje → Domaće / Priče |
| **10 Kontakt** | (footer kontakt) | InfoPanel = isti kao footer kontakt, MiniMapa | Link na O projektu + Pridruži se |
| **11–13 Auth/Profil** | (header „Prijava/Pridruži se") | Isti brend top-traka, ista kartica/forme, StatusBadge | Po snimanju → nazad na javni sadržaj (Priče/Profil) |

---

## 5. Plan gradnje u `XX_Pages_Final.pen`

1. **Foundations first** — uvesti kompletnu biblioteku iz `00_Foundations.pen` (tokeni + sve reusable komponente + header v2 + Footer/Mobile) kao jedinstven izvor istine.
2. **Hero/Stranica master** — napraviti jednu reusable „Hero — Unutrašnja" komponentu (kicker+H1+uvod+slika+scrim) i „PovezaniSadrzaj" master, da se veza ne kopira ručno.
3. **Strana po strana** — sklopiti 02→13, svaku Desktop + Mobile, koristeći ISTE mastere; razlika samo sadržaj + boja kickera po stubu.
4. **QA prolaz** — provjeriti `snapshot_layout` (ne screenshot — glitcha) da svaki hero/footer/CTA 1:1 odgovara Početnoj.

---

## 6. Šta mi treba od tebe da krenem

- **Potvrdu ovog pravca** (priča + veza sistem + boje kickera po stubu).
- Da otvoriš **`01_Pocetna.pen`** u Pencilu na minut — da izvučem tačne tokene/komponente Početne 1:1 (MCP čita samo otvoreni .pen). Zatim otvaramo `XX_Pages_Final.pen` i gradim.
- Ili reci: „kreni odmah" pa gradim po ovom predlogu + Foundations bez dodatnih pitanja.
