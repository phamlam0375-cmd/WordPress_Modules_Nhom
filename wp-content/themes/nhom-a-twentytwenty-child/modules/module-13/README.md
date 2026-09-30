# Module 13

## Mục đích

Module 13 thay danh sách Pages đơn giản bằng các card lấy dữ liệu động từ WordPress. Giao diện hiển thị ba card mỗi hàng trên desktop và một card mỗi hàng ở màn hình nhỏ hơn 768px.

Module không tự tạo hoặc sửa Trang trong database và không thay đổi widget Pages mặc định của WordPress.

## Cấu trúc file

```text
module-13/
├── README.md
├── functions.php
├── includes/
│   └── class-module13-pages-widget.php
├── templates/
│   └── pages-grid.php
└── assets/
    └── css/
        └── pages-grid.css
```

- `functions.php`: đăng ký shortcode, widget, CSS, excerpt cho Page và hàm render dùng chung.
- `includes/class-module13-pages-widget.php`: widget **Module 13 – Pages Cards**.
- `templates/pages-grid.php`: vòng lặp card và placeholder ảnh.
- `assets/css/pages-grid.css`: CSS Grid responsive, giới hạn bằng tiền tố `module13-`.

## Dùng shortcode

Mặc định hiển thị tối đa ba Trang với tiêu đề **Pages**:

```text
[module13_pages]
```

Tùy chỉnh số lượng từ 1 đến 12 và tiêu đề:

```text
[module13_pages limit="3" title="Pages"]
```

Nếu shortcode nằm trong một Trang, Trang hiện tại sẽ không xuất hiện trong danh sách.

## Thêm widget

1. Vào **Giao diện → Widget** hoặc màn hình quản lý widget tương ứng của WordPress.
2. Xóa widget **Pages** mặc định nếu không còn cần dùng.
3. Thêm widget **Module 13 – Pages Cards** vào **Footer #1** hoặc **Footer #2** của Twenty Twenty.
4. Nhập tiêu đề và số lượng Trang từ 1 đến 12 rồi lưu.

Shortcode và widget gọi chung `nhom_a_module13_render_pages_cards()`, nên thứ tự, nội dung và giao diện card giống nhau.

## Tạo ba Trang thử nghiệm

1. Vào **Trang → Thêm trang mới**.
2. Tạo ba Trang với tiêu đề và nội dung khác nhau, sau đó bấm **Đăng**.
3. Có thể đặt **Thứ tự** trong thuộc tính Trang; module sắp xếp theo `menu_order`, sau đó theo tiêu đề tăng dần.
4. Module chỉ truy vấn các Trang có trạng thái `publish` và không tự tạo dữ liệu mẫu.

## Đặt ảnh đại diện và excerpt

1. Mở Trang cần sửa trong trình soạn thảo.
2. Chọn **Ảnh đại diện**, tải hoặc chọn ảnh trong thư viện Media rồi cập nhật Trang.
3. Nhập nội dung ngắn trong trường **Excerpt/Tóm tắt**. Module tự bổ sung hỗ trợ excerpt cho Pages.
4. Nếu không có excerpt, module loại shortcode khỏi nội dung và rút gọn khoảng 20 từ.
5. Nếu không có ảnh đại diện, card hiển thị placeholder **Chưa có ảnh**.

## Kiểm tra responsive

1. Chèn shortcode hoặc thêm widget rồi mở trang frontend.
2. Ở chiều rộng từ 768px trở lên, xác nhận mỗi hàng có ba card; card thứ tư tự xuống hàng mới.
3. Thu nhỏ trình duyệt xuống 767px hoặc dùng chế độ thiết bị của DevTools.
4. Xác nhận mỗi hàng chỉ có một card, ảnh giữ cùng tỷ lệ và nội dung không tràn khỏi card.

