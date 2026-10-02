# Module 09

- Người phụ trách: Nguyễn Duy Tùng
- Tên chức năng: Categories (danh sách chuyên mục)
- Trạng thái: Đã thực hiện
- Vị trí: trang chi tiết, cột trái (Categories | Detail | Recent post)
- File PHP: `functions.php` (gắn hook `nhom_a_single_left_column`, nạp CSS), `categories.php` (giao diện)
- File CSS: `style.css`
- File JavaScript: không có
- Tham khảo: http://fit.tdc.edu.vn
- Cách kiểm tra: mở một bài viết bất kỳ. Cột trái hiện tiêu đề "Categories", vạch sọc, khung trắng, mỗi chuyên mục có chấm vàng. Chuyên mục của bài đang xem được gạch chân. Thêm / đổi tên chuyên mục trong **Bài viết → Chuyên mục** rồi tải lại trang để thấy dữ liệu thay đổi.
- Ghi chú: hiển thị cả chuyên mục chưa có bài (`hide_empty => false`).
