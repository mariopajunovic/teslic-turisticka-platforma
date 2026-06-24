# 05 — Auth, uloge i sigurnost

> Realizuje [12 — Uloge i workflow](../administracija/12-korisnicke-uloge-i-workflow.md), [13 — User administracija](../administracija/13-user-administracija.md) i [15 — Sigurnost](../15-sigurnost-i-pristup.md).

## Dva odvojena auth sistema (odluka)

```
┌─────────────────────────────┐        ┌──────────────────────────────┐
│ web guard  →  users          │        │ admin guard  →  admins        │
│ Laravel Fortify + Inertia    │        │ Filament auth + 2FA (obavezno)│
│ uloge: BIZNIS, AUTOR         │        │ uloge: ADMINISTRATOR, UREDNIK │
│ rute: javni sajt + /nalog    │        │ ruta: /admin                  │
└─────────────────────────────┘        └──────────────────────────────┘
        sve role-based preko spatie/laravel-permission (po guardu)
```

- **`users`** — javni korisnici koji kreiraju sadržaj (biznis/autor). Nikad ne pristupaju `/admin`.
- **`admins`** — zaposleni naručioca koji upravljaju platformom. Odvojena tabela/model/guard → manja površina napada, jasna sigurnosna granica (📌 TS 6 „odvojen, zaštićen pristup `/admin`").
- **Posjetilac (javnost)** — bez naloga; čita objavljeno, koristi forme/mapu.

## A) Korisnici (web guard)

### Registracija (`/registracija`, `/pridruzi-se/...`)
- Tip naloga: **biznis** ili **autor** (`role`).
- Polja po [Pridruži se](../stranice/09-pridruzi-se.md); obavezna saglasnost + **CAPTCHA**.
- Nakon slanja: nalog `status = na_odobrenju`; poruka da ide na pregled admina; ne može se prijaviti dok admin ne odobri (📌 spec. 13A).

### Prijava (`/prijava`)
- Email + lozinka; linkovi „Zaboravljena lozinka", „Pridruži se".
- **Jake lozinke** (indikator jačine), **rate-limiting** (anti brute-force) — Fortify + `RateLimiter` (📌 TS 6).
- `status`: `na_odobrenju` → poruka „čeka odobrenje"; `blokiran` → jasna poruka, login odbijen.

### Reset / postavke
- Reset lozinke (e-mail token). Postavke naloga: izmjena podataka/e-maila/lozinke; e-mail obavijesti o statusu objava (🟡).

### Ovlaštenja (Policy)
- Biznis: CRUD **vlastitog** profila/oglasa (nacrt) + slanje na odobrenje. Bez objavljivanja.
- Autor: CRUD **vlastitih** priča (nacrt) + slanje na odobrenje. Bez objavljivanja.
- Vlasništvo se provjerava `user_id == auth()->id()` u Policy; nikad tuđi sadržaj.

## B) Admini (admin guard)
- Login na `/admin` + **2FA (TOTP)** obavezno (📌 TS 6); rate-limit.
- **Shield** mapira role→permisije nad svim Filament resursima.
- Uloge: **administrator** (sve), opc. **urednik** (sadržaj + odobravanje, bez upravljanja adminima/postavkama).
- Matrica prava prema [spec. 12](../administracija/12-korisnicke-uloge-i-workflow.md) određuje vidljivost akcija.

## C) Workflow odobravanja (📌 TS 8)
Statusi i prelazi: vidi [model podataka §2](01-model-podataka.md#2-workflow-statusa-📌-ts-8-spec-12). Pravila:
- Biznisi/autori **ne mogu** direktno objaviti — samo „pošalji na odobrenje".
- Admin: odobri/objavi, vrati na doradu (**razlog obavezan**), odbij (**razlog obavezan**).
- Razlog vidljiv vlasniku; vlasnik dorađuje i ponovo šalje.

## D) Sigurnosni zahtjevi (📌 TS 6/7/8 → implementacija)

| Zahtjev | Realizacija |
|---------|-------------|
| Jake admin lozinke | password policy + indikator; 2FA obavezno za admine |
| 2FA za admine | Filament 2FA / Fortify TOTP na admin guardu |
| Razdvojene uloge/prava | spatie/permission + Policy + Shield (oba guarda) |
| Evidencija prijava i aktivnosti | spatie/activitylog: login/logout + sve admin radnje (causer, IP, entitet) |
| CAPTCHA na javnim formama | hCaptcha/Turnstile rule na: kontakt, reg. biznis/autor, upit biznisu |
| Rate limiting | `RateLimiter` na login/forme (poruke pri previše pokušaja) |
| XSS/SQLi/CSRF | Eloquent (bind), Blade/Vue escaping, Laravel CSRF, sanitizacija rich-text (allowlist), bez korisničkog HTML/PHP-a |
| Odvojen `/admin` | zaseban guard/model + (opc.) IP/2FA ograničenja |
| Zaštita sesija | Laravel session, secure/httpOnly cookies, istek sesije, sigurna odjava |
| Blokada/deaktivacija naloga | `users.status=blokiran` (admin akcija) → login odbijen |

## E) Hosting/kontinuitet (📌 TS 7 — kontekst)
SSL, dnevni/sedmični backup baze i fajlova (odvojena lokacija), firewall, stabilno produkciono okruženje; po primopredaji naručilac dobija sve pristupe i admin prava (📌 TS 15).

## 🔗 Veze
[Uloge i workflow](../administracija/12-korisnicke-uloge-i-workflow.md) · [User administracija](../administracija/13-user-administracija.md) · [Sigurnost](../15-sigurnost-i-pristup.md) · [Filament](02-filament-admin.md) · [Inertia front](04-inertia-frontend.md)
</content>
