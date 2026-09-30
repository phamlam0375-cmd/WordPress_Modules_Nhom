# Module 13 – Kết quả tìm kiếm dạng cột trái

## Mục đích

Module 13 hiển thị lại chính các bài viết của trang kết quả tìm kiếm hiện tại dưới dạng card dọc ở cột trái. Module không truy vấn Page, bài mới hoặc một tập bài viết độc lập.

Danh sách Module 13 luôn có cùng post ID, thứ tự và trang phân trang với cột kết quả chính ở giữa. Module chỉ khác ở cách trình bày.

## Nguồn dữ liệu

`nhom_a_module13_get_main_search_posts()` đọc trực tiếp `$wp_query->posts` của main search query. Module không tạo `WP_Query`, không gọi `query_posts()`, không dùng `pre_get_posts` và không hard-code ID.

Template đọc tiêu đề, URL, excerpt và thumbnail bằng post ID. Module không gọi `the_post()` hoặc `setup_postdata()`, vì vậy con trỏ `current_post` của main loop không thay đổi và không cần gọi `wp_reset_postdata()`.

Nếu main search query không có kết quả, Module 13 trả về chuỗi rỗng và không hiển thị dữ liệu cũ.

## Cấu trúc

```text
module-13/
├── README.md
├── functions.php
├── assets/
│   ├── css/
│   │   └── search-column.css
│   └── images/
│       └── placeholder.svg
└── templates/
    └── search-column.php
```

- `functions.php`: lấy dữ liệu từ main query, đăng ký hook cột trái và enqueue CSS chỉ trên `is_search()`.
- `templates/search-column.php`: render card theo đúng thứ tự `$wp_query->posts`.
- `assets/css/search-column.css`: bố cục cột và giao diện đơn giản, chỉ dùng class `module13-`.
- `assets/images/placeholder.svg`: ảnh dự phòng cho bài không có Featured Image.

## Hook tích hợp

- `nhom_a_search_left_column`: Module 13 tự gắn vào hook này.
- `nhom_a_search_right_column`: vị trí dành cho Module 14 nếu module đó đăng ký callback.
- `nhom_a_search_after_columns`: vị trí dành cho Module 15 nếu module đó đăng ký callback.

Các hook nằm ngoài vòng lặp kết quả chính. Module 13 không thay đổi markup card, truy vấn hoặc phân trang ở cột giữa.

## Giao diện và responsive

- Mỗi kết quả nằm trên một hàng riêng trong cột trái.
- Ảnh có tỷ lệ `16 / 9`, dùng `object-fit: cover` và không tràn cột.
- Card không bo góc, không đổ bóng và không có hiệu ứng phóng to.
- Dưới 901px, các cột chuyển thành một cột; Module 13 vẫn đứng trước kết quả chính.
- Module không dùng JavaScript, `position: absolute` hoặc `margin-left` cố định.

## Cách kiểm tra

1. Tìm `an toàn thông tin` và so sánh số lượng, tiêu đề, thứ tự cùng URL giữa Module 13 và cột giữa.
2. Tìm một từ khóa khác và xác nhận cả hai cột cùng thay đổi.
3. Tìm một chuỗi không tồn tại và xác nhận Module 13 không hiển thị card cũ.
4. Nếu kết quả có nhiều trang, chuyển trang và so sánh hai cột lần nữa.
5. Mở trang chủ hoặc bài viết để xác nhận Module 13 không xuất hiện và CSS module không được enqueue.
