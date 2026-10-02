# Module 25

- Người phụ trách: Nguyễn Duy Tùng
- Tên chức năng: Thống kê website (module tự chọn, ngoài danh sách 15 module)
- Trạng thái: Đã thực hiện
- Vị trí: trang chủ, hàng mới giữa Archive (11) | Content (02) | Comments (12) và Footer
- File PHP: `functions.php` (gắn hook `nhom_a_home_after_columns`, nạp CSS), `statistics.php` (giao diện)
- File CSS: `style.css`
- File JavaScript: không có (icon dùng Font Awesome 6 mà theme đã nạp sẵn)
- Cách kiểm tra: mở trang chủ, kéo xuống dưới 3 cột. Khung "Thống kê website" có 4 ô: Bài viết, Chuyên mục, Bình luận, Thẻ và dòng "Cập nhật lần cuối" kèm link bài mới nhất. Đăng thêm bài / duyệt thêm bình luận rồi tải lại để thấy số liệu tăng. Có thể mở thẳng `/#module25-stats`.
- Ghi chú: chỉ đếm bài đã xuất bản và bình luận đã duyệt.
