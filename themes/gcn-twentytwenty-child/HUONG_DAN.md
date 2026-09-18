# Làm trang tìm kiếm và chi tiết bài viết trên WordPress 7.1

Gói này là giao diện con của **Twenty Twenty (2020)**. Nó sử dụng 10 bài viết đang có, không tạo thêm bài viết. Trang chủ và các khu vực widget Footer #1 của giao diện gốc vẫn do Twenty Twenty xử lý.

## Cài đặt trên máy WAMP

1. Kiểm tra ở **Giao diện → Giao diện** rằng theme **Twenty Twenty** đã được cài.
2. Vào **Giao diện → Giao diện → Thêm giao diện → Tải giao diện lên**.
3. Chọn tệp ZIP chứa thư mục `gcn-twentytwenty-child`, bấm **Cài đặt** rồi **Kích hoạt** theme **Góc Công Nghệ - Search & Detail**.
4. Nếu các widget Footer #1 biến mất sau khi đổi theme: vào **Giao diện → Cấu hình cột tiện ích**, mở **Footer #1** và **Tiện ích không sử dụng** để đưa lại widget.

## Kiểm tra phần (5): Search result

- Vào trang chủ và dùng ô tìm kiếm, thử một từ khóa có trong bài viết, ví dụ `tennis`.
- Bạn cũng có thể thử `http://wordpress.local:8080/?s=tennis` nếu site của bạn dùng địa chỉ này.
- Kết quả hiện theo từng thẻ: ảnh đại diện trái, ngày đăng ở giữa, tiêu đề và tóm tắt bên phải. Nếu bài chưa đặt ảnh đại diện, thẻ sẽ hiện chữ **Góc Công Nghệ**. Muốn có ảnh thật, mở **Bài viết → Sửa bài viết → Ảnh đại diện**, chọn ảnh và cập nhật.
- Mở một tìm kiếm không có kết quả để kiểm tra thông báo. Nếu có nhiều trang kết quả, các nút phân trang nằm ở cuối.

## Kiểm tra phần (6): Detail

- Bấm tên của một bài trong trang kết quả: trang chi tiết có tiêu đề, vòng tròn vàng với ngày đăng, ảnh đại diện nếu có, toàn bộ nội dung và danh mục.
- Nếu link sang `127.0.0.1`, kiểm tra ở **Cài đặt → Tổng quan** rằng cả **Địa chỉ WordPress (URL)** và **Địa chỉ trang web (URL)** đều là URL đầy đủ, ví dụ `http://wordpress.local:8080`, rồi lưu lại. Không nhập `wordpress.local:8080` mà thiếu `http://`.

## Các tệp trong gói

- `search.php` là mẫu kết quả tìm kiếm; dùng vòng lặp truy vấn chính của WordPress để giữ phân trang và đúng từ khóa.
- `single.php` là mẫu của trang chi tiết một bài viết.
- `functions.php` nạp CSS và chỉ lọc bài viết cho trang tìm kiếm.
- `assets/css/layout.css` chứa thiết kế khung, bố cục và chỉnh cho màn hình điện thoại.

Nếu cần trở lại giao diện cũ, vào **Giao diện → Giao diện** và kích hoạt lại **Twenty Twenty**.
