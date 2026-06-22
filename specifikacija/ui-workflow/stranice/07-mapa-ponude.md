# Recept: 07 — Mapa ponude

📄 Spec: [stranice/07-mapa-ponude.md](../../stranice/07-mapa-ponude.md) · Tokeni: [00](../00-design-tokens.md) · Komponente: [01](../01-komponente.md)

## Artboardi
- `Mapa – Default – Desktop` (1440) / `– Mobile` (375)
- `Mapa – PopupOtvoren` (pin popup)
- `Mapa – Prazno` (nema rezultata za filtere)

## Layout
```
DESKTOP:
┌──────────────┬───────────────────────────────────────┐
│ FilterPanel  │            MapaInteraktivna            │
│ (slojevi/    │  pinovi po kategorijama + clusteri     │
│ kategorije   │                                        │
│ checkbox)    │   [Pin] → MapaPopup                    │
│ + Pretraga   │                                        │
└──────────────┴───────────────────────────────────────┘
(opc. ListaRezultata uz mapu, sinhronizovana)
```

## Blokovi
1. `Header` + `Breadcrumb`
2. `FilterPanel` — checkbox slojevi: Biznisi (zanat/hrana/usluge), Turizam (priroda/kultura), Smještaj, Događaji; `Pretraga` lokacije/naziva.
3. `MapaInteraktivna` — `Pin` (ikone po kategoriji iz tokena), `Cluster` na odjavljenom zoomu.
4. `MapaPopup` na klik pina: slika · naziv · `Chip/kategorija` · `Dugme/Ghost` „Detalji →”.
5. (opc.) `ListaRezultata` sinhronizovana s mapom.
6. `Footer`

## Stanja
- Bez rezultata za filtere → poruka + „Resetuj filtere”.
- Mobilni: mapa puni ekran; filteri u `Drawer` (dugme „Slojevi/Filteri”); popup kao bottom-sheet.

## Responsive
- Desktop: panel + mapa. Mobile: full-screen mapa, filteri i lista u sheet/drawer.

## Ikone pinova
Konzistentne s `00-design-tokens` (zanat, hrana&piće, usluge, priroda, kultura, smještaj, događaj) — vidljiva legenda u FilterPanelu.

## Checklist
- [ ] Filtriranje po kategorijama (slojevi).
- [ ] Pinovi + clustering + legenda ikona.
- [ ] Popup s osnovnim info + „Detalji →”.
- [ ] Stanje bez rezultata.
- [ ] Desktop (panel+mapa) + Mobile (full-screen + sheet).
