<?php

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

$publicPath = __DIR__.'/public';

if ($uri !== '/' && file_exists($publicPath.$uri) && is_file($publicPath.$uri)) {
    $ext = pathinfo($publicPath.$uri, PATHINFO_EXTENSION);
    $mimeTypes = [
        'css'  => 'text/css',
        'js'   => 'application/javascript',
        'png'  => 'image/png',
        'jpg'  => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif'  => 'image/gif',
        'svg'  => 'image/svg+xml',
        'ico'  => 'image/x-icon',
        'json' => 'application/json',
        'woff' => 'font/woff',
        'woff2'=> 'font/woff2',
        'ttf'  => 'font/ttf',
        'webp' => 'image/webp',
    ];
    if (isset($mimeTypes[$ext])) {
        header('Content-Type: '.$mimeTypes[$ext]);
    }
    readfile($publicPath.$uri);
    return;
}

require_once $publicPath.'/index.php';