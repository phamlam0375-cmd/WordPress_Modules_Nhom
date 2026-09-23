<?php

/**
 * Template Part: Nút "Chia sẻ" + dropdown menu.
 *
 * Cách dùng: get_template_part( 'template-parts/share-dropdown' );
 *
 * Biến (tùy chọn):
 * - $args['title'] : tiêu đề chia sẻ (mặc định: tiêu đề bài viết).
 * - $args['url']   : URL chia sẻ (mặc định: permalink bài viết).
 */

$share_title = isset($args['title']) ? $args['title'] : get_the_title();
$share_url   = isset($args['url'])   ? $args['url']   : get_permalink();

$encoded_url   = rawurlencode($share_url);
$encoded_title = rawurlencode($share_title);

$has_native_share = true; // JS sẽ kiểm tra và fallback nếu cần.
?>

<div class="gcn-share-wrap">

    <button type="button" class="gcn-share-toggle" aria-haspopup="true" aria-expanded="false">
        <svg viewBox="0 0 24 24" aria-hidden="true">
            <path d="M18 16.08c-.76 0-1.44.3-1.96.77L8.91 12.7c.05-.23.09-.46.09-.7s-.04-.47-.09-.7l7.05-4.11c.54.5 1.25.81 2.04.81 1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3c0 .24.04.47.09.7L8.04 9.81C7.5 9.31 6.79 9 6 9c-1.66 0-3 1.34-3 3s1.34 3 3 3c.79 0 1.5-.31 2.04-.81l7.12 4.16c-.05.21-.08.43-.08.65 0 1.61 1.31 2.92 2.92 2.92s2.92-1.31 2.92-2.92-1.31-2.92-2.92-2.92z" />
        </svg>
        <span class="gcn-share-toggle-text">Chia sẻ</span>
    </button>

    <div class="gcn-share-menu" role="menu">

        <?php /* Facebook */ ?>
        <a class="gcn-share-item"
            href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_attr($encoded_url); ?>"
            target="_blank"
            rel="noopener noreferrer"
            role="menuitem">
            <span class="gcn-share-item-icon gcn-icon-facebook">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                </svg>
            </span>
            <span class="gcn-share-item-label">Facebook</span>
        </a>

        <?php /* Twitter / X */ ?>
        <a class="gcn-share-item"
            href="https://twitter.com/intent/tweet?url=<?php echo esc_attr($encoded_url); ?>&text=<?php echo esc_attr($encoded_title); ?>"
            target="_blank"
            rel="noopener noreferrer"
            role="menuitem">
            <span class="gcn-share-item-icon gcn-icon-twitter">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                </svg>
            </span>
            <span class="gcn-share-item-label">Twitter / X</span>
        </a>

        <?php /* LinkedIn */ ?>
        <a class="gcn-share-item"
            href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo esc_attr($encoded_url); ?>"
            target="_blank"
            rel="noopener noreferrer"
            role="menuitem">
            <span class="gcn-share-item-icon gcn-icon-linkedin">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.063 2.063 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.225 0z" />
                </svg>
            </span>
            <span class="gcn-share-item-label">LinkedIn</span>
        </a>

        <?php /* Zalo */ ?>
        <a class="gcn-share-item"
            href="https://zalo.me/share?u=<?php echo esc_attr($encoded_url); ?>"
            target="_blank"
            rel="noopener noreferrer"
            role="menuitem">
            <span class="gcn-share-item-icon gcn-icon-zalo">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 0C5.373 0 0 5.373 0 12c0 2.42.718 4.667 1.95 6.556L0 24l5.583-1.914A11.94 11.94 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm6.02 15.845c-.127.354-.734.679-1.017.72-.282.042-1.358.354-3.447-.93-2.517-1.548-4.093-4.238-4.215-4.434-.122-.196-.983-1.306-.983-2.492 0-1.186.624-1.769.846-2.012.222-.243.484-.304.646-.304.162 0 .323.002.464.009.149.006.35-.056.546.417.203.489.69 1.679.75 1.801.061.122.101.264.02.426-.081.162-.122.263-.242.405-.121.142-.255.318-.364.427-.121.121-.248.253-.107.496.141.243.628 1.036 1.348 1.678.925.824 1.703 1.079 1.945 1.2.242.121.383.101.523-.061.141-.162.606-.707.768-.95.162-.243.323-.202.545-.121.222.081 1.408.664 1.65.785.242.121.403.182.463.283.061.101.061.587-.066.94z" />
                </svg>
            </span>
            <span class="gcn-share-item-label">Zalo</span>
        </a>

        <?php /* Telegram */ ?>
        <a class="gcn-share-item"
            href="https://t.me/share/url?url=<?php echo esc_attr($encoded_url); ?>&text=<?php echo esc_attr($encoded_title); ?>"
            target="_blank"
            rel="noopener noreferrer"
            role="menuitem">
            <span class="gcn-share-item-icon gcn-icon-telegram">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M11.944 0A12 12 0 000 12a12 12 0 0012 12 12 12 0 0012-12A12 12 0 0012 0a12 12 0 00-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 01.171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z" />
                </svg>
            </span>
            <span class="gcn-share-item-label">Telegram</span>
        </a>

        <?php /* Email */ ?>
        <a class="gcn-share-item"
            href="mailto:?subject=<?php echo esc_attr($encoded_title); ?>&body=Xem bài viết này: <?php echo esc_attr($encoded_url); ?>"
            role="menuitem">
            <span class="gcn-share-item-icon gcn-icon-email">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                </svg>
            </span>
            <span class="gcn-share-item-label">Email</span>
        </a>

        <?php /* Copy link */ ?>
        <button type="button"
            class="gcn-share-item"
            data-gcn-copy="<?php echo esc_attr($share_url); ?>"
            role="menuitem">
            <span class="gcn-share-item-icon gcn-icon-copy">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z" />
                </svg>
            </span>
            <span class="gcn-share-item-label">Copy link</span>
        </button>

    </div>

</div>