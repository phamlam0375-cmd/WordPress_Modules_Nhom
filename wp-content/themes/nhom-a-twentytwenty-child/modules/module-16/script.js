(function () {
    'use strict';

    document.addEventListener('DOMContentLoaded', function () {
        var copyBtn = document.querySelector('.gcn-share-copy');
        if (!copyBtn) return;

        copyBtn.addEventListener('click', function () {
            var url = copyBtn.getAttribute('data-url');
            if (!url) return;

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url).then(function () {
                    showCopied(copyBtn);
                }).catch(function () {
                    fallbackCopy(url, copyBtn);
                });
            } else {
                fallbackCopy(url, copyBtn);
            }
        });

        function fallbackCopy(text, btn) {
            var textarea = document.createElement('textarea');
            textarea.value = text;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();
            try {
                document.execCommand('copy');
                showCopied(btn);
            } catch (e) {
                alert('Không thể sao chép. Vui lòng copy thủ công: ' + text);
            }
            document.body.removeChild(textarea);
        }

        function showCopied(btn) {
            var originalText = btn.querySelector('span').textContent;
            btn.classList.add('is-copied');
            btn.querySelector('span').textContent = 'Đã copy!';

            setTimeout(function () {
                btn.classList.remove('is-copied');
                btn.querySelector('span').textContent = originalText;
            }, 2000);
        }
    });
})();