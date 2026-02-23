# RestoFlow - Backend API

RestoFlow is a Restaurant Order Management System built with Laravel 12.
This backend provides RESTful APIs for managing tables, foods, orders, and role-based authentication (Pelayan & Kasir).

---

## 🚀 Tech Stack

- Laravel 12
- MySQL
- Laravel Sanctum (API Authentication)
- Resource API
- Seeder & Migration

---

## 📌 Features

### Authentication
- Login Pelayan
- Login Kasir
- Token-based authentication (Bearer Token)

### Tables
- List all tables
- Table status tracking

### Foods
- List foods
- Create, update, delete foods
- Availability toggle

### Orders
- Create order
- Add order items
- View order detail
- Filter by status
- Close order
- Generate receipt (PDF)

---

## 🔐 Role Permissions

| Feature | Pelayan | Kasir |
|----------|----------|--------|
| Create Order | ✅ | ❌ |
| Add Items | ✅ | ❌ |
| View Orders | ✅ | ✅ |
| Close Order | ❌ | ✅ |
| Manage Foods | ❌ | ✅ |

---

## ⚙️ Installation

```bash
git clone https://github.com/Hammam-GNF/RestoFlow.git
cd RestoFlow
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

---

## 📄 API Base URL

```
http://localhost:8000/api
```

---

## 📦 Seeder

Seeder includes:
- Sample Foods
- Sample Tables
- Sample Users (Pelayan & Kasir)

---

## 🧪 Example Login Response

```json
{
  "access_token": "...",
  "token_type": "Bearer",
  "user": {
    "id": 1,
    "name": "Kasir",
    "role": "kasir"
  }
}
```

---

## 📄 License

This project is for technical assessment and portfolio purposes.