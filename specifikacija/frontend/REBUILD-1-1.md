# 1:1 Rebuild — plan i capture log

> Cilj: svaki Vue view 1:1 prema `.pen` dizajnu (desktop + mobile + stanja). Prethodna verzija je građena iz recepata (približno) → ispravlja se prema tačnom dizajnu.
>
> **Tooling činjenica:** Pencil MCP čita SAMO trenutno otvoreni `.pen` (filePath se ignoriše). Zato: ti otvoriš fajl i ostaviš ga otvoren; ja iz njega izvučem tačan spec; pa sljedeći.
>
> **Odluke (2026-06-23):** capture svih specova → pa paralelni build · opseg = SVE (uklj. account/auth) · dizajn je finalan.

## Proces
1. **Capture (sekvencijalno):** za svaki fajl pročitam sve artboarde (Desktop/Mobile/stanja) i zapišem tačan spec ovdje (redoslijed sekcija, pozadine, paddinzi, sadržaj, slike, tipografija).
2. **Build (paralelno):** kad su specovi spremni, agenti grade view-ove 1:1 iz ovog dokumenta.
3. **Verifikacija:** screenshot Vue vs. `.pen`, sekcija po sekcija.

## Capture checklist (otvori redom)
- [x] **01_Pocetna — GOTOVO 1:1** (Desktop+Mobile): contained `#06443D` hero panel (slika+overlay #0A2C27CC, eyebrow lime „DOBRODOŠLI U TESLIĆ", H1 46px, lime „Istraži ponudu" + outline „Pridruži se") · 6 kategorija-pločica (krug ikona utensils/trees/calendar/map-pin/book-open/briefcase) · sekcije bg #FFF/#F3F5F8/#E1F4F1 · „Vidi sve →" linkovi · grids 4/3/4/4/3 · Mapa isječak panel · Galerija 4-img red · CTA. Verifikovano screenshotom. Komponente: SectionHeader (nova), BusinessCard/EventCard/StoryCard, CTASection.
- [ ] 02_O-projektu — Desktop + Mobile
- [ ] 03_Domace-je-najbolje — Listing + ProfilBiznisa (+stanja) × D/M
- [ ] 04_Turizam — Listing + Detalj × D/M
- [ ] 05_Dogadjaji — Lista + Kalendar + Detalj × D/M
- [ ] 06_Oglasi — Lista + Detalj × D/M
- [ ] 07_Mapa — Desktop + Mobile (+ Popup/Prazno)
- [ ] 08_Price — Listing + Detalj × D/M
- [ ] 09_Pridruzi-se — Hub + Forme × D/M
- [ ] 10_Kontakt — Desktop + Mobile
- [x] **11_AuthFoundations — komponente GOTOVE** → `src/components/account/`: AccountSidebar (MOJ NALOG + Moj profil/Moje objave/Oglasi/Mediji/Postavke), AccountTabs (mobilni pill-tabovi), PostRow (RedObjave: thumb+naslov+meta+status+pencil/trash), AvatarUpload (72 krug + „Promijeni fotografiju" + hint), ToggleSwitch (44×24 teal), RichEditor (toolbar bold/italic/heading/list/link/image/quote + polje). StatusBadge varijante = pokriva BaseBadge. *(napomena: .pen fajlovi se uređuju uživo — ID-jevi se mijenjaju među pozivima)*
- [x] **12_Prijava — GOTOVO 1:1** → rute `/prijava`, `/zaboravljena-lozinka`, `/registracija`:
  - `LoginView` (kartica 420: Prijava + E-mail/Lozinka + Zapamti me/Zaboravljena + Prijava + „Nemaš nalog? Pridruži se") sa stanjima: **greška** (alert + crvena polja + rate-limit nota) i **NalogNaOdobrenju** (badge „Na odobrenju" + info alert clock-3) — preko `?stanje=greska|odobrenje`.
  - `ForgotPasswordView` (kartica + uputstvo + e-mail + „Pošalji link za reset" + „Nazad na prijavu"; stanje **Uspjeh** = „Provjerite e-mail" + Alert/Uspjeh).
  - `RegisterChoiceView` („Napravi nalog" + 2 kartice Registruj biznis/Postani autor + info nota).
  - Header „Prijava" link → `/prijava` (desktop + drawer). Verifikovano screenshotom.
- [x] **13_Moj-profil — GOTOVO 1:1** (9 dashboard ekrana, rute `/nalog/biznis/*` i `/nalog/autor/*`)
  - Ljuska `AccountLayout` (Topbar + Sidebar desktop / mobilni pilule) + `App.vue` meta `layout:'account'` (bez javnog header/footer).
  - Biznis: **MojProfil** (form + avatar + upload), **MojeObjave** (PostRow lista + odbijeno s razlogom), **Oglasi** (PostRow + Isteklo), **Mediji** (Upload + grid), **Postavke** (Nalog + Obavijesti toggles).
  - Autor: **MojePrice** (lista), **NovaPrica** (RichEditor + Galerija + „Poveži sa"), **AutorskiProfil** (form + Blok o autoru pregled), **Postavke**.
  - Komponente: AccountSidebar, AccountTabs, PostRow (+reason), AvatarUpload, ToggleSwitch, RichEditor, UploadBox, SettingsPanel. Sve verifikovano screenshotovima; build ✓ lint ✓.
  - Napomena: panel-stanja (Prazno „Još nemate objava" / UspjehSnimanja / NalogBlokiran) snimljena iz dizajna — mogu se dodati kao in-page stanja po potrebi.

---

## 01 — Početna (KonceptA) — DJELIMIČNO snimljeno (treba dopuna kad se otvori)

**Desktop `Pocetna – KonceptA – Desktop` (1440, sadržaj 1200), redoslijed sekcija:**
1. `Header` (ref Header/Desktop)
2. **Hero** — padding [48,120]; unutar njega **Hero panel**: rounded 16, fill `#06443D` (primary-darker), visina **460**, širina 1200 (NIJE full-bleed!). [treba: slogan tekst, podnaslov, dugmad]
3. **Sekcija/Kategorije** — fill `#F3F5F8` (surface-alt), padding [40,120]; H2 „Istražite po kategoriji" (28/700); red „Pločice" [treba: tačan broj + labele pločica]
4. **Sekcija/Proizvodi** — fill `#FFFFFF`, padding [64,120]; Zaglavlje (naslov + „Vidi sve") + Grid (24 gap) [treba: koje kartice/koliko]
5. **Sekcija/Preporuceno** — fill `#E1F4F1` (primary-tint), padding [64,120]; Zaglavlje + Grid
6. **Sekcija/Atrakcije** — fill `#FFFFFF`, padding [64,120]; Zaglavlje + Grid
7. **Sekcija/Mapa** — fill `#F3F5F8`, padding [64,120]; Zaglavlje + „Mapa isječak" (rounded 16, fill `#E1F4F1`, visina 340)
8. **Sekcija/Dogadjaji** — fill `#FFFFFF`, padding [64,120]; Zaglavlje + Grid
9. **Sekcija/Price** — fill `#F3F5F8`, padding [64,120]; Zaglavlje + Grid
10. **Sekcija/Galerija** — fill `#FFFFFF`, padding [64,120]; Zaglavlje + „Mozaik"
11. **Sekcija/CTA** — fill `#FFFFFF`, padding [64,120]; ref CTASekcija: naslov „Pridružite se platformi Teslić", tekst „Predstavite svoj biznis hiljadama posjetilaca ili podijelite svoju priču o teslićkom kraju.", dugmad „Registruj biznis" (sekundarna/lime) + „Postani autor"
12. `Footer` (ref) · CookieBanner (absolute) · StatusBlok (absolute, ukloniti u kodu)

**Mobile `Pocetna – KonceptA – Mobile` (375):** Hero panel rounded16 `#06443D` visina 420, padding [20,16]; sekcije padding [40,16]; kategorije = 3 reda pločica; gridovi = 1 kolona. Sadržaj kartica (potvrđeno iz dizajna):
- Proizvodi: „Pčelarstvo Borja" (Domaći med sa obronaka Borja. · Borja), „Rakija Očauš" (Prepečenica po starom receptu. · Očauš)
- Preporuceno: „Med sa Borja — nagrađeni" (Izbor turističke organizacije za 2026. · Borja)
- Atrakcije: „Banja Vrućica" (Termalni izvori i spa centar. · Vrućica), „Planina Borja" (Šume, staze i vidikovci. · Borja)
- Dogadjaji: „Ljetni festival Teslić 2026" (12 JUL · 19:00 · Centar Teslića), „Sajam domaćih proizvoda" (20 JUL · 10:00 · Banja Vrućica)
- Priče: „Kako nastaje med sa Borja" (Domaćini pričaju · Marko P. · 10.06.2026.), „Banja Vrućica kroz generacije" (Ljudi i biznisi · Jelena S. · 02.06.2026.)
- (slike: stvarne Unsplash foto-pozadine u kkarticama — koristiti iste URL-ove ili lokalne ekvivalente)

> GAP za dopuniti kad se 01 otvori: hero slogan/podnaslov/dugmad, labele kategorija-pločica, „Vidi sve" tekstovi, tačan sadržaj desktop gridova (broj kartica), galerija mozaik raspored.
