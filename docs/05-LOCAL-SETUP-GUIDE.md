# Local Machine Setup Guide

Complete guide for setting up the Property Management System on your local machine with MariaDB.

---

## Prerequisites

Before you begin, ensure you have the following installed on your **local machine**:

### Required Software

1. **PHP 8.2 or higher**
   - Download: https://www.php.net/downloads
   - Windows: Use XAMPP, WAMP, or Laragon
   - macOS: `brew install php@8.2`
   - Linux: `sudo apt install php8.2` or `sudo yum install php82`

2. **Composer 2.x**
   - Download: https://getcomposer.org/download/
   - Verify: `composer --version`

3. **Node.js 18.x or higher & npm**
   - Download: https://nodejs.org/
   - Verify: `node --version` and `npm --version`

4. **MariaDB 10.x or MySQL 8.x**
   - MariaDB: https://mariadb.org/download/
   - MySQL: https://dev.mysql.com/downloads/mysql/
   - Verify: `mysql --version`

5. **Git**
   - Download: https://git-scm.com/downloads
   - Verify: `git --version`

### PHP Extensions Required

Make sure these PHP extensions are enabled (check `php.ini`):
- `pdo_mysql`
- `mbstring`
- `openssl`
- `tokenizer`
- `xml`
- `ctype`
- `json`
- `bcmath`
- `fileinfo`
- `zip`

---

## Step-by-Step Setup

### 1. Clone or Download the Repository

**Option A: If you have Git access to the repository**
```bash
# Clone from your repository (replace with your actual repo URL)
git clone https://github.com/YourUsername/Property_Management_System.git

cd Property_Management_System
git checkout claude/pms-laravel-migration-01WgWzuWHZa8XmPXE8e8h2hC
```

**Option B: Download as ZIP**
- Download the repository as a ZIP file
- Extract to your desired location
- Open terminal/command prompt in that directory

### 2. Navigate to Laravel Project

```bash
cd pms-laravel
```

### 3. Install PHP Dependencies

```bash
composer install
```

**Troubleshooting:**
- If you get memory errors: `php -d memory_limit=-1 /path/to/composer install`
- If you get extension errors: Enable required extensions in `php.ini`

### 4. Install Node Dependencies

```bash
npm install
```

### 5. Configure Environment

```bash
# Copy the example environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 6. Configure Database

Edit `.env` file and update these lines:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pms_db
DB_USERNAME=root              # Your MariaDB username
DB_PASSWORD=your_password     # Your MariaDB password
```

### 7. Create Database

**Option A: Using MySQL/MariaDB Command Line**
```bash
# Login to MariaDB
mysql -u root -p

# In MariaDB prompt:
CREATE DATABASE pms_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

**Option B: Using phpMyAdmin**
1. Open phpMyAdmin (usually http://localhost/phpmyadmin)
2. Click "New" in the left sidebar
3. Database name: `pms_db`
4. Collation: `utf8mb4_unicode_ci`
5. Click "Create"

**Option C: Using HeidiSQL (Windows)**
1. Open HeidiSQL
2. Right-click connection → Create new → Database
3. Name: `pms_db`
4. Collation: `utf8mb4_unicode_ci`

**Option D: Using Sequel Pro / TablePlus (macOS)**
1. Connect to your database
2. Database → Add Database
3. Name: `pms_db`

### 8. Run Migrations & Seeders

```bash
# Run migrations
php artisan migrate

# Seed the database with demo data
php artisan db:seed
```

**Demo Users Created:**
- **Admin**: admin@pms.com / password
- **Manager**: manager@pms.com / password
- **Leasing**: leasing@pms.com / password
- **Accounting**: accounting@pms.com / password
- **Maintenance**: maintenance@pms.com / password

### 9. Create Storage Link

```bash
php artisan storage:link
```

### 10. Compile Frontend Assets

**Development (with hot reload):**
```bash
npm run dev
```

**Production build:**
```bash
npm run build
```

### 11. Start Development Server

**In a new terminal window:**
```bash
php artisan serve
```

The application will be available at: **http://localhost:8000**

---

## Access the Application

1. Open your browser and go to: **http://localhost:8000**
2. Click "Login" or go to: **http://localhost:8000/login**
3. Use demo credentials:
   - Email: `admin@pms.com`
   - Password: `password`

---

## Common Issues & Solutions

### Issue: "Access denied for user"
**Solution:**
- Check your MariaDB username and password in `.env`
- Make sure MariaDB is running: `sudo systemctl status mariadb` (Linux) or check services (Windows)

### Issue: "Database does not exist"
**Solution:**
- Create the database: `CREATE DATABASE pms_db;`
- Run migrations: `php artisan migrate`

### Issue: "Class not found" errors
**Solution:**
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### Issue: "npm run dev" errors
**Solution:**
```bash
rm -rf node_modules package-lock.json
npm install
npm run dev
```

### Issue: "Permission denied" on storage
**Solution:**
```bash
# Linux/macOS
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Windows (run as Administrator)
# No action needed usually
```

### Issue: Port 8000 already in use
**Solution:**
```bash
# Use a different port
php artisan serve --port=8080
```

### Issue: "Vite manifest not found"
**Solution:**
```bash
# Make sure to run in a separate terminal
npm run dev

