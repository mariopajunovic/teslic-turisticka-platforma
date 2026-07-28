# Deployment na cPanel (Git)

Laravel aplikacija je u **`backend/`**. Ostatak repo-a (`pencil/`, `specifikacija/`,
geojson, logo...) se NE deployuje - `.cpanel.yml` dira samo `backend/`.

Frontend (Vite) se gradi **lokalno** i commit-uje (shared hosting nema `npm`).
cPanel povlači repo i pokreće `.cpanel.yml` (composer + artisan).

---

## Arhitektura na serveru

```
/home/CPANELUSER/teslic/            <- ovdje cPanel klonira repo (Repository Path)
  backend/                          <- Laravel root (__APPDIR__)
    public/                         <- DOCUMENT ROOT domena pokazuje ovdje
      build/                        <- commit-ovani Vite build
    .env                            <- ručno postavljen na serveru (NIJE u gitu)
    vendor/                         <- composer install na serveru (NIJE u gitu)
    storage/                        <- perzistira (NIJE u gitu)
  pencil/, specifikacija/ ...       <- ignorisano pri deployu
```

`.git` folder ostaje IZNAD `public/` pa nije web-dostupan. Nema kopiranja u
`public_html` - domen direktno gleda `backend/public`.

---

## A. Jednokratna priprema (lokalno)

1. `public/build` je otključan u `backend/.gitignore` (već urađeno) da bi se
   produkcijski build commit-ovao.
2. Provjeri da `.env` NIJE u gitu (jeste ignorisan - dobro).

## B. Svaki put PRIJE deploya (lokalno)

```bash
cd backend
npm ci                 # ili npm install
npm run build          # Vite -> backend/public/build
cd ..
git add -A
git commit -m "deploy: build + izmjene"
git push               # na origin (GitHub/GitLab) ili direktno na cPanel repo
```

> Bez `npm run build` prije commita, server bi ostao sa starim asetima.

## C. Jednokratna priprema (server / cPanel)

1. **Git Version Control** (cPanel → Files → *Git™ Version Control*):
   - *Create* → *Clone a Repository*.
   - **Clone URL**: HTTPS ili SSH URL tvog repo-a (GitHub/GitLab). Za privatni
     repo dodaj deploy key (SSH) ili token.
   - **Repository Path**: npr. `/home/CPANELUSER/teslic`.
2. **`.env`** na serveru: kopiraj `backend/.env.example` u
   `/home/CPANELUSER/teslic/backend/.env` (File Manager ili SSH) i popuni
   (vidi sekciju E). `php artisan key:generate` ako `APP_KEY` prazan.
3. **Document Root**: cPanel → *Domains* → domen → *Manage* → Document Root =
   `/home/CPANELUSER/teslic/backend/public`.
4. **Dozvole**: `storage/` i `bootstrap/cache/` moraju biti upisive
   (`chmod -R 775` preko SSH; vlasnik = cPanel user).
5. **Prvi build na serveru** (ručno, jednom, preko SSH ili kroz Deploy iz sekcije D):
   ```bash
   cd /home/CPANELUSER/teslic/backend
   /opt/cpanel/composer/bin/composer install --no-dev --optimize-autoloader
   php artisan storage:link
   php artisan migrate --force
   ```

## D. `.cpanel.yml` (u root-u repo-a) - popuni placeholdere

Otvori `.cpanel.yml` i zamijeni:
- `__APPDIR__` → `/home/CPANELUSER/teslic/backend`
- `__PHP__` → PHP CLI putanja (`which php` preko SSH; često `/usr/local/bin/php`
  ili MultiPHP `/opt/cpanel/ea-php83/root/usr/bin/php`)
- `__COMPOSER__` → obično `/opt/cpanel/composer/bin/composer` (`which composer`)

Deploy: cPanel → *Git Version Control* → repo → *Manage* → **Deploy HEAD Commit**.
To pokrene taskove iz `.cpanel.yml` (composer install, migrate, cache).

## E. Produkcijski `.env` (bitno)

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tvoj-domen.ba
INERTIA_SSR_ENABLED=false          # ostaje false (SSR bi tražio node servis)

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=...       DB_USERNAME=...      DB_PASSWORD=...

# PRAVI SMTP (Mailpit je samo za dev!):
MAIL_MAILER=smtp
MAIL_HOST=...   MAIL_PORT=587   MAIL_USERNAME=...   MAIL_PASSWORD=...
MAIL_FROM_ADDRESS="no-reply@tvoj-domen.ba"

SESSION_DRIVER=database            # ili file
CACHE_STORE=database               # ili file
QUEUE_CONNECTION=database
```

Nakon svake promjene `.env` na serveru: `php artisan config:cache`.

---

## Automatski deploy na push

`.cpanel.yml` se pokreće pri deployu. Za AUTOMATSKI deploy nakon `git push`
imaš nekoliko opcija:

- **Opcija 1 - push direktno na cPanel repo:** dodaj cPanel repo kao remote
  (SSH: `ssh://CPANELUSER@domen/home/CPANELUSER/teslic`) i push-uj tamo; cPanel
  pokrene deployment nakon prijema.
- **Opcija 2 - webhook:** na GitHub/GitLab dodaj webhook koji zove cPanel
  deploy endpoint (cPanel *Git VC* → *Manage* prikazuje deploy naredbu/URL).
- **Opcija 3 - cron:** cPanel *Cron Jobs*, npr. svakih 5 min:
  ```
  cd /home/CPANELUSER/teslic && git pull origin main && \
  cd backend && /usr/local/bin/php artisan migrate --force && \
  /usr/local/bin/php artisan optimize
  ```

## Alternativa: bare repo + post-receive hook (kao u članku, fully-auto)

Ako želiš potpuno automatski deploy na push (bez cPanel Git VC UI):

1. Preko SSH napravi bare repo:
   ```bash
   mkdir -p ~/repos/teslic.git && cd ~/repos/teslic.git && git init --bare
   ```
2. `hooks/post-receive` (chmod +x):
   ```bash
   #!/bin/bash
   APP=/home/CPANELUSER/teslic
   PHP=/usr/local/bin/php
   COMPOSER=/opt/cpanel/composer/bin/composer
   git --work-tree="$APP" --git-dir="$HOME/repos/teslic.git" checkout -f main
   cd "$APP/backend" || exit 1
   $COMPOSER install --no-dev --optimize-autoloader --no-interaction
   $PHP artisan migrate --force
   $PHP artisan storage:link || true
   $PHP artisan optimize
   ```
3. Lokalno dodaj remote i push-uj:
   ```bash
   git remote add cpanel ssh://CPANELUSER@domen/home/CPANELUSER/repos/teslic.git
   git push cpanel main
   ```
   Svaki `git push cpanel main` automatski deployuje.

---

## Napomene / česte greške

- **`public/build` mora biti commit-ovan** - shared hosting nema `npm`. Uvijek
  `npm run build` prije commita.
- **SSR je isključen** (`INERTIA_SSR_ENABLED=false`) - dobro za shared hosting,
  sve se renderuje na klijentu.
- **Mailpit je samo dev.** Produkcija treba pravi SMTP u `.env`.
- **APP_DEBUG=false** na produkciji (sigurnost).
- Nakon deploya, ako se ne vide izmjene: `php artisan optimize:clear` pa ponovo
  `config:cache route:cache view:cache`.
- Ako composer nije dostupan na hostingu: commit-uj i `vendor/` (izbaci
  `/vendor` iz `backend/.gitignore`) - ali repo postane veći.
