# Recept: 10 — Kontakt

📄 Spec: [stranice/10-kontakt.md](../../stranice/10-kontakt.md) · Tokeni: [00](../00-design-tokens.md) · Komponente: [01](../01-komponente.md)

## Artboardi
- `Kontakt – Default – Desktop` / `– Mobile`
- `Kontakt – Uspjeh` · `Kontakt – Greska`

## Blokovi
1. `Header` + `Breadcrumb`
2. **Naslov + uvod.**
3. **Dvokolonski:**
   - **Lijevo — `Forma`:** Ime i prezime* · E-mail* · Tema/predmet · Poruka (textarea)* · ☑ saglasnost obrade* · `Captcha`* · `Dugme/Primary` „Pošalji”.
   - **Desno — `InfoPanel`:** naziv ustanove, adresa (Svetog Save 15, 74270 Teslić), telefon (053/430-058), e-mail (turistorg.teslic@gmail.com), radno vrijeme, linkovi društvenih mreža.
4. **`MapaInteraktivna`/MiniMapa** — lokacija ustanove.
5. `Footer`

## Stanja
- `slanje` (disabled+spinner) · **Uspjeh** (`PorukaStanja` success) · greška validacije/Captcha · greška slanja.

## Responsive
- Dvije kolone → jedna (forma prva, info ispod); mapa puna širina.

## Checklist
- [ ] Forma sa svim poljima + Captcha.
- [ ] InfoPanel s kontakt podacima ustanove.
- [ ] Mapa lokacije.
- [ ] Stanja uspjeh/greška.
- [ ] Desktop + Mobile.
