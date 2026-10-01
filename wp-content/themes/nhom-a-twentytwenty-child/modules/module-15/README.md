# Module 15

- Người phụ trách: Nguyễn Duy Tùng
- Tên chức năng: Last posts (bài viết mới nhất dạng timeline)
- Trạng thái: Đã thực hiện
- Vị trí: trang danh sách (tìm kiếm), hàng ngang bên dưới 13 | Search result | 14, trên Footer
- File PHP: `functions.php` (gắn hook `nhom_a_search_after_columns`, ưu tiên 10, nạp CSS), `last-posts.php` (giao diện)
- File CSS: `style.css`
- File JavaScript: không có
- Tham khảo: https://bootsnipp.com/snippets/xrKXW
- Cách kiểm tra: tìm kiếm một từ khóa bất kỳ (vd `?s=máy`). Bên dưới kết quả có khung "Latest News": đường kẻ dọc, vòng tròn xanh, tiêu đề bên trái, ngày đăng bên phải, đoạn trích ngắn bên dưới. Module vẫn hiện khi không có kết quả tìm kiếm.
- Ghi chú: lấy 3 bài mới nhất, không phụ thuộc từ khóa tìm kiếm.
