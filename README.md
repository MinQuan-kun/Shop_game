
# 🎮 **Mirai Store**

<p align="center">
  <a href="/" target="_blank">
    <img src="public/img/Logo.png" width="200" alt="Mirai Store Logo">
  </a>
</p>

[![PHP](https://img.shields.io/badge/PHP-8.2-blue?logo=php\&logoColor=white)]()
[![Laravel](https://img.shields.io/badge/Laravel-11-red?logo=laravel\&logoColor=white)]()
[![MongoDB](https://img.shields.io/badge/MongoDB-7.0-darkgreen?logo=mongodb\&logoColor=white)]()
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-4-teal?logo=tailwindcss\&logoColor=white)]()
[![Cloudinary](https://img.shields.io/badge/Cloudinary-Images-blue?logo=cloudinary\&logoColor=white)]()

---

## 📌 **Giới thiệu**
**Mirai Store** là đồ án môn PHP, hệ thống được xây dựng bằng **Laravel + MongoDB** với khả năng mở rộng mạnh mẽ và tốc độ truy vấn nhanh.

---

## ✨ **Tính năng nổi bật**
### 🔐 **Hệ thống xác thực**

* Laravel Auth/Breeze.
* Reset password, xác thực email (tuỳ chọn).
* Bảo mật cao theo chuẩn Laravel.

### ☁️ **Quản lý hình ảnh tự động**

* Cloudinary upload.
* Tự động resize, crop, tối ưu.
* Lưu link ảnh để render cực nhanh.

### 🛒 **Quản lý Shop/Game Store**

* CRUD game trong admin.
* Mỗi game có nhiều hình ảnh.
* Trang chi tiết game đẹp mắt, đúng chủ đề anime.

### ⚡ **Hiệu năng vượt trội**

* MongoDB đọc/write cực nhanh.
* Vite build asset tốc độ cao.
* Alpine.js tương tác UI mượt mà.

### 📱 **Responsive 100%**

* Tối ưu cho mọi kích thước màn hình.

---

## ⚙️ **Công nghệ sử dụng**

| Công nghệ           | Vai trò                             |
| ------------------- | ----------------------------------- |
| **Laravel 11**      | Backend + MVC + Authentication      |
| **MongoDB**         | Lưu sản phẩm, tài khoản, đơn hàng   |
| **Laravel MongoDB** | Driver mở rộng (jenssegers/mongodb) |
| **TailwindCSS 4**   | UI nhanh – gọn – đẹp                |
| **Vite**            | Build CSS/JS tốc độ cao             |
| **Cloudinary API**  | Lưu trữ & tối ưu hình ảnh           |
| **Alpine.js**       | UI interaction không cần jQuery     |

---

# 🚀 **Cách chạy dự án (Không dùng Docker)**

> **Yêu cầu:**
>
> * PHP ≥ 8.1
> * Composer
> * MongoDB (local hoặc Atlas)
> * Node.js ≥ 18

---

## 1️⃣ Clone code

```bash
git clone <repo-url>
cd mirai-store
```

---

## 2️⃣ Cài Laravel dependencies

```bash
composer install
```

---

## 3️⃣ Cài frontend dependencies

```bash
npm install
```

---

## 4️⃣ Tạo file `.env`

```bash
cp .env.example .env
```

Chỉnh lại phần MongoDB:

```env
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=mirai_store
DB_USERNAME=
DB_PASSWORD=
```

Nếu bạn dùng MongoDB Atlas:

```env
DB_URI=mongodb+srv://username:password@cluster.mongodb.net/mirai_store
```

---

## 5️⃣ Cài driver MongoDB cho Laravel

```bash
composer require jenssegers/mongodb
```

---

## 6️⃣ Generate key

```bash
php artisan key:generate
```

---

## 7️⃣ Chạy migration (nếu có)

> 🚨 Lưu ý: MongoDB không dùng schema như MySQL
> → Migration chỉ tạo dữ liệu mẫu hoặc collection tùy bạn.

```bash
php artisan migrate
```

---

## 8️⃣ Chạy Laravel server

```bash
php artisan serve
```

👉 Truy cập: **[http://localhost:8000](http://localhost:8000)**

---

## 9️⃣ Chạy Vite

```bash
npm run dev
```

---

# 📂 **Cấu trúc thư mục**

```
mirai-store/
│
├── app/                   # Controllers, Models (MongoDB Model)
│   ├── Models/            # Model sử dụng Jenssegers\Mongodb
│
├── public/                # Logo, ảnh tĩnh
├── resources/
│   ├── views/             # Blade giao diện Miku UI
│   ├── css/               # TailwindCSS
│   └── js/                # Alpine.js + app.js
│
├── routes/
│   ├── web.php            # Route giao diện
│   └── api.php            # Route API
│
├── database/              # Seeder, migration tùy chỉnh
└── README.md
```

---

# 🧰 **Lệnh hữu ích**

| Hành động                   | Lệnh                         |
| --------------------------- | ---------------------------- |
| Chạy Laravel server         | `php artisan serve`          |
| Chạy Vite frontend          | `npm run dev`                |
| Build assets cho production | `npm run build`              |
| Clear cache backend         | `php artisan optimize:clear` |
| Seed dữ liệu mẫu            | `php artisan db:seed`        |

---

# ❤️ **Đóng góp**
- Sẽ thêm chatbot
---
