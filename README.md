# WordPress Modules Nhóm A

Repo chứa mã nguồn WordPress dùng chung của nhóm A. Mỗi thành viên phát triển chức năng trong một module riêng của theme con, sau đó gửi pull request để tích hợp vào `master`.

Repo hiện dùng đúng mã nguồn WordPress 7.1 từ bản dự án nhóm đang chạy; không tự nâng cấp WordPress trong quá trình dựng cấu trúc.

## Phần mềm cần có

- WAMP hoặc XAMPP.
- PHP tương thích với phiên bản WordPress trong repo.
- MySQL hoặc MariaDB.
- Git.
- Trình duyệt web và, nếu cần, phpMyAdmin đi kèm WAMP/XAMPP.

## Cấu trúc thư mục

```text
WordPress_Modules_Nhom/
├── database/
│   └── wordpress_group.sql
├── wp-admin/
├── wp-includes/
├── wp-content/
│   ├── languages/
│   ├── plugins/
│   ├── themes/
│   │   ├── twentytwenty/
│   │   └── nhom-a-twentytwenty-child/
│   │       ├── assets/
│   │       └── modules/
│   │           ├── module-01/
│   │           ├── ...
│   │           └── module-20/
│   └── uploads/
├── wp-config-sample.php
└── các file WordPress ở thư mục gốc
```

Theme cha nằm tại `wp-content/themes/twentytwenty/`. Theme nhóm nằm tại `wp-content/themes/nhom-a-twentytwenty-child/`. Hai mươi module nằm tại `wp-content/themes/nhom-a-twentytwenty-child/modules/`.

## Cài đặt trên Windows

### 1. Clone repo

Mở PowerShell và chọn thư mục web của WAMP hoặc XAMPP. Ví dụ với WAMP:

```powershell
Set-Location C:\wamp64\www
git clone https://github.com/phamlam0375-cmd/WordPress_Modules_Nhom.git
Set-Location .\WordPress_Modules_Nhom
```

Với XAMPP, thư mục web thường là `C:\xampp\htdocs`:

```powershell
Set-Location C:\xampp\htdocs
git clone https://github.com/phamlam0375-cmd/WordPress_Modules_Nhom.git
Set-Location .\WordPress_Modules_Nhom
```

Nếu đã clone repo, chỉ cần mở đúng thư mục dự án; không clone chồng lên thư mục đang có.

### 2. Tạo và import database

Tạo database mới tên `wordpress_group`, dùng bộ ký tự `utf8mb4`. Có thể thực hiện trong phpMyAdmin hoặc bằng MySQL client:

```powershell
mysql --user=root --password --execute="CREATE DATABASE wordpress_group CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql --user=root --password --default-character-set=utf8mb4 wordpress_group --execute="source database/wordpress_group.sql"
```

Nếu tài khoản MySQL local không có mật khẩu, bỏ tùy chọn `--password`. Nếu lệnh `mysql` chưa có trong `PATH`, chạy file `mysql.exe` từ thư mục `bin` của WAMP/XAMPP hoặc import `database/wordpress_group.sql` bằng phpMyAdmin.

### 3. Tạo cấu hình local

Sao chép file cấu hình mẫu:

```powershell
Copy-Item .\wp-config-sample.php .\wp-config.php
```

Mở `wp-config.php` và sửa bốn giá trị theo MySQL trên máy:

```php
define( 'DB_NAME', 'wordpress_group' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', 'mat-khau-local-neu-co' );
define( 'DB_HOST', 'localhost' );
```

`wp-config.php` chỉ dùng trên từng máy và đã được `.gitignore` loại trừ. Tuyệt đối không commit file này.

### 4. Cập nhật địa chỉ local

Nếu URL local khác dữ liệu đã import, cập nhật hai tùy chọn `siteurl` và `home`. Ví dụ dự án chạy tại `http://localhost/WordPress_Modules_Nhom`:

```powershell
mysql --user=root --password wordpress_group --execute="UPDATE wp_options SET option_value='http://localhost/WordPress_Modules_Nhom' WHERE option_name IN ('siteurl','home');"
```

Nếu database dùng tiền tố bảng khác `wp_`, thay `wp_options` bằng tên bảng options thực tế. Cũng có thể sửa hai giá trị này trong phpMyAdmin. Sau đó mở URL local bằng trình duyệt.

### 5. Kích hoạt theme nhóm

Đăng nhập trang quản trị WordPress, vào **Giao diện → Giao diện** và kích hoạt **Nhom A Twenty Twenty Child**. Không xóa theme cha Twenty Twenty vì theme con phụ thuộc vào theme đó.

## Làm việc theo module

1. Chỉ sửa thư mục `modules/module-XX/` được phân công và các file dùng chung đã được nhóm thống nhất.
2. Ghi tên người phụ trách, chức năng, file liên quan và cách kiểm tra trong `README.md` của module.
3. Nếu module cần hook hoặc filter, có thể tạo `functions.php` trong module. Theme sẽ chỉ nạp file khi file tồn tại.
4. CSS hoặc JavaScript chỉ dùng riêng cho module nên đặt trong module đó. Tài nguyên thật sự dùng chung mới đặt trong `assets/` của theme.
5. Không sửa trực tiếp module của thành viên khác khi chưa trao đổi và được đồng ý.
6. Kiểm tra chức năng trên dữ liệu import trước khi tạo pull request.

Module 5 chứa trang tìm kiếm; module 6 chứa trang chi tiết bài viết. Hai entrypoint `search.php` và `single.php` vẫn ở gốc theme để WordPress nhận đúng template.

## Quy trình Git đề xuất

Cập nhật `master`, tạo branch cho module và chỉ commit sau khi đã kiểm tra:

```powershell
git switch master
git pull origin master
git switch -c feature/module-XX-mo-ta-ngan
git status --short
```

Sau khi code và kiểm tra:

```powershell
git add wp-content/themes/nhom-a-twentytwenty-child/modules/module-XX
git commit -m "Hoàn thiện module XX"
git push -u origin feature/module-XX-mo-ta-ngan
```

Tạo pull request từ branch module vào `master`. Không push thẳng lên `master`; xử lý review và xung đột trước khi merge.

## Cập nhật database chung

Chỉ cập nhật database chung khi thay đổi dữ liệu thật sự cần cho cả nhóm, ví dụ cấu hình WordPress hoặc nội dung mẫu đã thống nhất. Trước khi export, xóa dữ liệu cá nhân không cần thiết và kiểm tra không có mật khẩu MySQL rõ, token API, private key hoặc bí mật khác.

Ví dụ export bằng MySQL client từ thư mục repo:

```powershell
mysqldump --user=root --password --default-character-set=utf8mb4 --result-file=database\wordpress_group.sql wordpress_group
```

Sau khi export, kiểm tra dung lượng và diff, thông báo cho nhóm rằng database chung đã thay đổi. Thành viên khác cần backup dữ liệu local của mình trước khi import lại.

## An toàn thông tin

- Không commit `wp-config.php`, `.env`, file log, file ZIP backup, file cache, khóa `.pem`/`.key` hoặc thông tin xác thực.
- Không commit mật khẩu, token, private key hay dữ liệu cá nhân không cần thiết trong PHP, JavaScript, SQL hoặc tài liệu.
- Không sửa WordPress core trực tiếp. Thay đổi chức năng phải nằm trong theme con hoặc plugin phù hợp.
- Không tự nâng phiên bản WordPress hoặc plugin nếu nhóm chưa thống nhất và chưa kiểm tra tương thích.
