# CHANGELOG — Pencil dizajn

Hronologija izrade i odobravanja `.pen` fajlova. Svaki agent dopisuje stavku.
Format: `fajl — šta je urađeno. [status]` (status: `u izradi` / `na pregledu` / `odobreno`).

---

## 2026-06-22
- _koncepti/01_Pocetna_KonceptA.pen (+ .png) — Koncept A Početne (klasičan/pregledan), boja #00529c, generisan preko `@pencil.dev/cli`. [na pregledu]
- _koncepti/01_Pocetna_KonceptB.pen (+ .png) — Koncept B (vizuelni/imerzivan). [arhivirano]
- _koncepti/01_Pocetna_KonceptC.pen (+ .png) — Koncept C (storytelling/urednički). [arhivirano]
- Sva 3 koncepta arhivirana u `_arhiva/*_2026-06-22.*` — odbijena (rušeno na brzinu, bez promišljene palete/copy-ja/detalja). Restart od A v2 uz promišljen design system + live praćenje na desktopu (MCP).
- 00_Foundations.pen — postavljeni design tokeni kao Pencil varijable (20 boja, font Inter, 8px skala razmaka, radijusi) + vizuelni token board (boje/tipografija/razmaci/radijusi/sjenke). Dodate prve master komponente: Dugme/{Primary,Secondary,Ghost,Akcent} (sva stanja), Chip/{Filter,Kategorija,Uklonjiv}, Badge/Status (5 varijanti). Imenovanje mapirano 1:1 na Tailwind tokene. [u izradi]
- 00_Foundations.pen — paleta: odabran topli smjer. Accent zlatna→terakota (#C8602E/#A84D22), neutralne otopljene (text #2A2A2E, heading #1C1B1A, text-muted #6E6A63, border #E8E1D7, surface-alt #FAF7F2). Tekst na accentu sada bijel (kontrast). Spec 00-design-tokens.md ažuriran. [u izradi]
- 00_Foundations.pen — primarna boja promijenjena na šumsku zelenu (#1F7A53 + dark/darker/tint/tint-2), info=primary. Accent terakota zadržan kao komplement. Cijela paleta usklađena oko zelene: neutralne → sage/stone (#2A2C28, #1A1C18, #6B6E64, #E5E7DF, #F7F8F3), overlay topli (#1A1C18 60%); statusne usklađene i pristupačne (warning→#A66300 dublji amber, neutral-badge→#6B6E64; success/error zadržani). Token board, spec i changelog usklađeni. ⚠️ Brend boja (zelena umj. #00529C) — potvrditi s naručiocem. [u izradi]
- 00_Foundations.pen — popravka kolizije zelenih: info više nije = primary (→ plava #2C6FB5), success odvojen od brend zelene (→ lisnata #437D22). Sve statusne sada vizuelno različite. [u izradi]
- 00_Foundations.pen — istraženi 2026 trendovi (Transformative Teal, neo-earth tonovi, Cloud Dancer kremasta). Brend prebačen na **deep teal #0E7C72** (+ dark/darker/tint), neutralne na tople kremaste/stone (#262723/#161916/#6E6A60/#E8E3D7/#F6F3EC), overlay topli. Accent terakota i statusne zadržane. Referenca: GoTrip home_5 (#3554D1) razmotrena ali odbačena kao generična plava. [u izradi]
- 00_Foundations.pen — paleta upotpunjena i „posvijetljena": statusne vedrije (success #178048, warning #8A6400, error #CC3A3A, info #1E72BD) + dodati tintovi (accent/success/warning/error/info/neutral-tint). Badge/Status prepravljen u tinted stil (svijetla pozadina + tačkica + jak tekst) — veselije, manje tamnih blokova, AA. Spec ažuriran. [u izradi]
- 00_Foundations.pen — QA prolaz: WCAG AA kontrast-test svih ključnih parova; ispravljeni padovi (success→#157A40, error→#BE2F2F, info→#1C6AB0, accent-dark→#9E4A22, chip tekst→primary-dark, Preporučeno badge→accent-dark tekst). Sve dokumentacija (cover+tokeni+komponente+provjere) složena u jedan screen `00 — Foundations (PDF)` za izvoz; master-komponente zasebno. [u izradi]
- 00_Foundations.pen — forme: Polje/Tekst (+stanja focus/greška/disabled), Polje/Select, Polje/Textarea, Checkbox (un/checked), Captcha, Alert/PorukaStanja (uspjeh/greška/info, tinted). Showcase „Komponente — Forme" dodan u PDF screen. [u izradi]
- 00_Foundations.pen — paleta uparena s logom TO Teslić (logo_turisticka.png: teal+lime+koral). Primarna teal oživljena (#0E8074, AA), dodata sekundarna „logo lime" (#C8D848 + dark/tint) + komponenta Dugme/Sekundarna. Token board (Sekundarna swatchevi) + QA tabela (novi kontrast + lime red) + spec ažurirani. [u izradi]
- 00_Foundations.pen — QA dorada accenta: bijeli tekst na punom accentu je padao AA (3.22) → accent produbljen (#B85A1C/#8F4413), sada 4.65 AA; accent-tint ostaje svijetao za badge. Audit potvrdio: neutralne (tople stone/cream) i statusne (tinted, AA, namjerno univerzalne a ne brend-boje) — uredne. [u izradi]
- 00_Foundations.pen — VESELA paleta v2 (odlučno, od nule): hladne slate neutralne (#20242C/#12151C/#5C6573/#DCE0E6/#F3F5F8), accent = vedra logo-narandža #E88828 (+accent-dark #C46E12, accent-deep #8F5210, tamni tekst na punom accentu), vivid statusne (#1E7D3C/#8C5810/#C62828/#1C68B5/#5C6573) + saturiraniji tintovi, teal #0E8275, lime sekundarna. Novi samostalni screen „00 — Paleta (logo) v2" (cover+sve boje+tipografija+razmaci+preview komponenti). Spec ažuriran. Stari PDF screen ostaje (auto-update boja) — može se obrisati na potvrdu. [u izradi]
- 00_Foundations.pen — kartice (#5): Kartica/Biznis (slika+Preporučeno badge overlay+chip+meta), Kartica/Dogadjaj (datumski blok overlay+vrijeme), Kartica/Oglas (kompaktna, bez slike, +Isteklo stanje), Kartica/Prica (autor+izvod), Kartica/Prica-Featured (široka, slika lijevo). Lokalitet = Biznis instanca (vizuelno srodna). Showcase „Komponente — Kartice" (grid 4 kol + stock slike). [u izradi]
- 00_Foundations.pen — globalni layout (#6): Header/Desktop (logo + nav s dropdownima + pretraga + Prijava/Pridruži se), Header/Mobile (logo + pretraga + hamburger), Footer (4 kolone + partneri + dark-teal pravna traka). Logo iz ../logo_turisticka.png. Napomena (Pencil quirk): fit_content kontejneri trebaju EKSPLICITAN padding (inače fantom ~50px offset); izbjegavati fiksnu visinu + alignItems:center na flex traci — koristiti padding. [u izradi]
- 00_Foundations.pen — pomoćne komponente (#7): Breadcrumb, Paginacija (prev/1·2·3·…·10/next), CTASekcija (dark-teal + lime CTA), PraznoStanje (ikona+naslov+tekst+CTA), Skeleton (loading kartica), CookieBanner. Foundations biblioteka kompletna (tokeni + sve komponente + header/footer). [na pregledu]
- 00_Foundations.pen — VALIDACIJA: sklopljena Početna „KonceptA – Desktop" (privremeno u ovom fajlu radi reuse master-komponenti): Header, Hero (slika+overlay+slogan), kategorije (6 pločica), Lokalni proizvodi, Preporučeno (primary-tint+badge), Atrakcije, Mapa isječak, Događaji, Priče (Featured+grid), CTA, Footer — sve sa stock slikama i lokalnim sadržajem (med/rakija/Banja Vrućica/Borja). Potvrđeno: design sistem spreman. Za produkciju → prebaciti u _koncepti/01_Pocetna_Koncepti.pen (3 koncepta + Mobile). [provjera spremnosti]

<!-- Primjer:
## 2026-06-22
- 00_Foundations.pen — tokeni (#00529c) + header/footer + kartice. [odobreno]
- _koncepti/01_Pocetna_Koncepti.pen — 3 koncepta Početne (A/B/C), Desktop+Mobile. [na pregledu]

## 2026-06-23
- 01_Pocetna.pen — usvojen Koncept B, prebačen u produkciju, dovršena stanja. [odobreno]
-->
