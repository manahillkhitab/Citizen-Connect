# 🏛️ Citizen Connect – عوام کی آواز

**Citizen Connect** is a professional Government-to-Citizen (G2C) portal designed to bridge the gap between the public and government departments. It empowers citizens to report issues, track resolutions, and participate in community improvement with transparency and efficiency.

---

## 🚀 Key Features

- **📍 Geo-Tagging:** Accurately pin-point issue locations using integrated mapping.
- **📸 Evidence Upload:** Attach image evidence directly to complaints for faster verification.
- **🔔 Real-time Tracking:** Stay updated with SMS and Email notifications on complaint status changes.
- **📊 Admin & Departmental Dashboards:** Dedicated interfaces for officials to manage, assign, and resolve grievances.
- **🌍 Multilingual Support:** Seamlessly supports both English and Urdu interface elements.
- **🔒 Secure & Private:** Industry-standard encryption and optional anonymous reporting.

---

## 🛠️ Tech Stack

- **Backend:** [Laravel 12](https://laravel.com/) (PHP ^8.2)
- **Frontend Interactivity:** [Alpine.js](https://alpinejs.dev/)
- **Templating Engine:** [Blade](https://laravel.com/docs/blade)
- **Styling:** [Tailwind CSS](https://tailwindcss.com/)
- **Build Tool:** [Vite](https://vitejs.dev/)
- **Database:** MySQL
- **Authentication:** Laravel Breeze

---

## 📦 Installation Guide

Follow these steps to set up the project locally:

### 1. Prerequisites
Ensure you have **PHP 8.2+**, **Composer**, and **Node.js** installed on your system.

### 2. Clone the Repository
```bash
git clone https://github.com/manahillkhitab/citizen-connect.git
cd citizen-connect
```

### 3. Install Dependencies
```bash
composer install
npm install
```

### 4. Environment Configuration
Create your environment file:
```bash
cp .env.example .env
```
*Configure your database settings in the `.env` file.*

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Run Migrations
```bash
php artisan migrate
```

### 7. Start the Development Server
Run these in separate terminals:
```bash
# Terminal 1: Backend
php artisan serve

# Terminal 2: Frontend Assets
npm run dev
```

---

## 👤 Developed By

**Manahill Khitab**  
*Project created for Semester 5 – Empowering citizens through technology.*

---

## 📄 License
This project is open-sourced under the [MIT license](LICENSE).
