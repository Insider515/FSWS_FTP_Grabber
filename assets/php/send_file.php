<?php
include_once('/assets/env/config.php');
header('Content-Type: text/html; charset=utf-8');
// Установка з'єднання
$conn_id = ftp_connect($resource_path);
$login_result = ftp_login($conn_id, $login_ftp, $passwd_ftp);
ftp_pasv($conn_id, true);
// Завантаження файлу 
$file = $_FILES['filename']['tmp_name'];
$filename = preg_replace('/\s/', '_', $_FILES['filename']['name']);
// Отримати поточну url-адресу
$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// Парсим url
$parts = parse_url($url);
if (isset($parts['query'])) {
    parse_str($parts['query'], $query);
}
// Отримуємо директорію
if (isset($query['folder'])) {
    $path = './' . $query['folder'] . '/' . $filename;
} else {
    $path = basename($filename);
}
//if (ftp_put($conn_id, basename($filename), $file, FTP_ASCII)) {
if (ftp_put($conn_id, $path, $file, FTP_ASCII)) {
    //header("Location: /assets/php/index.php");
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
// Закриття з'єднання
ftp_close($conn_id);
