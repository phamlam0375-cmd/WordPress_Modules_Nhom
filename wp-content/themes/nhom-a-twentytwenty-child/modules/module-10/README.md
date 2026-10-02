# Module 10

- Người phụ trách: Nguyễn Duy Tùng
- Tên chức năng: Recent post (bài viết mới nhất)
- Trạng thái: Đã thực hiện
- Vị trí: trang chi tiết, cột phải (Categories | Detail | Recent post)
- File PHP: `functions.php` (gắn hook `nhom_a_single_right_column`, hàm ngày dạng phân số, nạp CSS), `recent-post.php` (giao diện)
- File CSS: `style.css`
- File JavaScript: không có
- Tham khảo: http://fit.tdc.edu.vn
- Cách kiểm tra: mở một bài viết. Cột phải có nền xanh ngọc, 5 bài mới nhất (không tính bài đang xem), mỗi bài có ngày dạng phân số `ngày/tháng` + `năm`, cuối khung có nút "XEM TẤT CẢ TIN TỨC". Đăng thêm một bài mới rồi tải lại để thấy bài đó lên đầu danh sách.
- Ghi chú: nút "Xem tất cả" trỏ về trang Bài viết nếu đã đặt trong **Cài đặt → Đọc**, nếu không thì về trang chủ.
