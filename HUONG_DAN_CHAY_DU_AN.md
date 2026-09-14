# 🎬 HƯỚNG DẪN CÀI ĐẶT VÀ CHẠY DỰ ÁN CINEMA BOOKING SYSTEM

Tài liệu này hướng dẫn chi tiết từng bước cách thiết lập cơ sở dữ liệu, khởi chạy Backend (PHP), Frontend (React + Vite) và chạy bằng Docker cho hệ thống đặt vé xem phim Galaxy Cinema.

---

## 📌 1. Yêu Cầu Môi Trường (Prerequisites)

Trước khi bắt đầu, hãy đảm bảo máy tính của bạn đã cài đặt:
- **Node.js**: Phiên bản 18 trở lên (khuyên dùng Node 20 LTS) & npm.
- **PHP**: Phiên bản 8.0 trở lên (khuyên dùng PHP 8.2), có bật các extension: `pdo`, `pdo_mysql`, `mbstring`, `json`, `curl`. *(Nếu dùng XAMPP thì đã có sẵn)*.
- **MySQL / MariaDB**: Phiên bản 8.0 hoặc MariaDB tương đương qua XAMPP.
- **(Tùy chọn) Docker & Docker Desktop**: Nếu bạn muốn chạy toàn bộ môi trường qua container.

---

## 🚀 2. Hướng Dẫn Chạy Bằng XAMPP & Local Server (Khuyên Dùng)

### Bước 2.1: Khởi động XAMPP
1. Mở **XAMPP Control Panel**.
2. Bấm **Start** dịch vụ **MySQL** (và **Apache** nếu bạn muốn dùng phpMyAdmin).

---

### Bước 2.2: Khởi tạo Cơ sở dữ liệu (Database)

1. Mở trình duyệt truy cập phpMyAdmin: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Tạo một database mới:
   - Tên database: `galaxy_cinema`
   - Bảng mã (Collation): `utf8mb4_unicode_ci`
3. Nhập (Import) lần lượt 2 file SQL theo đúng thứ tự:
   - **File 1 (Cấu trúc bảng)**:
     `Cinema-Booking-System-main/backend/database/schema.sql`
   - **File 2 (Dữ liệu mẫu - phim, lịch chiếu, tài khoản test)**:
     `Cinema-Booking-System-main/backend/database/seed_data.sql`

> 💡 **Mẹo chạy nhanh bằng dòng lệnh (Command Line)**:
> ```powershell
> mysql -u root -p galaxy_cinema < "Cinema-Booking-System-main/backend/database/schema.sql"
> mysql -u root -p galaxy_cinema < "Cinema-Booking-System-main/backend/database/seed_data.sql"
> ```

---

### Bước 2.3: Cấu hình và Khởi động Backend (PHP)

1. **Tạo file cấu hình `.env` cho Backend**:
   - Di chuyển vào thư mục backend: `Cinema-Booking-System-main/backend/`
   - Tạo file `.env` (hoặc sao chép từ file mẫu `.env.example`):
   ```ini
   # Database Configuration (XAMPP mặc định user là root, password để trống)
   DB_HOST=localhost
   DB_NAME=galaxy_cinema
   DB_USERNAME=root
   DB_PASSWORD=

   # JWT Configuration
   JWT_SECRET=galaxy_cinema_secret_key_2026_change_this_in_production
   JWT_EXPIRATION=86400

   # SMTP Email (Để test không cần email thật, log sẽ ghi mã vào terminal)
   SMTP_ENABLED=false

   # Application Settings
   APP_NAME=Galaxy Cinema
   APP_VERSION=1.0.0
   TIMEZONE=Asia/Ho_Chi_Minh
   ```

