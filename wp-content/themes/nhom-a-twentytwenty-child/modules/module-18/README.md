# Module 18

## Mục đích

Module 18 thêm chức năng Like/Bỏ Like thật vào cuối nội dung của từng bài viết. Người dùng phải đăng nhập, mỗi tài khoản chỉ được tính tối đa một lượt Like cho mỗi bài và thao tác được xử lý bằng WordPress AJAX mà không tải lại trang.

## Cấu trúc file

```text
module-18/
├── README.md
├── functions.php
├── templates/
│   └── like-button.php
└── assets/
    ├── css/
    │   └── like-button.css
    └── js/
        └── like-button.js
```

- `functions.php`: chuẩn hóa dữ liệu, gắn nút vào `the_content`, nạp tài nguyên và xử lý AJAX.
- `templates/like-button.php`: giao diện cho người đã đăng nhập và khách.
- `assets/css/like-button.css`: giao diện responsive, giới hạn bằng tiền tố `module18-`.
- `assets/js/like-button.js`: gửi Like/Bỏ Like bằng AJAX, cập nhật trạng thái và khóa nút trong lúc gửi.

## Cách lưu dữ liệu

Module không tạo bảng mới và không dùng SQL trực tiếp. Mỗi bài viết lưu một mảng ID người dùng trong post meta:

```text
_nhom_a_module18_liked_users
```

Khi đọc hoặc ghi, dữ liệu được kiểm tra phải là mảng, chuẩn hóa bằng `absint()`, loại ID bằng `0` và loại ID trùng bằng `array_unique()`. Tổng Like là số phần tử hợp lệ còn lại.

## Quy trình Like/Bỏ Like

1. Filter `the_content` thêm nút sau nội dung, chỉ trên trang chi tiết `post`, trong main loop và main query.
2. PHP truyền AJAX URL, nonce, URL đăng nhập và thông báo cho JavaScript.
3. JavaScript khóa nút rồi gửi `post_id`, action và nonce tới `admin-ajax.php`.
4. Handler kiểm tra nonce, bài viết, loại nội dung, đăng nhập và quyền đọc bài.
5. Nếu ID chưa có, module thêm ID; nếu đã có, module xóa ID.
6. WordPress cập nhật post meta và trả JSON để giao diện đổi giữa **Thích** và **Đã thích**.

## Cách kiểm tra với hai tài khoản

1. Đăng nhập tài khoản A, mở một bài viết và ghi lại tổng Like.
2. Bấm **Thích**; kiểm tra nút đổi thành **Đã thích**, số Like tăng một và vẫn giữ nguyên sau khi tải lại.
3. Bấm lần nữa; kiểm tra nút trở về **Thích** và số Like giảm một.
4. Đăng nhập tài khoản B và Like cùng bài; xác nhận tổng tăng nhưng mỗi tài khoản chỉ đóng góp một lượt.
5. Quay lại tài khoản A để xác nhận trạng thái riêng của A được giữ đúng.
6. Đăng xuất; xác nhận vẫn thấy tổng Like và link **Đăng nhập để thích** quay lại đúng bài viết sau khi đăng nhập.
7. Bấm nhanh nhiều lần và xác nhận nút bị khóa trong lúc AJAX đang chạy.

## Giới hạn

- Mảng ID tăng theo số người Like; bài có lượng Like rất lớn sẽ làm post meta lớn và tốn chi phí đọc/ghi hơn giải pháp bảng riêng.
- Mỗi lần thay đổi phải ghi lại toàn bộ mảng, nên các request đồng thời ở lưu lượng cao có thể ghi đè lẫn nhau.
- ID của tài khoản đã bị xóa có thể còn trong meta cho tới khi dữ liệu được dọn thủ công.
- Thiết kế này phù hợp với quy mô bài tập/nhóm nhỏ, không thay thế hệ thống reaction hoặc thống kê chuyên dụng ở quy mô lớn.

