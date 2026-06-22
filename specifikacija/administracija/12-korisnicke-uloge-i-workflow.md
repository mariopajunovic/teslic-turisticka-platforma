# 12 — Korisničke uloge i workflow odobravanja

📌 **TS 5 / TS 8**

## Korisničke uloge (🔴 minimum — 📌 TS 5)
| Uloga | Opis |
|-------|------|
| **Administrator** | Puna prava nad sistemom, korisnicima, sadržajima, odobravanjima i postavkama. |
| **Biznis korisnik** | Upravlja **isključivo vlastitim** profilom, sadržajima i prijedlozima objava. Bez direktnog javnog objavljivanja. |
| **Autor** | Kreira i uređuje **vlastite** sadržaje (priče/blog). Bez direktnog javnog objavljivanja. |
| **Posjetilac (javnost)** | Bez registracije; čita sav objavljeni sadržaj, koristi forme/mapu. |

## Matrica prava (za dizajn ekrana i vidljivosti dugmadi)
| Akcija | Admin | Biznis | Autor | Javnost |
|--------|:----:|:------:|:-----:|:-------:|
| Čitanje objavljenog sadržaja | ✅ | ✅ | ✅ | ✅ |
| Kreiranje biznis profila | ✅ | ✅ (vlastiti) | ❌ | ❌ |
| Kreiranje priča/bloga | ✅ | ❌ | ✅ (vlastite) | ❌ |
| Kreiranje oglasa | ✅ | ✅ (vlastiti) | ❌ | ❌ |
| Direktno objavljivanje bez odobrenja | ✅ | ❌ | ❌ | ❌ |
| Odobravanje/odbijanje sadržaja | ✅ | ❌ | ❌ | ❌ |
| Upravljanje korisnicima i ulogama | ✅ | ❌ | ❌ | ❌ |
| Upravljanje kategorijama/oznakama | ✅ | ❌ | ❌ | ❌ |
| Upravljanje mapom/lokacijama | ✅ | ❌ | ❌ | ❌ |
| Blokada/deaktivacija naloga | ✅ | ❌ | ❌ | ❌ |
| Pregled logova aktivnosti | ✅ | ❌ | ❌ | ❌ |

> Biznisi i autori **ne smiju** imati mogućnost direktnog javnog objavljivanja bez odobrenja administratora (📌 TS 8).

---

## Workflow odobravanja sadržaja (📌 TS 8)
Primjenjuje se na: **biznis profile, oglase i priče**.

```
   ┌─────────┐   pošalji    ┌────────────────────┐
   │  NACRT  │ ───────────► │ POSLANO NA ODOBRENJE│
   └─────────┘              └─────────┬───────────┘
        ▲                             │  admin pregled
        │ vraćeno na doradu           ▼
        │                   ┌──────────────────────────┐
        └─────────────────  │ ODBIJENO / VRAĆENO (razlog)│
                            └──────────────────────────┘
                                      │ ako odobreno
                                      ▼
                            ┌──────────┐    ┌────────────┐
                            │ ODOBRENO │ ─► │ OBJAVLJENO │
                            └──────────┘    └────────────┘
```

Statusi: **nacrt · poslano na odobrenje · odobreno · objavljeno · odbijeno** (+ za oglase: **arhivirano** po isteku roka).

### Pravila prikaza po statusu (za dizajn)
- **Nacrt / na odobrenju / odbijeno** — vidljivo samo vlasniku i adminu; na frontu badge statusa.
- **Objavljeno** — javno vidljivo.
- Pri **odbijanju/vraćanju** admin unosi **razlog**, koji se prikazuje vlasniku uz mogućnost dorade i ponovnog slanja.

## Administrativne radnje koje se evidentiraju (📌 TS 8)
Pregled prijedloga, odobravanje/odbijanje/vraćanje, izmjene, upravljanje medijima — sve se bilježi u [logovima](11-admin-panel.md).

## 🔗 Veze
[Admin panel](11-admin-panel.md) · [User administracija](13-user-administracija.md) · [Profil biznisa](../stranice/03-domace-je-najbolje.md) · [Oglasi](../stranice/06-poslovne-prilike-oglasi.md) · [Priče](../stranice/08-price-iz-teslica.md)
