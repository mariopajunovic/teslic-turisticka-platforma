# 02 — Filament admin panel (`/admin`)

> Realizuje [11 — Admin panel](../administracija/11-admin-panel.md) i [12 — Uloge i workflow](../administracija/12-korisnicke-uloge-i-workflow.md).
> Zaseban **admin guard** (vidi [05](05-auth-uloge-sigurnost.md)); pristup samo `admins` + 2FA (📌 TS 6).

## Panel postavke
- Putanja `/admin`, brend (logo iz settings), boja `primary #0E8275`.
- Auth: Filament login + **2FA (TOTP)** obavezan; rate-limit na login.
- Navigacija grupisana prema admin meniju iz spec. 11.

## Navigacija panela (grupe → resursi)

```
🏠 Kontrolna tabla (Dashboard – widgeti)
📝 Sadržaj
   ├─ Biznisi            (BusinessResource)
   ├─ Lokaliteti         (LocationResource)
   ├─ Događaji           (EventResource)
   ├─ Oglasi             (AdResource)
   ├─ Priče              (StoryResource)
   └─ Vijesti            (NewsResource)
✅ Odobravanja            (ApprovalQueue – custom page/scope)
🧱 Stranice i izgled
   ├─ Stranice           (PageResource + block builder)
   ├─ Meniji/Navigacija  (MenuResource)
   └─ Header & Footer     (dio Menu/Settings)
👥 Korisnici
   ├─ Korisnici (biznis/autor)  (UserResource)
   ├─ Admini             (AdminResource)
   └─ Uloge i prava      (Shield: RoleResource)
🗺️ Mapa / Lokacije        (PlaceResource)
🖼️ Medijska biblioteka    (MediaResource / curator-style)
🏷️ Taksonomija            (CategoryResource, TagResource)
📊 Logovi aktivnosti      (ActivityResource – read-only)
⚙️ Postavke sistema       (Settings – custom page, spatie/settings)
```

## Sadržajni resursi (univerzalni obrazac — spec. 11B)
Svaki (Business/Location/Event/Ad/Story/News) ima:
- **Tabela:** Naslov | Tip/Kategorija | Autor | **Status (badge)** | Datum | Akcije.
- **Filteri:** status, kategorija, autor, pretraga; **bulk akcije**.
- **Forma:** polja iz [model podataka](01-model-podataka.md) + media upload (naslovna + galerija) + kategorija/oznake + (lat/lng pick na mapi gdje treba).
- **Akcije reda:** Pregledaj · Uredi · **Odobri · Vrati (razlog) · Odbij (razlog)** · Objavi · Arhiviraj · Obriši — vidljive prema statusu i ovlaštenju.
- Prelazi statusa pozivaju iste **Action** klase kao i front (jedan izvor istine, sve se loguje).

## Ključne stranice/komponente

### A) Dashboard (widgeti)
- Brojači: na odobrenju · novi korisnici · aktivni oglasi · nadolazeći događaji.
- Red čekanja (najnovije na odobrenju) · posljednje aktivnosti (log) · brze akcije (+Stranica/+Događaj/+Vijest).

### C) Red odobravanja (📌 TS 8)
- Globalni prikaz svih entiteta u statusu **poslano**, s **preview** kao na frontu (Inertia preview ruta ili Filament infolist).
- Akcije: ✅ Odobri i objavi · ↩️ Vrati na doradu (razlog) · ❌ Odbij (razlog). Razlog **obavezan** pri vraćanju/odbijanju.

### D) Korisnici i uloge
- **UserResource** (biznis/autor): Ime | Email | Uloga | Status | Zadnja prijava; akcije: uredi ulogu, **blokiraj/deaktiviraj**, resetuj lozinku.
- **AdminResource**: upravljanje admin nalozima (+2FA reset). Samo super-admin.
- **Shield**: role/permisije CRUD, automatske policy za sve resurse.

### E) Mapa / lokacije
- PlaceResource: dodavanje/uređivanje tačaka, unos koordinata (klik na mapu ili lat/lng), kategorija, veza ka entitetu (📌 TS 4.9). Filament map field (geoman/leaflet plugin).

### F) Medijska biblioteka
- Centralni upload/pregled (foto/video, uklj. dronske), konverzije/thumb, dodjela sadržaju (spatie/medialibrary + media plugin).

### G) Taksonomija
- CRUD kategorija/podkategorija po modulima + oznake. Menja `constants/categories.js` kao izvor.

### H) Logovi aktivnosti (📌 TS 4.11, TS 6)
- Read-only tabela: Vrijeme | Korisnik (causer) | Akcija | Entitet | IP 🟡. Filteri: korisnik, tip, datum. Iz `activity_log`.

### I) Postavke sistema
- Custom Settings stranica: logo, kontakt, social, footer linkovi/partneri, pravne stranice, priprema za jezike (📌 TS 9).

## Pravila/stanja
- Prazan red odobravanja → poruka „nema sadržaja na odobravanju".
- Sve administrativne radnje (pregled, odobri/odbij/vrati, izmjene, mediji) → **activity_log**.
- Vidljivost akcija i resursa strogo prema **Shield permisijama** (📌 spec. 12 matrica).

## 🔗 Veze
[Admin panel (spec)](../administracija/11-admin-panel.md) · [Uloge i workflow](../administracija/12-korisnicke-uloge-i-workflow.md) · [Model podataka](01-model-podataka.md) · [CMS](03-cms-modularnost.md) · [Auth/sigurnost](05-auth-uloge-sigurnost.md)
</content>