2. **Khởi động Backend Server**:
   Mở terminal (PowerShell) và chạy lệnh:
   ```powershell
   cd "Cinema-Booking-System-main/backend"
   
   # Nếu máy đã cài PHP toàn cục:
   php -S localhost:8000

   # Hoặc nếu dùng trực tiếp PHP của XAMPP:
   & "D:\MCRo VSCODE\PHPmyadmin\XAMPP\php\php.exe" -S localhost:8000
   ```
   Backend sẽ lắng nghe tại: `http://localhost:8000`  
   Kiểm tra trạng thái server bằng cách mở: [http://localhost:8000/api/health](http://localhost:8000/api/health) (trả về `{"success":true,...}`)

---

### Bước 2.4: Cấu hình và Khởi động Frontend (React + Vite)

Mở một cửa sổ Terminal mới:

1. **Di chuyển vào thư mục Frontend**:
   ```powershell
   cd "Cinema-Booking-System-main/source-code/galaxy-cinema-hub-main"
   ```

2. **Cài đặt các gói thư viện dependencies**:
   ```powershell
   npm install
   ```

3. **Kiểm tra file cấu hình `.env` của Frontend**:
   File `.env` đã được cấu hình trỏ đến Backend:
   ```ini
   # Backend API URL
   VITE_API_URL=http://localhost:8000

   # Map Configuration (Dùng cho bản đồ vị trí cụm rạp)
   VITE_MAPTILER_KEY=KVeN2HZJbhgfyv2ekxLj
   VITE_ORS_API_KEY=eyJvcmciOiI1YjNjZTM1OTc4NTExMTAwMDFjZjYyNDgiLCJpZCI6IjkxZTJkMDY4NjI0ODQ1NjZiNTdkNTU5ZmQ0OGRlMWY2IiwiaCI6Im11cm11cjY0In0=
   ```

4. **Khởi động máy chủ phát triển Frontend**:
   ```powershell
   npm run dev
   ```

5. **Truy cập ứng dụng**:
   Mở trình duyệt truy cập: [http://localhost:5173](http://localhost:5173)

---

### Bước 2.5: Khởi động Python AI Service (Dành cho Chatbox AI)
Khi làm việc với tính năng trợ lý ảo Chatbox (DEV 3), mở một terminal mới và chạy:
```powershell
cd "Cinema-Booking-System-main/ai-service"

# 1. Tạo môi trường ảo (lần đầu tiên)
python -m venv venv
.\venv\Scripts\Activate.ps1

# 2. Cài đặt các thư viện Python miễn phí
pip install -r requirements.txt

# 3. Khởi động FastAPI server tại cổng 8001
uvicorn main:app --reload --port 8001
```
- API Docs tự động (Swagger UI): [http://localhost:8001/docs](http://localhost:8001/docs)

---

## 🐳 3. Hướng Dẫn Chạy Bằng Docker Compose (Cách 2)

Nếu bạn đã cài đặt **Docker Desktop**, bạn có thể chạy toàn bộ môi trường (MySQL + Backend PHP + Database Seeds) chỉ bằng 1 lệnh:

```powershell
cd "Cinema-Booking-System-main"
docker compose -f docker.yml up -d
```

- **MySQL Database**: Tự động import schema và dữ liệu mẫu, lắng nghe tại cổng `3306`.
- **Backend PHP**: Lắng nghe tại [http://localhost:8000](http://localhost:8000).
- Sau đó bạn chỉ cần mở thư mục `Cinema-Booking-System-main/source-code/galaxy-cinema-hub-main` và chạy `npm run dev` để vào web.
- Dừng các container khi không dùng:
  ```powershell
  docker compose -f docker.yml down
  ```

---

## 🔑 4. Danh Sách Tài Khoản Thử Nghiệm (Test Accounts)

Dữ liệu mẫu (`seed_data.sql`) cung cấp sẵn các tài khoản với từng vai trò khác nhau để test:

| Vai trò (Role) | Email Đăng Nhập | Mật Khẩu (Password) | Quyền Hạn / Trang Truy Cập |
| :--- | :--- | :--- | :--- |
| **Admin** | `admin@galaxy.vn` | `password` | Quản trị toàn hệ thống (`/admin`) |
| **Manager** | `manager@galaxy.vn` | `password` | Quản lý rạp và lịch chiếu (`/manager`) |
| **Staff** | `staff@galaxy.vn` | `password` | Nhân viên soát vé & POS (`/staff/scanner`, `/staff/pos`) |
| **Member** | `nguyenvana@gmail.com` | `password` | Khách hàng thành viên hạng Bronze |
| **Member VIP** | `levanc@gmail.com` | `password` | Thành viên hạng Platinum (12,000 điểm) |

---

## 🧪 5. Kiểm Thử Tự Động (Running Tests)

- **Chạy Unit Test Frontend**:
  ```powershell
  cd "Cinema-Booking-System-main/source-code/galaxy-cinema-hub-main"
  npm test
  ```
- **Kiểm tra cú pháp toàn bộ file Backend PHP**:
  ```powershell
  cd "Cinema-Booking-System-main"
  Get-ChildItem -Path "backend", "scripts" -Filter "*.php" -Recurse | ForEach-Object { & "D:\MCRo VSCODE\PHPmyadmin\XAMPP\php\php.exe" -l $_.FullName }
  ```
- **Chạy Smoke Test API (Booking & Transaction Flow)**:
  ```powershell
  cd "Cinema-Booking-System-main"
  # Yêu cầu backend đang chạy ở cổng 8000
  php scripts/test_api.php
  ```

---

## 🛠️ 6. Xử Lý Sự Cố Thường Gặp (Troubleshooting)

1. **Lỗi `Database Connection Error`**:
   - Kiểm tra xem MySQL trong XAMPP hoặc Docker đã được bật chưa.
   - Kiểm tra thông tin trong `backend/.env` (mặc định XAMPP không có mật khẩu root, nên để `DB_PASSWORD=`).
2. **Lỗi cổng bị chiếm dụng (Port in use)**:
   - Cổng 8000: Kiểm tra xem có terminal PHP server nào đang chạy ngầm không.
   - Cổng 5173: Vite sẽ tự động đổi sang `5174` nếu cổng 5173 bận.
3. **Mã xác nhận đăng ký tài khoản (OTP Verification Code)**:
   - Nếu không cấu hình SMTP Gmail thật, mã xác thực 6 số sẽ được ghi trực tiếp ra log console của PHP server hoặc lưu trong `backend/uploads/verification_codes.json`.
