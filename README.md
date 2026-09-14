# 🎬 Galaxy Cinema - Cinema Booking System

Hệ thống đặt vé xem phim trực tuyến Galaxy Cinema hoàn chỉnh, bao gồm Backend REST API PHP (MVC, JWT, PDO) và Frontend React (Vite, TypeScript, Tailwind CSS, Shadcn UI).

---

## 📖 Hướng Dẫn Cài Đặt & Khởi Chạy

Chi tiết từng bước cấu hình Database, chạy Backend, Frontend và Docker được trình bày đầy đủ tại:

👉 **[Xem Hướng Dẫn Chạy Dự Án Chi Tiết (HUONG_DAN_CHAY_DU_AN.md)](./HUONG_DAN_CHAY_DU_AN.md)**

---

## ⚡ Khởi Chạy Nhanh (Quick Start)

### 1. Cơ sở dữ liệu (MySQL)
- Import schema: `Cinema-Booking-System-main/backend/database/schema.sql`
- Import dữ liệu mẫu: `Cinema-Booking-System-main/backend/database/seed_data.sql`

### 2. Backend (PHP)
```powershell
cd Cinema-Booking-System-main/backend
# Chạy với PHP CLI hoặc PHP XAMPP:
php -S localhost:8000
```

### 3. Frontend (React + Vite)
```powershell
cd Cinema-Booking-System-main/source-code/galaxy-cinema-hub-main
npm install
npm run dev
```
Truy cập ứng dụng tại: `http://localhost:5173`

---

## 🔑 Tài Khoản Thử Nghiệm Mặc Định

Tất cả tài khoản test có mật khẩu chung là: `password`

- **Admin**: `admin@galaxy.vn`
- **Manager**: `manager@galaxy.vn`
- **Staff**: `staff@galaxy.vn`
- **Member**: `nguyenvana@gmail.com`

---

## 🔄 CI/CD Pipeline
Dự án được tích hợp sẵn pipeline tự động hóa kiểm thử và build thông qua **GitHub Actions** tại [`.github/workflows/ci.yml`](./.github/workflows/ci.yml).