# OR build assets
npm run build
```

---

## Testing the Installation

### Verify Database Connection
```bash
php artisan tinker

# In tinker prompt:
DB::connection()->getPdo();
# Should show PDO object

exit
```

### Check Routes
```bash
php artisan route:list
# Should show all routes
```

### Check Migrations
```bash
php artisan migrate:status
# All should show "Ran"
```

### Check Scheduled Tasks
```bash
php artisan schedule:list
# Should show 3 scheduled jobs
```

---

## Next Steps

### 1. Configure Task Scheduler (Optional - for automated jobs)

**Linux/macOS:**
```bash
crontab -e

# Add this line:
* * * * * cd /path/to/pms-laravel && php artisan schedule:run >> /dev/null 2>&1
```

**Windows:**
1. Open Task Scheduler
2. Create Basic Task
3. Trigger: Daily at startup
4. Action: Start a program
5. Program: `php`
6. Arguments: `artisan schedule:run`
7. Start in: `C:\path\to\pms-laravel`

### 2. Configure Legacy Data Migration (Optional)

If you want to migrate data from the old PHP4 system:

1. Edit `.env` and add legacy database credentials:
```env
LEGACY_DB_HOST=127.0.0.1
LEGACY_DB_PORT=3306
LEGACY_DB_DATABASE=pms_legacy
LEGACY_DB_USERNAME=root
LEGACY_DB_PASSWORD=your_password
```

2. Run migration:
```bash
# Dry run to test
php artisan pms:migrate-legacy-data --dry-run

# Actual migration
php artisan pms:migrate-legacy-data
```

See `docs/04-DATA-MIGRATION-GUIDE.md` for detailed migration instructions.

### 3. Configure Email (Optional)

Update `.env` for email notifications:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS="noreply@pms.com"
MAIL_FROM_NAME="Property Management System"
```

---

## Development Workflow

### Running the Application
```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Vite dev server (for hot reload)
npm run dev
```

### Making Changes
```bash
# After modifying code
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# After modifying database
php artisan migrate:fresh --seed  # WARNING: Deletes all data
```

### Creating New Modules
```bash
# Generate controller
php artisan make:controller YourController --resource

# Generate model
php artisan make:model YourModel -m

# Generate migration
php artisan make:migration create_your_table

# Generate policy
php artisan make:policy YourPolicy

# Generate request
php artisan make:request StoreYourRequest
```

---

## Production Deployment

When ready for production:

1. **Optimize Laravel:**
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

2. **Set Environment:**
```env
APP_ENV=production
APP_DEBUG=false
```

3. **Secure .env:**
- Never commit `.env` to version control
- Use strong passwords
- Enable SSL/HTTPS

4. **Set up proper web server:**
- Apache or Nginx
- Point document root to `public/` directory
- Configure proper permissions

5. **Enable Queue Worker:**
```bash
php artisan queue:work --daemon
```

6. **Set up regular backups:**
- Database backups
- File storage backups
- Configuration backups

---

## Support & Documentation

- **Architecture Documentation**: `docs/02-LARAVEL-11-ARCHITECTURE.md`
- **Business Rules**: `docs/03-BUSINESS-RULES.md`
- **Data Migration Guide**: `docs/04-DATA-MIGRATION-GUIDE.md`
- **Legacy System Analysis**: `docs/01-LEGACY-SYSTEM-ANALYSIS.md`

---

## Quick Reference Commands

```bash
# Clear all caches
php artisan optimize:clear

# List all routes
php artisan route:list

# List all commands
php artisan list

# Check migration status
php artisan migrate:status

# Rollback last migration
php artisan migrate:rollback

# Fresh install (WARNING: Deletes all data)
php artisan migrate:fresh --seed

# Run tinker (REPL)
php artisan tinker

# Generate IDE helper (optional)
composer require --dev barryvdh/laravel-ide-helper
php artisan ide-helper:generate
```

---

Enjoy your new Laravel 11 Property Management System! 🎉
