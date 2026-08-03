# Project Setup Guide

> Quick guide to run the project (Laravel 10) — Frontend: HTML, CSS/SCSS, Bootstrap 4.6, JS, jQuery — Backend: PHP 8 — DB: MySQL 8

---

## Requirements
- PHP 8.x with required extensions (pdo, mbstring, tokenizer, xml, ctype, json, openssl, fileinfo, gd).  
- Composer  
- Node.js + npm  
- MySQL 8  
- Apache (for production)

---

## Setup Steps (Local / Server)

### 1. Install Backend Dependencies
```bash
composer install --no-dev
```

### 2. Environment File
```bash
cp .env.example .env
```
Edit `.env` with your database, mail, and APP_URL settings:
```
APP_NAME=YourMyApp
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=project_db
DB_USERNAME=root
DB_PASSWORD=secret
```

### 3. Generate App Key
```bash
php artisan key:generate
```

### 4. Import Database
A ready SQL file is included at:
```
/database/db.sql
```
Please import it directly into your MySQL server.

### 5. Run Migrations & Seeders (if needed)
```bash
php artisan migrate --seed
```

### 6. Storage Link
```bash
php artisan storage:link
```

### 7. Run Local Server
```bash
php artisan serve
```
Or configure Apache for production.

---

## Production Setup Tips
- Set in `.env`: `APP_ENV=production` and `APP_DEBUG=false`.  
- Build optimized assets:
```bash
npm run prod
```
- Cache configs:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
- Make sure SSL (Let's Encrypt) and security headers (CSP, HSTS) are configured.

---

## Useful Commands
```bash
# Run the server
php artisan serve

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rerun migrations (Warning: will erase data)
php artisan migrate:rollback
```

---
Developed by [Saleh Megawer](https://salehmegawer.com/)