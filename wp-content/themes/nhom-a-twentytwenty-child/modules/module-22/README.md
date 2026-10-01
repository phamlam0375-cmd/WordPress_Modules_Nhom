# Module 22

- Người phụ trách: Nguyễn Duy Tùng
- Tên chức năng: Related posts - Bài viết liên quan (module tự chọn, ngoài danh sách 15 module)
- Trạng thái: Đã thực hiện
- Vị trí: trang chi tiết, hàng mới giữa Prev - Next (07) / Tác giả (17) và Comments (08)
- File PHP: `functions.php` (gắn hook `nhom_a_single_before_comments`, nạp CSS), `related-posts.php` (giao diện)
- File CSS: `style.css`
- File JavaScript: không có
- Cách kiểm tra: mở một bài viết có chuyên mục chứa từ 2 bài trở lên. Trên khung bình luận có "Bài viết liên quan" gồm tối đa 3 thẻ: ảnh đại diện (hoặc chữ cái đầu nếu chưa có ảnh), tên chuyên mục, tiêu đề, ngày đăng. Thu nhỏ cửa sổ dưới 700px để thấy thẻ rớt xuống 1 cột.
- Ghi chú: module tự ẩn khi chuyên mục không còn bài nào khác.
