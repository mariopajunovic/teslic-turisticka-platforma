# Deploy na cPanel (push-to-deploy preko SSH)

Produkcija: **cPanel shared hosting**, domen **visitteslic.com**.
Laravel aplikacija je u **`backend/`**. Metod je **push-to-deploy**: sa lokalnog
računara `git push cpanel main` → `post-receive` hook na serveru sve odradi
(checkout + composer install + migrate + optimize).

> Frontend (Vite) se gradi **lokalno** i commit-uje (`backend/public/build`) jer
> shared hosting nema `npm`. Backend zavisnosti (`vendor/`) se grade **na serveru**
> composer-om (ne commituju se).

---

## 1. Arhitektura na serveru

```
/home/visittes/
  repos/teslic.git/           <- BARE repo (push meta ovamo); sadrzi post-receive hook
  teslic/                     <- work-tree (checkout iz bare repo-a, sparse: samo backend/)
    backend/                  <- Laravel root
      public/                 <- Document Root domena treba da gleda OVDJE
        build/                <- commit-ovani Vite build
      .env                    <- rucno na serveru (NIJE u gitu)
      vendor/                 <- composer install na serveru (NIJE u gitu)
      storage/                <- perzistira (NIJE u gitu)
  bin/composer                <- rucno instaliran composer (host ga nema)
  public_html/                <- NE koristi se za app (domen preusmjeriti na backend/public)
```

Bitne serverske putanje:
- SSH: alias `visitteslic` (user `visittes`, home `/home/visittes`)
- PHP (CLI + web): **`/opt/cpanel/ea-php84/root/usr/bin/php`** (PHP 8.4) - OBAVEZNO 8.4
- Composer: `/home/visittes/bin/composer` (poziva se sa `php -d allow_url_fopen=On`)

### Zasto ba PHP 8.4
`composer.lock` je rijeen na PHP 8.4, pa pinuje pakete koji trae `php >=8.4.1`
(Symfony 8.1, Laravel 13.16). **PHP 8.3 puca** na composer platform-check, a web
mora biti 8.4 jer je `vendor/` build-ovan za 8.4. Default CLI na serveru je 8.5 -
ne oslanjati se na njega, hook eksplicitno koristi ea-php84.

---

## 2. Rutinski deploy (svaki put)

Sa lokalnog racunara, iz root-a repo-a:

```bash
cd backend
npm ci                 # ili npm install
npm run build          # Vite -> backend/public/build
cd ..
git add -A
git commit -m "deploy: ..."
git push origin main   # GitHub (source of truth / backup)
git push cpanel main   # <- OVO pokrece deploy na server
```

Hook na serveru automatski: `checkout -f main` (samo `backend/`) → `composer install
--no-dev --optimize-autoloader` → `storage:link` → (ako `.env` postoji) `migrate
--force` + `optimize`. Izlaz hooka se vidi u `git push` outputu (linije `remote: >> ...`).

> Bez `npm run build` prije commita, server ostaje sa starim asetima.

---

## 3. Podeavanje na NOVOM racunaru

1. Kloniraj repo sa GitHuba:
   ```bash
   git clone git@github.com:mariopajunovic/teslic-turisticka-platforma.git
   ```
2. Obezbijedi SSH pristup serveru: dodaj svoj **javni** kljuc u cPanel → SSH Access
   → Manage SSH Keys → Import → Authorize.
3. Dodaj SSH alias u `~/.ssh/config` (da `visitteslic` radi):
   ```
   Host visitteslic
       HostName visitteslic.com        # ili IP servera
       User visittes
       Port 22                          # ili custom port hostinga
       IdentityFile ~/.ssh/tvoj_kljuc
   ```
   Test: `ssh visitteslic 'whoami'` → treba `visittes`.
4. Dodaj `cpanel` remote:
   ```bash
   git remote add cpanel visitteslic:/home/visittes/repos/teslic.git
   ```
   (Bez SSH aliasa moe i puna forma:
   `ssh://visittes@visitteslic.com:22/home/visittes/repos/teslic.git`.)
5. Dalje kao "Rutinski deploy".

---

## 4. Prva (jednokratna) priprema servera - vec uradjeno

Zabiljeeno radi reproduciranja na drugom nalogu/hostingu:

```bash
# composer (host ga nema) - ea-php84 CLI ima allow_url_fopen=Off pa override
P=/opt/cpanel/ea-php84/root/usr/bin/php
mkdir -p ~/bin
curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
$P -d allow_url_fopen=On /tmp/composer-setup.php --install-dir=$HOME/bin --filename=composer

# bare repo + sparse-checkout (samo backend/) + hook
git init --bare -b main ~/repos/teslic.git
git --git-dir=$HOME/repos/teslic.git config core.sparseCheckout true
printf 'backend/\n' > ~/repos/teslic.git/info/sparse-checkout
# hook: ~/repos/teslic.git/hooks/post-receive (vidi sekciju 6) + chmod +x
```

