# Backend specifikacija — Laravel + Filament + Inertia/Vue

> Tehnička razrada **backend i integracije fronta** za platformu TO Teslić.
> Dopuna postojećoj specifikaciji (`specifikacija/`) i frontend planu (`specifikacija/frontend/`).
> Tender br. 106-1/26 — JU Turistička organizacija općine Teslić.

## Cilj
Pretvoriti postojeći **Vue 3 SPA** (`frontend/`, mock JSON) u **jedan Laravel monolit** s:
- **Inertia 2 + Vue 3** za javni sajt i korisničke naloge — **postojeće Vue komponente se ponovo koriste 1:1**;
- **Filament 3** admin panel na `/admin` za potpuno samostalno upravljanje sadržajem (📌 TS 4.1, 4.11);
- **potpuno modularnim CMS-om** (stranice od blokova, meniji, header/footer, settings) — „kao WordPress, ali jednostavnije" — bez programerskih intervencija za osnovne radnje;
- **role-based** kontrolom pristupa i **workflowom odobravanja** (📌 TS 5, TS 8).

## Ključne odluke (potvrđene)
1. **Render fronta:** Inertia + Vue 3 (ne odvojeni SPA). Reuse postojećih komponenti iz `frontend/src`.
2. **CMS modularnost:** **potpuni block-builder** — sve stranice se slažu iz blokova u Filamentu.
3. **Korisnički paneli (biznis/autor):** **Inertia/Vue front** koji koristi postojeće `account/*` views (dizajn iz spec. 13), ne Filament.
4. **Auth podjela:**
   - **`users`** (web guard, Laravel Fortify + Inertia) → uloge **biznis** i **autor**;
   - **`admins`** (zaseban model + guard) → Filament panel `/admin`, uloge admin/urednik;
   - sve **role-based** (spatie/laravel-permission na oba guarda).

## Sadržaj
| # | Dokument | Tema |
|---|----------|------|
| 00 | [Arhitektura i tech stack](00-arhitektura-i-tech-stack.md) | monolit, paketi, struktura foldera, build |
| 01 | [Model podataka](01-model-podataka.md) | entiteti, taksonomija, workflow, CMS tabele, ERD |
| 02 | [Filament admin panel](02-filament-admin.md) | resursi, widgeti, red odobravanja, Shield, 2FA |
| 03 | [CMS modularnost (block-builder)](03-cms-modularnost.md) | stranice, blokovi, meniji, header/footer, mapiranje blok→Vue |
| 04 | [Inertia + Vue front](04-inertia-frontend.md) | migracija fronta, reuse komponenti, korisnički paneli |
| 05 | [Auth, uloge i sigurnost](05-auth-uloge-sigurnost.md) | dva guarda, role/permisije, CAPTCHA, rate-limit, logovi |
| 06 | [Plan po fazama](06-plan-po-fazama.md) | redoslijed izrade, approval gates, DoD |

## Princip rada
Gradimo **od glavnih stvari ka ostalima**, uz **odobrenje na svakoj fazi**. Za svaku stavku se gleda postojeći `frontend/` folder i preuzima komponenta koja nam treba; backend se prilagođava postojećem UI ugovoru (`services/api.js` oblik podataka), a ne obrnuto.
</content>
</invoke>
