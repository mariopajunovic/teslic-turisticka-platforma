# 16 — Dizajn i UX smjernice (priprema za wireframe)

📌 **TS 10**

## Principi (📌 TS 10)
Platforma mora imati **moderan, pregledan i responzivan** dizajn (desktop, tablet, mobilni), usklađen s namjenom projekta, koji omogućava:
- jednostavnu navigaciju,
- jasno istaknute pozive na akciju (CTA),
- pregledan prikaz kategorija, priča, događaja i mape,
- vizuelno kvalitetnu prezentaciju foto/video sadržaja,
- intuitivno korištenje za krajnje korisnike i administratore.

## Responzivne tačke (predlog za skiciranje)
- **Mobilni** (≤ 600px): jedna kolona, hamburger meni, sticky header, carousel-i sa swipe.
- **Tablet** (600–1024px): 2 kolone u gridovima.
- **Desktop** (≥ 1024px): pun grid (3–4 kolone), bočni paneli na detaljnim stranicama.

## Ponovljive komponente (design system — skicirati jednom, koristiti svuda)
| Komponenta | Gdje se koristi |
|------------|-----------------|
| **Kartica sadržaja** (slika, naslov, meta, kratak opis) | biznisi, lokaliteti, događaji, oglasi, priče |
| **Filter traka** (dropdown + pretraga + reset) | svi listinzi |
| **Hero baner** | početna, kategorije, detalji |
| **Bočni info panel** | profil biznisa, lokalitet, događaj, oglas |
| **Mini-mapa** | sve detaljne stranice s lokacijom |
| **Galerija + lightbox / video** | svi sadržaji s medijima |
| **Badge statusa** (nacrt/na odobrenju/objavljeno/odbijeno/istekao) | korisnički panel, admin, neobjavljeni front |
| **CTA dugmad** (primarno/sekundarno) | globalno |
| **Forma + validacija + CAPTCHA** | kontakt, registracija, upit |
| **Paginacija / „učitaj još”** | svi listinzi |
| **Prazno / učitavanje / greška** stanja | svi listinzi i detalji |

## Ikonografija mape (📌 TS 4.9)
Definisati prepoznatljiv set ikona po kategoriji pinova: biznisi (zanat/hrana/usluge), turizam (priroda/kultura), smještaj, događaji.

## Tipografija i ton
- Čitljiva tipografija, jasna hijerarhija naslova (H1–H3).
- Topao, lokalni, autentičan ton (u skladu s „Priče iz Teslića”).
- Vizuali u prvom planu (foto/video iz produkcije, dronski snimci — 📌 TS 11).

## Pristupačnost (🟡 preporuka)
- Dovoljan kontrast, alt-tekstovi na slikama, navigacija tastaturom, čitljive veličine fonta na mobilnom.

## Mapa stranica za prototip (redoslijed skiciranja)
1. Globalni header/footer + design system komponente
2. Početna ([01](stranice/01-pocetna.md))
3. Listing + detalj — biznis ([03](stranice/03-domace-je-najbolje.md))
4. Listing + detalj — turizam ([04](stranice/04-turizam-u-teslicu.md))
5. Događaji lista/kalendar + detalj ([05](stranice/05-dogadjaji.md))
6. Oglasi lista + detalj ([06](stranice/06-poslovne-prilike-oglasi.md))
7. Mapa ([07](stranice/07-mapa-ponude.md))
8. Priče listing + detalj ([08](stranice/08-price-iz-teslica.md))
9. Pridruži se + forme ([09](stranice/09-pridruzi-se.md))
10. Kontakt ([10](stranice/10-kontakt.md))
11. Prijava / korisnički panel ([13](administracija/13-user-administracija.md))
12. Admin panel ekrani ([11](administracija/11-admin-panel.md))

## 🔗 Veze
[Pregled i navigacija](00-pregled-i-navigacija.md) · [Footer](14-footer-i-globalni-elementi.md)
