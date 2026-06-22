# Početna — 3 koncepta (build plan)

> 1 koncept = 1 fajl: `01_Pocetna_KonceptA.pen`, `_KonceptB.pen`, `_KonceptC.pen`.
> Svaki ima Desktop (1440, sadržaj ≤1200) **i** Mobile (375). Artboard nazivi: `Pocetna – KonceptX – Desktop` / `– Mobile`.

## Zajednička pravila (sva 3)
- **Logo = tekst „teslić"** (teal), NIKAD slika loga.
- Paleta samo: primary `#0E8275`, secondary lime `#C8D848`, accent `#E88828` (+accent-dark `#C46E12`, accent-deep `#8F5210`, accent-tint `#FCEBCF`), neutralne cool-slate (text `#20242C`, heading `#12151C`, muted `#5C6573`, border `#DCE0E6`, surface `#FFFFFF`, surface-alt `#F3F5F8`, primary-tint `#E1F4F1`), tinted status.
- Razmak sekcija 64px desktop / 40 mobile; grid 12-kol max 1200; gridovi 4→2→1.
- Samo postojeće komponente (Header/Desktop+Mobile, Footer, Kartica/*, Dugme/*, Chip/*, Badge/Status, CTASekcija, itd.).
- Svaka sekcija: H2 naslov + „Vidi sve". **Preporučeno** = accent badge + `primary-tint` pozadina. **CTA registracija** = `primary` pozadina (Registruj biznis + Postani autor).
- Sadržaj ijekavica, lokalno: Banja Vrućica, planina Borja, Očauš, Borje; med/rakija/sir; ljetni festival.

## 12 blokova (spec redoslijed)
Header · Hero · Istaknute kategorije · Lokalni proizvodi · Preporučeno iz prve ruke · Turističke atrakcije · Mapa (isječak) · Nadolazeći događaji · Priče · Galerija · CTA registracija · Footer.

## KONCEPT A — „Klasičan / info"
- Hero: `slika-pozadina` **unutar 1200** (kontrolisan, NE full-bleed), slogan + 2 CTA.
- Pločice kategorija **odmah** ispod heroa (3. blok), naglasak na preglednost.
- Standardni redoslijed blokova; naizmjenične `surface`/`surface-alt` sekcije; Preporučeno grid (ne featured); mapa umjeren isječak.

## KONCEPT B — „Vizuelni / imerzivan"
- Hero: **full-bleed** foto/video preko cijele širine (~620px), header transparentan→solid na skrol.
- Foto-pločice kategorija (slika+overlay), parallax foto-traka iznad atrakcija.
- **Mapa = velika istaknuta sekcija** (~520px, ne mali isječak).
- Priče: `Kartica/Prica-Featured` preko cijele širine + grid 3. Galerija = veliki mozaik/masonry (dronski snimci).

## KONCEPT C — „Sadržajni / storytelling"
- Hero: **split „priča sedmice"** (tekst lijevo na surface-alt + topla slika desno), kicker „PRIČA SEDMICE" (accent-deep) + `Badge/Preporučeno`, autor+citat.
- Redoslijed s naglaskom: Header · Hero · Kategorije · **Preporučeno (visoko)** · **Priče (Featured+grid, visoko)** · Lokalni proizvodi · Atrakcije · Događaji · Mapa (niža/servisna) · Galerija · CTA · Footer.
- Topli ton: accent narandža kao vezivni akcent (kicker labele, badge, autorske oznake); priča-prvi narativni copy.
