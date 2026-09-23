/**
 * Share Dropdown — Toggle menu + Copy link + Web Share API.
 */
(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        initDropdowns();
        initCopyButtons();
        initNativeShare();
    });

    /**
     * Khởi tạo tất cả dropdown chia sẻ trên trang.
     */
    function initDropdowns() {
        var wraps = document.querySelectorAll('.gcn-share-wrap');

        wraps.forEach(function (wrap) {
            var toggle = wrap.querySelector('.gcn-share-toggle');
            if (!toggle) return;

            // Toggle khi click nút.
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                // Đóng các dropdown khác.
                document.querySelectorAll('.gcn-share-wrap.is-open').forEach(function (other) {
                    if (other !== wrap) {
                        other.classList.remove('is-open');
                    }
                });

                wrap.classList.toggle('is-open');
            });

            // Ngăn click trong menu đóng dropdown.
            var menu = wrap.querySelector('.gcn-share-menu');
            if (menu) {
                menu.addEventListener('click', function (e) {
                    e.stopPropagation();
                });
            }
        });

        // Click ra ngoài → đóng tất cả dropdown.
        document.addEventListener('click', function () {
            document.querySelectorAll('.gcn-share-wrap.is-open').forEach(function (wrap) {
                wrap.classList.remove('is-open');
            });
        });

        // Nhấn ESC → đóng tất cả.
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('.gcn-share-wrap.is-open').forEach(function (wrap) {
                    wrap.classList.remove('is-open');
                });
            }
        });
    }

    /**
     * Nút "Copy link".
     */
    function initCopyButtons() {
        var buttons = document.querySelectorAll('[data-gcn-copy]');

        buttons.forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();

                var url = btn.getAttribute('data-gcn-copy') || window.location.href;

                copyToClipboard(url).then(function () {
                    showToast('Đã copy link bài viết!');
                    closeParentDropdown(btn);
                }).catch(function () {
                    showToast('Không thể copy. Vui lòng copy thủ công.');
                });
            });
        });
    }

    /**
     * Web Share API — dùng cho mobile.
     */
    function initNativeShare() {
        var buttons = document.querySelectorAll('[data-gcn-native-share]');

        buttons.forEach(function (btn) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();

                var url = btn.getAttribute('data-gcn-native-share') || window.location.href;
                var title = btn.getAttribute('data-gcn-share-title') || document.title;

                if (navigator.share) {
                    navigator.share({
                        title: title,
                        text: title,
                        url: url
                    }).catch(function () {
                        // User hủy — không làm gì.
                    });
                } else {
                    copyToClipboard(url).then(function () {
                        showToast('Đã copy link bài viết!');
                    });
                }
            });
        });
    }

    /**
     * Copy text vào clipboard — có fallback.
     */
    function copyToClipboard(text) {
        if (navigator.clipboard && window.isSecureContext) {
            return navigator.clipboard.writeText(text);
        }

        return new Promise(function (resolve, reject) {
            try {
                var textarea = document.createElement('textarea');
                textarea.value = text;
                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';
                textarea.style.left = '-9999px';
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
                resolve();
            } catch (err) {
                reject(err);
            }
        });
    }

    /**
     * Hiện toast thông báo.
     */
    function showToast(message) {
        var existing = document.querySelector('.gcn-share-toast');
        if (existing) {
            existing.remove();
        }

        var toast = document.createElement('div');
        toast.className = 'gcn-share-toast';
        toast.textContent = message;
        document.body.appendChild(toast);

        void toast.offsetWidth;
        toast.classList.add('is-visible');

        setTimeout(function () {
            toast.classList.remove('is-visible');
            setTimeout(function () {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 300);
        }, 2500);
    }

    /**
     * Đóng dropdown cha của 1 element.
     */
    function closeParentDropdown(el) {
        var wrap = el.closest('.gcn-share-wrap');
        if (wrap) {
            wrap.classList.remove('is-open');
        }
    }
})();