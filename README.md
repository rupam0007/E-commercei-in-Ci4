# ShopCI — E-Commerce Application

A full-featured e-commerce web application built with **CodeIgniter 4** and **Bootstrap 5**.

---

## Table of Contents

1. [Requirements](#requirements)
2. [Installation & Setup](#installation--setup)
3. [Configuration](#configuration)
4. [Database Setup](#database-setup)
5. [Running the App](#running-the-app)
6. [Creating an Admin Account](#creating-an-admin-account)
7. [Customer Guide](#customer-guide)
8. [Admin Guide](#admin-guide)
9. [URL Reference](#url-reference)
10. [Project Structure](#project-structure)

---

## Requirements

| Software | Version |
|----------|---------|
| PHP      | 8.1+    |
| MySQL    | 5.7+    |
| XAMPP / WAMP / Laragon | any |
| Composer | 2.x |

---

## Installation & Setup

### 1. Place the project

Copy the project folder into your web server's root:

```
C:\xampp\htdocs\E-commarceinCI
```

### 2. Install PHP dependencies

Open a terminal in the project folder and run:

```bash
composer install
```

### 3. Create the environment file

Copy the example env file and rename it:

```bash
copy env .env
```

---

## Configuration

Open `.env` and set the following values:

```ini
# App
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost/E-commarceinCI/public/'

# Database
database.default.hostname = localhost
database.default.database = your_database_name
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port     = 3306
```

> Create an empty MySQL database (e.g. `ecommerce_ci`) in phpMyAdmin before the next step.

---

## Database Setup

### Run Migrations

Creates all required tables (`users`, `categories`, `products`, `cart`, `orders`, `order_items`):

```bash
php spark migrate
```

### Seed Sample Data

Inserts the default admin account + sample categories and products:

```bash
php spark db:seed AdminSeeder
```

---

## Running the App

Start **Apache** and **MySQL** from XAMPP Control Panel, then visit:

```
http://localhost/E-commarceinCI/public/
```

---

## Creating an Admin Account

### Option A — Use the seeder (recommended)

```bash
php spark db:seed AdminSeeder
```

Default admin credentials:

| Field    | Value              |
|----------|--------------------|
| Email    | admin@shopci.com   |
| Password | admin123           |

### Option B — Via phpMyAdmin

1. Open `http://localhost/phpmyadmin`
2. Open your database → `users` table
3. Find your user row → click **Edit**
4. Change `role` from `customer` to `admin`
5. Click **Go**

### Option C — Via terminal

```bash
php spark db:query "UPDATE users SET role = 'admin' WHERE email = 'your@email.com';"
```

---

## Customer Guide

### Register & Login

1. Visit `/register` — fill in name, email, password
2. Visit `/login` — sign in with your credentials
3. Visit `/logout` to end your session

### Browsing Products

| Page | URL |
|------|-----|
| Home (featured) | `/` |
| All products     | `/shop` |
| Filter by category | `/shop?category=1` |
| Search products  | `/shop?q=keyword` |
| Product detail   | `/shop/{product-slug}` |

### Shopping Cart

| Action | How |
|--------|-----|
| Add to cart | Click **Add to Cart** on any product page |
| View cart   | Visit `/cart` |
| Update quantity | Change the number in the cart and click **Update** |
| Remove item | Click **Remove** next to any cart item |

### Checkout & Orders

1. Go to `/cart` and click **Proceed to Checkout**
2. Fill in shipping name, address, and phone number
3. Add optional order notes
4. Click **Place Order**
5. View all your orders at `/orders`
6. View a specific order at `/orders/{id}`

### Profile

| Action | URL |
|--------|-----|
| View profile          | `/profile` |
| Edit name/email/phone | `/profile/edit` |
| Change password       | Form on `/profile/edit` page |

---

## Admin Guide

Access the admin panel at `/admin/dashboard` (requires admin role).

---

### Dashboard — `/admin/dashboard`

Shows a summary of:
- Total products, orders, users
- Number of pending orders
- Recent orders list

---

### Products — `/admin/products`

| Action | URL |
|--------|-----|
| List all products  | `/admin/products` |
| Create new product | `/admin/products/create` |
| Edit product       | `/admin/products/edit/{id}` |
| Delete product     | `/admin/products/delete/{id}` |

**Fields when creating/editing a product:**

| Field | Details |
|-------|---------|
| Name | Required |
| Category | Select from existing categories |
| Price | Decimal (e.g. `499.99`) |
| Stock | Integer — number of units available |
| Description | Optional |
| Image | JPG/PNG upload — stored in `public/uploads/products/` |
| Active | Check to make product visible in the shop |

---

### Categories — `/admin/categories`

| Action | How |
|--------|-----|
| Add category    | Type name in the form and click **Add** |
| Delete category | Click **Delete** next to the category |

---

### Orders — `/admin/orders`

| Action | How |
|--------|-----|
| List all orders     | `/admin/orders` |
| Update order status | Select status from the dropdown and click **Update** |

**Available order statuses:**

| Status       | Meaning |
|--------------|---------|
| `pending`    | Order placed, not yet processed |
| `processing` | Being prepared |
| `shipped`    | Dispatched to customer |
| `delivered`  | Successfully delivered |
| `cancelled`  | Order cancelled |

---

### Customers — `/admin/customers`

Shows all registered customers with:
- Name and email
- Number of orders placed
- Total amount spent
- Account creation date

---

### Reports — `/admin/reports`

| Section | Details |
|---------|---------|
| Summary cards | Total revenue, orders, products, customers |
| Monthly revenue | Last 6 months — order count and revenue per month |
| Top 5 products | Ranked by units sold |
| Low stock alert | Products with ≤ 10 units, with direct edit links |

---

## URL Reference

### Public Routes

| Method | URL | Description |
|--------|-----|-------------|
| GET | `/` | Home page |
| GET | `/shop` | All products |
| GET | `/shop/{slug}` | Product detail |
| GET | `/register` | Registration form |
| POST | `/register` | Submit registration |
| GET | `/login` | Login form |
| POST | `/login` | Submit login |
| GET | `/logout` | Log out |

### Customer Routes (login required)

| Method | URL | Description |
|--------|-----|-------------|
| GET | `/cart` | View cart |
| POST | `/cart/add` | Add item to cart |
| POST | `/cart/update` | Update item quantity |
| GET | `/cart/remove/{id}` | Remove item |
| GET | `/checkout` | Checkout form |
| POST | `/checkout` | Place order |
| GET | `/orders` | Order history |
| GET | `/orders/{id}` | Order detail |
| GET | `/profile` | View profile |
| GET | `/profile/edit` | Edit profile form |
| POST | `/profile/edit` | Update profile |
| POST | `/profile/password` | Change password |

### Admin Routes (admin role required)

| Method | URL | Description |
|--------|-----|-------------|
| GET | `/admin/dashboard` | Dashboard |
| GET | `/admin/products` | Product list |
| GET | `/admin/products/create` | New product form |
| POST | `/admin/products/create` | Save new product |
| GET | `/admin/products/edit/{id}` | Edit product form |
| POST | `/admin/products/update/{id}` | Save edits |
| GET | `/admin/products/delete/{id}` | Delete product |
| GET | `/admin/categories` | Category list |
| POST | `/admin/categories` | Add category |
| GET | `/admin/categories/delete/{id}` | Delete category |
| GET | `/admin/orders` | Order list |
| POST | `/admin/orders/status/{id}` | Update order status |
| GET | `/admin/customers` | Customer list |
| GET | `/admin/reports` | Analytics & reports |

---

## Project Structure

```
app/
├── Config/
│   ├── Routes.php          # All application routes
│   ├── Filters.php         # Auth & admin filter registration
│   └── Database.php        # DB connection config
├── Controllers/
│   ├── AuthController.php  # Register, login, logout
│   ├── ShopController.php  # Home, product listing, product detail
│   ├── CartController.php  # Cart CRUD
│   ├── OrderController.php # Checkout, order history
│   ├── UserController.php  # Profile management
│   └── AdminController.php # Full admin panel
├── Models/
│   ├── UserModel.php
│   ├── ProductModel.php
│   ├── CategoryModel.php
│   ├── CartModel.php
│   ├── OrderModel.php
│   └── OrderItemModel.php
├── Filters/
│   ├── AuthFilter.php      # Redirects guests from protected pages
│   └── AdminFilter.php     # Redirects non-admins from /admin/*
├── Views/
│   ├── auth/               # Login & register pages
│   ├── shop/               # Home, listing, product detail
│   ├── cart/               # Cart page
│   ├── orders/             # Checkout & order detail
│   ├── admin/              # Full admin panel views
│   └── layouts/            # Shared header/footer
├── Database/
│   ├── Migrations/         # Table schema definitions
│   └── Seeds/
│       └── AdminSeeder.php # Default admin + sample data
public/
└── uploads/
    └── products/           # Uploaded product images
```

---

## Common Spark Commands

```bash
# Run all migrations
php spark migrate

# Roll back last migration
php spark migrate:rollback

# Seed the database
php spark db:seed AdminSeeder

# Start built-in dev server (alternative to XAMPP)
php spark serve

# List all routes
php spark routes
```
