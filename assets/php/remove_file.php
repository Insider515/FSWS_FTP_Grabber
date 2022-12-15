<?php
include_once('/assets/env/config.php');
header('Content-Type: text/html; charset=utf-8');
// Установка з'єднання
$conn_id = ftp_connect($resource_path);
    $login_result = ftp_login($conn_id, $login_ftp, $passwd_ftp);
ftp_pasv($conn_id, true);
// Видаліть файл із FTP-сервера
$file = $_POST['submit'];
if (ftp_delete($conn_id, ''.$_POST['submit'])) {
	header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
}
// Закриття з'єднання
ftp_close($conn_id);
?>