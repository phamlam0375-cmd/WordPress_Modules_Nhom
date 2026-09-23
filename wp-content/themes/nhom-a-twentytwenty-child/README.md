# Theme Nhom A Twenty Twenty Child

Đây là theme con dùng chung của nhóm A, kế thừa theme cha Twenty Twenty.

## Cấu trúc chính

- `style.css`: khai báo theme con.
- `functions.php`: nạp CSS và tự động nạp `functions.php` của từng module nếu file tồn tại.
- `header.php`, `footer.php`, `index.php`: dùng template hợp lệ của theme cha.
- `search.php`: entrypoint của WordPress, nạp `modules/module-05/search-template.php`.
- `single.php`: entrypoint của WordPress, nạp `modules/module-06/single-template.php`.
- `assets/css/layout.css`: CSS hiện có cho trang tìm kiếm và chi tiết bài viết.
- `modules/module-01` đến `modules/module-20`: khu vực code độc lập của từng thành viên.

## Quy ước module

Mỗi module tự ghi rõ file và cách kiểm tra trong `README.md` của module. Nếu cần thêm hook WordPress, tạo `functions.php` trong module; file này sẽ được nạp an toàn khi tồn tại. Không sửa module của thành viên khác khi chưa thống nhất.

Chi tiết cách kiểm tra module 5 và 6 còn được giữ trong `HUONG_DAN.md`.
