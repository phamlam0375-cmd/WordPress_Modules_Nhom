# Module 20

- Người phụ trách: Nguyễn Duy Tùng
- Tên chức năng: Breadcrumb (module tự chọn, ngoài danh sách 15 module)
- Trạng thái: Đã thực hiện
- Vị trí: trang chi tiết, hàng mới giữa Header và hàng Categories | Detail | Recent post
- File PHP: `functions.php` (gắn hook `nhom_a_single_before_content`, nạp CSS), `breadcrumb.php` (giao diện)
- File CSS: `style.css`
- File JavaScript: không có
- Cách kiểm tra: mở một bài viết. Phía trên nội dung có thanh "Trang chủ › Chuyên mục › Tên bài", viền trái màu vàng. Bấm "Trang chủ" về trang chủ, bấm tên chuyên mục mở trang chuyên mục. Đổi chuyên mục của bài rồi tải lại để thấy breadcrumb đổi theo.
- Ghi chú: dùng chuyên mục đầu tiên nếu bài có nhiều chuyên mục.
