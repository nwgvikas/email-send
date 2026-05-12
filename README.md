# Makes360 Bulk Email Management Portal

This project implements the hiring assignment: a scalable bulk email portal with contact import, template management, campaign creation, queue-based delivery, logs, and basic reporting.

## Implemented Modules

- Admin authentication with `backoffice/login`
- Admin panel layout with left sidebar menu
- Contact management
  - Add contact manually
  - CSV upload/import
  - Dynamic fields saved in JSON (`extra_fields`)
- Email template management
  - Create templates with placeholders like `{{name}}`, `{{company}}`
- Campaign management
  - Create campaign from template
  - Send now or schedule
  - Auto-attach all contacts to campaign
- Bulk sending (queue based)
  - One queued job per contact (`SendCampaignEmailJob`)
  - Retry support (`tries=3`)
- Logs & reporting
  - Per-recipient send success/failure
  - Campaign logs table and dashboard stats

## Third-Party Email Provider

The app uses Laravel Mail with provider-backed transports. Configure one of:

- Mailgun
- Amazon SES
- SendGrid (SMTP)

Example `.env` for SendGrid SMTP:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=YOUR_SENDGRID_API_KEY
MAIL_FROM_ADDRESS=no-reply@yourdomain.com
MAIL_FROM_NAME="Makes360 Portal"
```

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

Create an admin user (one-time):

```bash
php artisan tinker
```

```php
\App\Models\User::create([
  'name' => 'Admin',
  'email' => 'admin@example.com',
  'password' => bcrypt('password'),
]);
```

## Run

Terminal 1:

```bash
php artisan serve
```

Terminal 2 (queue worker, required):

```bash
php artisan queue:work
```

### Queue driver: `database` vs `redis`

- Default in `.env.example` is **`database`**: jobs go to the `jobs` table (works after `php artisan migrate`). No Redis needed.
- For higher throughput, set **`QUEUE_CONNECTION=redis`**, run a Redis server, then `php artisan queue:work` (same command; Laravel uses the selected driver).
- If the PHP `redis` extension is missing, install the client library: `composer require predis/predis` and set `REDIS_CLIENT=predis` in `.env`.

### Lists in the UI

- Contacts, templates, campaigns, dashboard “recent campaigns”, and campaign log tables support **search** (GET `search=…`) and **pagination** with query string preserved when you change pages.

Optional scheduled dispatch command:

```bash
php artisan campaigns:dispatch-scheduled
```

Login URL:

```text
http://127.0.0.1:8000/backoffice/login
```

## Notes on Scalability

- Queue jobs decouple HTTP requests from send operations.
- Campaign dispatch chunks records in batches to avoid memory spikes.
- Data model supports large contact sets and per-contact tracking.
- Ready to scale further using Redis queue, supervisor, and rate-limited worker pools.
# email-send
