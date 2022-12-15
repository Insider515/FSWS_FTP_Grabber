// Установка з'єднання
$conn_id = ftp_connect('FTP сервер');
$login_result = ftp_login($conn_id, 'логин', 'пароль');
ftp_pasv($conn_id, true);
// Перейменувати файл і папку
if (ftp_rename ($conn_id, 'test.txt', 'test_1.txt')) {
echo 'Файл перейменовано';
} else {
echo 'Не вдалося перейменувати файл';
}
// Закриття з'єднання
ftp_close($conn_id);