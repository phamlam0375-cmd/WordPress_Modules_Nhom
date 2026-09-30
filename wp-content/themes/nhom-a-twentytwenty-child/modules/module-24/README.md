# Module 24 – Home Posts Grid

## Mục đích

Module 24 thay danh sách bài viết dọc mặc định trên trang blog (`is_home()`) bằng lưới card responsive. Module không tạo Trang, shortcode, widget, post type hoặc dữ liệu mới trong database.

## Cấu trúc file

```text
module-24/
├── README.md
├── functions.php
├── assets/
│   ├── css/
│   │   └── home-grid.css
│   └── images/
│       └── placeholder.svg
└── templates/
    ├── home-grid.php
    └── post-card.php
```

- `functions.php`: đổi template bằng hook `template_include`, nạp CSS và tìm ảnh đầu tiên trong nội dung.
- `templates/home-grid.php`: dùng main query hiện tại để hiển thị lưới bài viết và phân trang.
- `templates/post-card.php`: hiển thị một card gồm ảnh và tiêu đề bài viết.
- `assets/css/home-grid.css`: định dạng lưới 3/2/1 cột.
- `assets/images/placeholder.svg`: ảnh nội bộ dùng khi bài viết không có ảnh phù hợp.

## Cách hoạt động

`functions.php` của child theme tự động nạp `functions.php` của các module theo số thứ tự. Khi request là trang blog chính, Module 24 dùng filter `template_include` để chọn `templates/home-grid.php`.

Template sử dụng main query sẵn có qua `have_posts()` và `the_post()`; module không chạy `WP_Query` thứ hai. Phân trang WordPress vẫn nằm dưới toàn bộ lưới. Module không chạy trong admin, REST API, AJAX, feed, trang bài viết, Trang, tìm kiếm hoặc archive.

CSS chỉ được enqueue trên trang blog chính và các selector tùy chỉnh đều bắt đầu bằng `module24-`.

## Quy tắc chọn ảnh

Mỗi card chọn ảnh theo thứ tự:

1. Ảnh đại diện của bài viết ở kích thước `medium_large`.
2. Ảnh từ block `core/image`, kể cả block nằm trong `innerBlocks`.
3. Thẻ `img` đầu tiên trong nội dung, hỗ trợ `src`, `data-src` và `data-lazy-src`.
4. Ảnh đính kèm đầu tiên của bài viết.
5. `assets/images/placeholder.svg` của module.

URL được đọc từ attachment hoặc nội dung đã lưu; module không hard-code domain, localhost hay cổng và không tự tải ảnh mới về website.

## Responsive

- Desktop: 3 card mỗi hàng.
- Màn hình từ 768px đến 1023px: 2 card mỗi hàng.
- Màn hình tối đa 767px: 1 card mỗi hàng.

Nếu có nhiều bài viết hơn số cột, CSS Grid tự động đưa các card tiếp theo xuống hàng mới.

## Cách kiểm tra

1. Vào **Settings → Reading** và xác định trang đang dùng làm trang bài viết, hoặc dùng trang bài viết mặc định của website.
2. Tạo ít nhất 4 bài viết đã xuất bản để kiểm tra việc tự động xuống hàng.
3. Đặt ảnh đại diện cho một bài viết.
4. Với bài viết thứ hai, không đặt ảnh đại diện nhưng chèn một ảnh thuộc Media Library vào nội dung.
5. Với bài viết thứ ba, không đặt ảnh đại diện và không chèn ảnh để kiểm tra placeholder.
6. Mở trang blog và xác nhận chỉ có ảnh cùng tiêu đề liên kết; không có nội dung, excerpt, category, tác giả, ngày, bình luận, liên kết sửa hoặc đường phân cách.
7. Thu nhỏ trình duyệt để kiểm tra lần lượt bố cục 3, 2 và 1 cột.
8. Kiểm tra trang bài viết, Trang, tìm kiếm và archive để xác nhận Module 24 không thay đổi các màn hình đó.

Module tự áp dụng cho trang blog chính; không có shortcode và không cần tạo Trang riêng cho module.
