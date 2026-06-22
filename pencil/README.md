# Pencil dizajn — `.pen` fajlovi

Ovdje se čuvaju svi Pencil dizajn fajlovi (**ekstenzija `.pen`**). Folder je **izvan** `specifikacija/` (dokumentacija je tamo, dizajn ovdje).

➡️ Pravila rada, segmentacija, verzionisanje i proces: [`../specifikacija/ui-workflow/03-konvencije-i-proces.md`](../specifikacija/ui-workflow/03-konvencije-i-proces.md)
➡️ Tokeni / komponente / layout: [`../specifikacija/ui-workflow/`](../specifikacija/ui-workflow/README.md)

## Struktura
```
pencil/
├── 00_Foundations.pen        tokeni, header, footer, master komponente
├── 01_Pocetna.pen
├── 02_O-projektu.pen
├── 03_Domace-je-najbolje.pen
├── 04_Turizam.pen
├── 05_Dogadjaji.pen
├── 06_Oglasi.pen
├── 07_Mapa.pen
├── 08_Price.pen
├── 09_Pridruzi-se.pen
├── 10_Kontakt.pen
├── _koncepti/                faza istraživanja (npr. 3 koncepta Početne)
├── _arhiva/                  starije verzije s datumskim sufiksom
└── CHANGELOG.md              hronologija odluka i verzija
```

Pravilo: **jedan `.pen` fajl = jedna stranica/cjelina**; breakpointi i stanja su zasebne stranice unutar fajla.
