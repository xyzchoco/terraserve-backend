# TerraServe Backend

Backend API Laravel 12.

---

## 🔧 Requirements
- PHP >= 8.3
- Composer
- MySQL / MariaDB
- Node.js + npm
- Laravel CLI
- (Opsional) Laravel Sail / Docker

---

## ⚙️ Cara Menjalankan Proyek (Local Setup)

```bash
# 1. Clone repo
git clone https://github.com/xyzchoco/terraserve-backend.git
cd terraserve-backend

# 2. Install dependensi PHP
composer install

# 3. Install dependensi front-end (jika ada)
npm install
npm run build   # atau npm run dev saat development

# 4. Salin file .env dan generate APP_KEY
cp .env.example .env
php artisan key:generate

# 5. Atur konfigurasi database di file .env
# Misal:
# DB_DATABASE=terraserve_db
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Jalankan migration
php artisan migrate

# 7. Jalankan server
php artisan serve

#8. 
Akses proyek di: http://localhost:8000
