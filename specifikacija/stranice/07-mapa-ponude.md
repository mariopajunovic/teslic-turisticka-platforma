# 07 — Mapa ponude (interaktivna mapa)

📌 **TS 4.9** · **Ruta:** `/mapa` · **Pristup:** javno

## Svrha
Interaktivna mapa koja na jednom mjestu prikazuje **sve registrovane subjekte i turističke tačke**, s filtriranjem po kategorijama i brzim pregledom informacija.

## Sadržaj i raspored
```
┌───────────────┬──────────────────────────────────────────┐
│ FILTER PANEL  │                                            │
│ (bočno/gore)  │            INTERAKTIVNA MAPA               │
│ ☑ Biznisi     │         (pinovi po kategorijama,           │
│   ☑ Zanat     │          grupisanje/clustering)            │
│   ☑ Hrana     │                                            │
│   ☑ Usluge    │   [pin] klik → popup:                      │
│ ☑ Turizam     │      ┌──────────────────┐                  │
│   ☑ Priroda   │      │ [slika] Naziv     │                  │
│   ☑ Kultura   │      │ kategorija · 📍   │                  │
│   ☑ Smještaj  │      │ [ Detalji → ]     │                  │
│ ☑ Događaji    │      └──────────────────┘                  │
│ [pretraga ⌕]  │                                            │
└───────────────┴──────────────────────────────────────────┘
[ (opciono) lista rezultata uz mapu — sinhronizovano ]
```

## Funkcionalnosti (🔴 — 📌 TS 4.9)
- Prikaz **svih** registrovanih subjekata i turističkih tačaka.
- Filtriranje po kategorijama (biznisi, turizam, smještaj, događaji…).
- Klik na tačku → popup s osnovnim informacijama (slika, naziv, kategorija).
- Svaka tačka **povezana s detaljnom stranicom** (biznis/lokalitet/događaj).
- Jednostavno administrativno dodavanje novih lokacija (iz [admin panela](../administracija/11-admin-panel.md)).

## Komponente i interakcije
- Slojevi/filteri uključuju i isključuju kategorije pinova.
- Clustering pri odjavljenom zoomu (grupisanje gustih tačaka).
- Popup → dugme „Detalji” vodi na detaljnu stranicu entiteta.
- Pretraga lokacije/naziva; geolokacija korisnika 🟡.
- Sinhronizacija mape i opcione liste rezultata 🟡.

## Izvor podataka
Pinovi se generišu iz koordinata unesenih na: [profilima biznisa](03-domace-je-najbolje.md), [lokalitetima](04-turizam-u-teslicu.md), [događajima](05-dogadjaji.md). Konzistentne ikone po kategoriji (definisati u [dizajn smjernicama](../16-dizajn-i-ux-smjernice.md)).

## Stanja
- Bez rezultata za odabrane filtere → poruka + reset filtera.
- Tačka bez koordinata se ne prikazuje (admin upozorenje pri unosu).

## 🔗 Veze
[Domaće je najbolje](03-domace-je-najbolje.md) · [Turizam](04-turizam-u-teslicu.md) · [Događaji](05-dogadjaji.md)
