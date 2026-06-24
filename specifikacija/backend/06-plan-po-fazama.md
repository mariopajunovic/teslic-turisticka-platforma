# 06 — Plan po fazama (redoslijed izrade)

> Princip: **od glavnih stvari ka ostalima**, uz **odobrenje na svakoj fazi**. Za svaku stavku gledamo postojeći `frontend/` i preuzimamo komponentu koja nam treba. Backend se prilagođava postojećem UI ugovoru.

## Pregled faza

| Faza | Naziv | Rezultat (Definition of Done) | Approval gate |
|------|-------|-------------------------------|:-------------:|
| **B0** | Skeleton | Laravel 11 + Inertia + Vue + Vite + Tailwind tokeni; `frontend/src` → `resources/js`; app se diže, jedna stranica radi. | ✅ |
| **B1** | Auth temelji | `users` (Fortify+Inertia) + `admins` (Filament) guardovi; spatie/permission; Shield; prazan `/admin` login + 2FA. | ✅ |
| **B2** | Model + seed | Migracije svih entiteta/taksonomije/CMS tabela; modeli + traits; **seed iz postojećih JSON-a**; status enum + Action skelet. | ✅ |
| **B3** | Filament sadržaj | Resursi za 5 entiteta (+vijesti): tabele/forme/filteri/media/kategorije; **workflow akcije** (odobri/vrati/odbij/objavi); red odobravanja; logovi. | ✅ |
| **B4** | Javni front na podacima | Inertia kontroleri + props; postojeći listinzi/detalji rade na **pravim podacima** (zamjena `api.js`). Glavne stranice prve (Početna, Domaće, Turizam, Događaji), pa ostale. | ✅ |
| **B5** | CMS modularnost | `pages`+`blocks` builder u Filamentu; `PageRenderer.vue` + registar blok→komponenta; meniji/header/footer/settings iz baze (Inertia shared). | ✅ |
| **B6** | Korisnički paneli | `/nalog` (biznis/autor) na backend: kreiranje nacrta, upload, „pošalji na odobrenje", statusi/razlozi; Policy vlasništva. | ✅ |
| **B7** | Sigurnost + forme | CAPTCHA + rate-limit na sve javne forme; activity_log kompletan; blokada naloga; reset/2FA tokovi; e-mail obavijesti 🟡. | ✅ |
| **B8** | QA / produkcija | Pretraga (header), SEO/meta po stranici, SSR opc., a11y, responsive, backup/SSL/deploy (📌 TS 7), primopredaja (📌 TS 15). | ✅ |

## Redoslijed unutar B3/B4 („glavne ka ostalima")
1. **Biznisi** (Domaće je najbolje) — najbogatiji entitet, vodeći modul.
2. **Turizam (lokaliteti)** → 3. **Događaji** → 4. **Oglasi** → 5. **Priče** → 6. **Vijesti**.
Za svaki: Filament resurs → seed provjera → Inertia listing → detalj → mapa/related.

## Veza s postojećim frontend planom
Faze B-serije nadovezuju se na završene F-faze iz [`../frontend/00-PLAN-RADA.md`](../frontend/00-PLAN-RADA.md): UI komponente (F0–F11) već postoje → B-faze ih **povezuju na backend**, ne grade ispočetka.

## Rizici / otvorena pitanja
1. **Brend boja** — front je na teal `#0E8275`; tender pominje `#00529C`. Potvrda. (settings.brand omogućava izmjenu bez koda.)
2. **Dubina detalj-template modularnosti** — koliko sekcija detalja (biznis/lokalitet…) treba biti uredivo iz admina vs fiksno. Predlog: redoslijed/uključenost sekcija konfigurabilan, polja fiksna.
3. **Hosting okruženje** — PHP verzija, baza (MySQL/MariaDB/Postgres), mail provider, CAPTCHA provider (hCaptcha vs Turnstile).
4. **SSR** — da li je SEO javnih stranica prioritet za v1 (utiče na B8).
5. **Migracija medija** — trenutno prazne `slika`/`galerija` u mock-u; treba upload pravih materijala (foto/dron) u medialibrary.
6. **Višejezičnost** — da li v1 ili samo priprema sheme (📌 TS 9).

## 🔗 Veze
[README](README.md) · [Arhitektura](00-arhitektura-i-tech-stack.md) · [Model](01-model-podataka.md) · [Filament](02-filament-admin.md) · [CMS](03-cms-modularnost.md) · [Front](04-inertia-frontend.md) · [Auth](05-auth-uloge-sigurnost.md)
</content>
