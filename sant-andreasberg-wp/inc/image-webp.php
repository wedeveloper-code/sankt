<?php
defined('ABSPATH') || exit;

/* =============================================
   AUTO CONVERT UPLOADED IMAGES TO WEBP
   Max size: 200 KB
   ============================================= */

add_filter('wp_handle_upload', function (array $file): array {
    $mime = $file['type'] ?? '';
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/bmp', 'image/tiff'];

    if (!in_array($mime, $allowed, true)) {
        return $file; // skip non-images and already-WebP files
    }

    if (!function_exists('imagewebp')) {
        /* GD not available – skip silently */
        return $file;
    }

    $source_path = $file['file'];
    $webp_path   = preg_replace('/\.(jpe?g|png|gif|bmp|tiff?)$/i', '.webp', $source_path);

    $image = sa_load_image($source_path, $mime);
    if (!$image) {
        return $file;
    }

    /* First pass: quality 82 */
    $quality = 82;
    imagewebp($image, $webp_path, $quality);

    /* Reduce quality until ≤ 200 KB */
    $max_bytes = 200 * 1024;
    while (file_exists($webp_path) && filesize($webp_path) > $max_bytes && $quality > 20) {
        $quality -= 5;
        imagewebp($image, $webp_path, $quality);
        clearstatcache(true, $webp_path);
    }

    imagedestroy($image);

    if (!file_exists($webp_path)) {
        return $file;
    }

    /* Remove original if different from webp path */
    if ($webp_path !== $source_path) {
        @unlink($source_path);
    }

    $file['file'] = $webp_path;
    $file['url']  = str_replace(basename($source_path), basename($webp_path), $file['url']);
    $file['type'] = 'image/webp';

    return $file;
});

function sa_load_image(string $path, string $mime): GdImage|false {
    return match ($mime) {
        'image/jpeg' => @imagecreatefromjpeg($path),
        'image/png'  => sa_load_png($path),
        'image/gif'  => @imagecreatefromgif($path),
        'image/bmp'  => @imagecreatefrombmp($path),
        'image/webp' => @imagecreatefromwebp($path),
        default      => false,
    };
}

function sa_load_png(string $path): GdImage|false {
    $img = @imagecreatefrompng($path);
    if (!$img) return false;
    /* Preserve transparency */
    $w = imagesx($img);
    $h = imagesy($img);
    $bg = imagecreatetruecolor($w, $h);
    $white = imagecolorallocate($bg, 255, 255, 255);
    imagefill($bg, 0, 0, $white);
    imagecopy($bg, $img, 0, 0, 0, 0, $w, $h);
    imagedestroy($img);
    return $bg;
}

/* ---- Filter mime type in media library ---- */
add_filter('upload_mimes', function (array $mimes): array {
    $mimes['webp'] = 'image/webp';
    return $mimes;
});

/* ---- Show converted notice in admin ---- */
add_filter('wp_handle_upload_prefilter', function (array $file): array {
    add_filter('wp_handle_upload', function (array $uploaded) use ($file): array {
        if ($uploaded['type'] === 'image/webp' && $file['type'] !== 'image/webp') {
            set_transient('sa_webp_converted_notice', 1, 30);
        }
        return $uploaded;
    }, 20);
    return $file;
});
