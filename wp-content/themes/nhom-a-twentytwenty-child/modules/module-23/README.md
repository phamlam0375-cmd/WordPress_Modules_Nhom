# Module 23

- Người phụ trách: Nguyễn Duy Tùng
- Tên chức năng: Tags - Đám mây thẻ (module tự chọn, ngoài danh sách 15 module)
- Trạng thái: Đã thực hiện
- Vị trí: trang danh sách (tìm kiếm), hàng mới giữa Last posts (15) và Footer
- File PHP: `functions.php` (gắn hook `nhom_a_search_after_columns`, ưu tiên 20 để nằm sau module 15, nạp CSS), `tags.php` (giao diện)
- File CSS: `style.css`
- File JavaScript: không có
- Cách kiểm tra: tìm kiếm một từ khóa bất kỳ. Dưới khung "Latest News" có khung "Tags" gồm các thẻ dạng `#tên-thẻ` kèm số bài. Thẻ có nhiều bài nhất tô nền xanh đậm. Bấm một thẻ để mở danh sách bài của thẻ đó. Gắn thêm thẻ cho bài trong **Bài viết → Sửa** rồi tải lại để thấy số bài thay đổi.
- Ghi chú: chỉ hiện thẻ đã có bài (`hide_empty => true`). Module tự ẩn khi website chưa có thẻ nào.