`.env` na serveru (`/home/visittes/teslic/backend/.env`, NIJE u gitu):
```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://visitteslic.com
ASSET_URL=https://visitteslic.com
INERTIA_SSR_ENABLED=false
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=visittes_web
DB_USERNAME=visittes_usr
DB_PASSWORD="..."           # lozinke sa # @ } MORAJU biti pod dvostrukim navodnicima
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```
`APP_KEY` generisan sa `php artisan key:generate`. Poslije izmjene `.env`:
`php artisan config:cache`.

### Podaci koji NISU u gitu (storage/)
`storage/app/translations-import.json` se ne deployuje (gitignore) pa se prenosi rucno:
```bash
scp backend/storage/app/translations-import.json \
    visitteslic:/home/visittes/teslic/backend/storage/app/
ssh visitteslic 'cd ~/teslic/backend && \
    /opt/cpanel/ea-php84/root/usr/bin/php artisan db:seed --class=TranslationSeeder --force'
```
Bez toga frontend prevodi fale (TranslationSeeder preskoci uvoz).

---

## 5. Document Root - bridge u public_html (docroot je zakljucan)

Ovaj hosting NE da mijenjati Document Root primarnog domena (ostaje `/public_html`).
Zato se app servira preko **bridge-a u `public_html`** koji `post-receive` hook
AUTOMATSKI odrzava pri svakom deployu (self-healing):
- `public_html/index.php` → boot-uje Laravel iz `/home/visittes/teslic/backend`
  (apsolutne putanje umjesto `__DIR__/..`).
- `public_html/.htaccess` → cPanel handler blokovi + Laravel front-controller rewrite
  + `DirectoryIndex index.php`.
- `public_html/build`, `public_html/storage` i svi staticki fajlovi iz
  `backend/public/*` → **symlinkovi** ka `backend/public/...` (owner-match, rade sa
  SymLinksIfOwnerMatch).
- Prazni `public_html/index.html` je uklonjen (`index.html.bak`) jer je zasjenjivao index.php.

Posljedica: ne diras nista rucno oko docroota. Novi staticki fajlovi u `backend/public`
se automatski re-symlinkuju na sljedecem `git push cpanel main`.

**MultiPHP Manager** za `visitteslic.com` mora biti **PHP 8.4** (vec postavljeno).

Provjera: `curl -sI https://visitteslic.com/` → Laravel odgovor (ili 503 "U pripremi"
ako je rezim odrzavanja ukljucen, vidi dolje).

### Rezim odrzavanja
`SiteSettings.odrzavanje` (admin: Podesavanja → Odrzavanje) - kad je ON, javni dio
vraca 503 stranicu "U pripremi". Izuzeti: `/administracija/*`, `/admin/*`, `/build`,
`/storage`, plus **ulogovan admin** (guard `admin`) vidi normalan sajt. `optimize` u
hooku kesira `laravel-settings` pa se stanje toggla primi na deployu.

---

## 6. `post-receive` hook (referenca)

`/home/visittes/repos/teslic.git/hooks/post-receive` (chmod +x):
```bash
#!/bin/bash
set -e
APP=/home/visittes/teslic
BACKEND=$APP/backend
GITDIR=/home/visittes/repos/teslic.git
PHP=/opt/cpanel/ea-php84/root/usr/bin/php
COMPOSER="$PHP -d allow_url_fopen=On /home/visittes/bin/composer"
git --work-tree="$APP" --git-dir="$GITDIR" checkout -f main
cd "$BACKEND"
export COMPOSER_MEMORY_LIMIT=-1
$COMPOSER install --no-dev --optimize-autoloader --no-interaction --prefer-dist
$PHP artisan storage:link || true
if [ -f "$BACKEND/.env" ]; then
  $PHP artisan migrate --force || echo "!! migrate FAIL"
  $PHP artisan optimize || echo "!! optimize FAIL"
else
  echo ">> nema .env - preskacem migrate/optimize"
fi
echo ">> DEPLOY GOTOV"
```

---

## 7. Ceste greske / napomene

- **200 ali placeholder stranica** → Document Root jos nije prebacen na `backend/public`.
- **composer platform-check puca (php >=8.4.1)** → hook koristi ea-php84; provjeri
  da web MultiPHP nije ostao na 8.3.
- **`public/build` mora biti commit-ovan** - shared hosting nema npm; uvijek
  `npm run build` prije commita.
- **SSR iskljucen** (`INERTIA_SSR_ENABLED=false`).
- **Mailpit je samo dev** - produkcija treba pravi SMTP u `.env`.
- Re-seed pojedinacnih seedera: `php artisan db:seed --class=X --force` (idempotentni).
  NE koristiti `migrate:fresh` na produkciji (brise sve, ukljucujuci admin izmjene stranica).
- Deploy status uzivo: `ssh visitteslic 'cd ~/teslic/backend && \
  /opt/cpanel/ea-php84/root/usr/bin/php artisan about'`.
