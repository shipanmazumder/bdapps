# BDApps Portal (Laravel 13)

## Overview
This project is a Laravel-based portal for managing BDApps integrations:
- User and admin login/management
- App registration and configuration
- SMS subscription handling
- USSD subscription handling
- OTP request and OTP verification APIs

## Tech Stack
- PHP `^8.3`
- Laravel `^13.0`
- MySQL

## Requirements
- PHP 8.3+
- Composer
- MySQL running locally (or remote DB)

## Setup
1. Install dependencies:
```bash
php composer.phar install --no-interaction
```

2. Prepare environment:
```bash
cp .env.example .env
php artisan key:generate
```

3. Configure database in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bdapps
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

4. Run migrations and seeders:
```bash
php artisan migrate --seed
```

5. Start local server:
```bash
php artisan serve
```

## Default Seeded Users
When running `migrate --seed` (or `db:seed`), these users are created/updated:
- Admin: `admin@bdapps.local` / `password` (role `1`)
- User: `user@bdapps.local` / `password` (role `2`)

## API Endpoints
All endpoints are `POST`:
- `/api/bdapps/ussd`
- `/api/bdapps/sms`
- `/api/bdapps/subscription-notify`
- `/api/bdapps/otp/request`
- `/api/bdapps/otp/verify`

## Notes
- Models use `App\Models\...` namespace.
- If autoload issues appear after pulling changes:
```bash
php composer.phar dump-autoload
```
