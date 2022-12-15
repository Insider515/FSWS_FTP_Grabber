// Установка з'єднання
$conn_id = ftp_connect('FTP сервер');
$login_result = ftp_login($conn_id, 'логiн', 'пароль');
ftp_pasv($conn_id, true);
// Створення директорії
if (ftp_mkdir($conn_id, 'new_patch')) {
	echo 'Директорія створена';
} else {
	echo 'Не вдалося створити директорію';
}
// Закриття з'єднання
ftp_close($conn_id);