# SmartKids — Render deployment notes

Production target: **Render** (PHP web service) + the bundled MySQL on the same
host or a Render-managed MySQL add-on. Supabase / Postgres are not used.

## Prerequisites

- PHP 8.3+ with extensions: `openssl`, `pdo_mysql`, `mbstring`, `fileinfo`, `gd`,
  `intl`, `zip` (already enabled in our local php.ini).
- Composer 2.x (`composer install --no-dev --optimize-autoloader` at build time).
- Node 20+ for the `npm run build` step.

## First-time bootstrap

```bash
# At the project root on the Render shell (or any clean MySQL host):

# 1. Create the schema + seed it
mysql -u root -p < database/smartkids_init.sql

# 2. Install PHP deps + build assets
composer install --no-dev --optimize-autoloader
npm ci && npm run build

# 3. Configure .env (copy .env.example and fill these)
APP_NAME="SmartKids"
APP_ENV=production
APP_URL=https://<your-domain>
APP_KEY=                       # leave empty, then run: php artisan key:generate
APP_DEBUG=false
DB_CONNECTION=mysql
DB_HOST=<mysql-host>
DB_PORT=3306
DB_DATABASE=smartkids
DB_USERNAME=<user>
DB_PASSWORD=<password>

# 4. Final touches
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Recurring tasks

Daily subscription lifecycle (notify due-soon, freeze overdue, mark SaaS
payments overdue) — scheduled at 06:00 server time in `routes/console.php`:

```bash
* * * * * cd /opt/render/project/src && php artisan schedule:run >> /dev/null 2>&1
```

(Render's cron / scheduler equivalent.)

## Seed accounts (matching `database/smartkids_init.sql`)

| Role        | Email                              | Password   |
|-------------|------------------------------------|------------|
| SuperAdmin  | `superadmin@smartkids.tn`          | `password` |
| Admin       | `etoile@smartkids.tn`              | `password` |
| Admin       | `soleil@smartkids.tn`              | `password` |
| Parents     | `parent1.etoile@example.com` (...) | passcode in DB |
| Educators   | `anissa.belhadj@smartkids.tn` (...) | passcode in DB |

Parents and educators log in via `/login/code` using the 6-digit `passcode`
column (no password — managed by their admin).

## Re-seeding

To re-import a clean dataset (drops the smartkids database first):

```bash
mysql -u root -p < database/smartkids_init.sql
```

To regenerate the dump after schema/seed changes (from local dev):

```bash
"C:\xampp\mysql\bin\mysqldump.exe" -u root \
  --default-character-set=utf8mb4 --add-drop-database --add-drop-table \
  --routines --triggers --databases smartkids \
  > database/smartkids_init.sql
```

## Things explicitly **not** wired

- Supabase / Postgres — stayed on XAMPP MySQL per project decision.
- Payment gateway — the subscription card simulates the transaction (records
  a `saas_payments` row + advances `subscription_due_at`).
- Admin email/password auth — the seeded admin accounts use a bcrypt password
  so local Breeze login works, but the user-direction is to delegate this to
  Supabase Auth at SaaS-launch time.
