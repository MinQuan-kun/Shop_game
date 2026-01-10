# 🎮 **Mirai Store - Website Bán Game Trực Tuyến**

<p align="center">
  <a href="/" target="_blank">
    <img src="public/img/Logo.png" width="200" alt="Mirai Store Logo">
  </a>
</p>

<p align="center">
    <a href="https://laravel.com"><img src="https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel"></a>
    <a href="https://www.php.net"><img src="https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP"></a>
    <a href="https://www.mongodb.com"><img src="https://img.shields.io/badge/MongoDB-47A248?style=for-the-badge&logo=mongodb&logoColor=white" alt="MongoDB"></a>
    <a href="https://tailwindcss.com"><img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="TailwindCSS"></a>
    <a href="https://www.docker.com"><img src="https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker"></a>
    <a href="https://cloudinary.com"><img src="https://img.shields.io/badge/Cloudinary-3448C5?style=for-the-badge&logo=cloudinary&logoColor=white" alt="Cloudinary"></a>
</p>

<p align="center">
    <strong>🌐 Live Demo: <a href="https://mirai-store-pzz3.onrender.com" target="_blank">https://mirai-store.onrender.com</a></strong>
</p>

---

## 📌 **Giới thiệu**
**Mirai Store** là nền tảng thương mại điện tử chuyên cung cấp các sản phẩm game bản quyền. Hệ thống được xây dựng trên nền tảng **Laravel 11** kết hợp với cơ sở dữ liệu NoSQL **MongoDB**, mang lại hiệu năng cao và khả năng mở rộng linh hoạt. Dự án tích hợp nhiều công nghệ hiện đại như AI Chatbot, Gợi ý game thông minh và Cổng thanh toán điện tử.

---

## ✨ **Tính năng nổi bật**

### 🤖 **Công nghệ & AI**
* **Hệ thống Gợi ý Game (Recommendation System):** Tự động đề xuất game phù hợp dựa trên sở thích và hành vi người dùng.
* **AI Chatbot:** Trợ lý ảo hỗ trợ khách hàng giải đáp thắc mắc và hướng dẫn mua hàng 24/7.
* **Gacha (Vòng quay may mắn):** Tính năng giải trí giúp người dùng ngẫu nhiên khám phá các tựa game thú vị.

### 💳 **Thanh toán & Ví điện tử**
* **Đa dạng cổng thanh toán:** Tích hợp **MoMo (QR Code/ATM)** và **PayPal**.
* **Ví nội bộ (Wallet):** Người dùng có thể nạp tiền vào ví để mua sắm nhanh chóng.
* **Xử lý giao dịch an toàn:** Hệ thống xử lý IPN/Callback chặt chẽ, đảm bảo tính toàn vẹn của đơn hàng.

### 🛒 **Trải nghiệm mua sắm**
* **Quản lý Giỏ hàng & Wishlist:** Thêm/xóa sản phẩm, lưu game yêu thích (sử dụng AJAX mượt mà).
* **Mã giảm giá (Discount Code):** Áp dụng coupon giảm giá theo phần trăm hoặc số tiền cố định.
* **Tìm kiếm & Lọc:** Tìm kiếm thời gian thực (Autocomplete), lọc theo giá, thể loại, nhà phát hành.

### 🔐 **Quản trị & Hệ thống**
* **Phân quyền (Auth):** Đăng ký, Đăng nhập, Quên mật khẩu, Xác thực Email.
* **Admin Dashboard:** Thống kê doanh thu, quản lý Người dùng, Game, Danh mục, Đơn hàng.
* **Cloudinary Integration:** Tự động upload và tối ưu hóa hình ảnh game.

---

## ⚙️ **Công nghệ sử dụng**

| Lĩnh vực | Công nghệ | Chi tiết |
| :--- | :--- | :--- |
| **Backend** | Laravel 11 | Framework PHP hiện đại, mạnh mẽ. |
| **Database** | MongoDB | NoSQL Database, xử lý dữ liệu lớn linh hoạt. |
| **Driver** | mongodb/laravel-mongodb | Driver chính thức kết nối Laravel & MongoDB. |
| **Frontend** | Blade, TailwindCSS | Giao diện Responsive, tối ưu UX/UI. |
| **Scripting** | Alpine.js, Vanilla JS | Xử lý tương tác phía Client nhẹ nhàng. |
| **Payments** | MoMo API, PayPal SDK | Tích hợp cổng thanh toán trực tuyến. |
| **Storage** | Cloudinary | Lưu trữ và CDN cho hình ảnh. |
| **DevOps** | Docker | Container hóa môi trường phát triển & Deploy. |

---

## 🚀 **Cài đặt & Chạy dự án**

### Yêu cầu hệ thống
* PHP ≥ 8.2
* Composer
* MongoDB (Cài đặt Local hoặc dùng MongoDB Atlas)
* Node.js ≥ 18
* Docker (Tùy chọn)

### Các bước cài đặt

#### 1️⃣ Clone source code
```bash
git clone <repo-url>
cd shop_game

```

#### 2️⃣ Cài đặt thư viện Backend & Frontend

```bash
composer install
npm install

```

#### 3️⃣ Cấu hình môi trường (.env)

Copy file `.env.example` thành `.env` và cấu hình các thông số:

```bash
cp .env.example .env

```

**Cấu hình MongoDB:**

```env
DB_CONNECTION=mongodb
DB_URI=mongodb+srv://<username>:<password>@cluster.mongodb.net/mirai_store?retryWrites=true&w=majority
DB_DATABASE=mirai_store

```

**Cấu hình Cloudinary (Ảnh):**

```env
CLOUDINARY_URL=cloudinary://API_KEY:API_SECRET@CLOUD_NAME

```

**Cấu hình Mail (SMTP Gmail):**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password

```

#### 4️⃣ Tạo Key & Link Storage

```bash
php artisan key:generate
php artisan storage:link

```

#### 5️⃣ Seed dữ liệu mẫu (Quan trọng)

Tạo tài khoản Admin, Danh mục, Game mẫu:

```bash
php artisan db:seed

```

*Tài khoản Admin mặc định: `admin@gmail.com` / `password*`

#### 6️⃣ Khởi chạy

Chạy 2 terminal riêng biệt:

**Terminal 1 (Backend):**

```bash
php artisan serve

```

**Terminal 2 (Frontend Build):**

```bash
npm run dev

```

👉 Truy cập website tại: **[http://localhost:8000](https://www.google.com/search?q=http://localhost:8000)**

---

## 🐳 **Chạy bằng Docker (Production/Dev)**

Dự án đã được đóng gói sẵn với Docker để dễ dàng triển khai.

### Chạy nhanh với Docker Compose

```bash
docker-compose up -d --build

```

Truy cập tại: `http://localhost:8000`

### Build Image thủ công

```bash
# Build image
docker build -t mirai-store .

# Run container
docker run -p 8000:8000 mirai-store

```

---

## 👥 **Thành viên thực hiện**

Đồ án môn học **Lập trình PHP** - GVHD: **ThS. Nguyễn Quốc Trung**

1. **Nguyễn Hữu Minh Quân** (49.01.104.120)
2. **Nguyễn Thái Bình** (49.01.104.011)
3. **Trương Vĩnh Phát** (49.01.104.108)
4. **Trương Trường Giang** (49.01.104.036)

---

<p align="center">Made with ❤️ by Mirai Team</p>
