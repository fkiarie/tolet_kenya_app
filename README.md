

```markdown
# 🏠 Tolet Kenya - Property Management System

**Tolet Kenya** is a Laravel 12-based web application designed to streamline property management for real estate agencies, landlords, and building managers. It offers powerful features for managing landlords, buildings, units, tenants, leases, rent payments, and commission tracking — all within a modern, mobile-friendly interface.

---

## 🚀 Features

### 🧑‍💼 Landlords
- Add & manage landlords with photo, business name, ID, email, and phone
- Each landlord can own multiple buildings

### 🏢 Buildings
- Assign buildings to landlords
- Add unit types (e.g., bedsitter, 1-bedroom) via a JSON interface
- Automatically generate units based on unit types

### 🏠 Units
- Linked to buildings and tenants
- Tracks rent, deposit, lease dates, and occupancy status
- Units can be marked vacant, occupied, or under maintenance
- Prevent deletion of occupied units

### 👥 Tenants
- Multi-step onboarding (3 steps: basic info → emergency contact → photo/unit assignment)
- Each tenant can be assigned to multiple units
- Upload photo and assign lease period
- Emergency contact storage
- Auto-link units during onboarding

### 💵 Payments
- Admin records monthly payments
- Commission (e.g., 10–20%) deducted automatically
- Auto-calculates landlord amount and commission
- Tracks receipt reference, payment method, notes
- Payment summary for current month on dashboard
- Export PDF and filter by date, tenant, or unit

### 📊 Dashboard
- Key stats: landlords, buildings, units, tenants
- Unit summary: vacant vs occupied
- Payments summary: total paid, unpaid units, receipts issued
- Total commission earned (monthly)
- Recent activity (latest tenants)

### 📦 Utilities
- File uploads (tenant photos)
- Dynamic unit dropdowns (based on selected tenant)
- Blade components for clean and reusable forms
- Export CSV (tenants, landlords, buildings)
- PDF export (payments)
- TailwindCSS design with glass UI

---

## 🛠 Tech Stack

- **Framework:** Laravel 12
- **Frontend:** Blade, Tailwind CSS, Vite
- **JS:** Vanilla JS
- **Auth:** Laravel Breeze (custom styled)
- **Database:** MySQL
- **PDF Export:** [barryvdh/laravel-dompdf](https://github.com/barryvdh/laravel-dompdf)

---

## 📁 Folder Structure Highlights

```

app/Models            → Eloquent models (Landlord, Building, Tenant, Unit, Payment)
app/Http/Controllers  → Controller logic
resources/views       → Blade views (CRUD + onboarding)
routes/web.php        → Route definitions
database/migrations   → Schema migrations
storage/app/public    → Uploaded photos (with symlink)

````

---

## 🔧 Installation & Setup

```bash
git clone https://github.com/yourname/tolet-kenya.git
cd tolet-kenya

composer install
npm install && npm run dev

cp .env.example .env
php artisan key:generate

php artisan migrate --seed
php artisan storage:link
php artisan serve
````

---

## ✅ Requirements

* PHP 8.1+
* MySQL 5.7+/MariaDB
* Node.js & npm
* Laravel CLI

---

## 📌 Roadmap

* Role-based access (Admin, Agent, Landlord)
* SMS/Email reminders (rent due, lease expiring)
* Maintenance request tracking
* Online tenant applications
* Rent defaulter flagging

---

## 📄 License

This project is open-source under the [MIT License](LICENSE).

---

## 👨‍💻 Author

Made by Francis Kiarie

```
