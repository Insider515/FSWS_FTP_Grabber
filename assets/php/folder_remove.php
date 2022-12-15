<?php
include_once('/assets/env/config.php');
header('Content-Type: text/html; charset=utf-8');
// Установка з'єднання
$conn_id = ftp_connect($resource_path);
$login_result = ftp_login($conn_id, $login_ftp, $passwd_ftp);
ftp_pasv($conn_id, true);
 // Видаліть файл із FTP-сервера
$file = $_POST['submit'];
// Видалення директорії з усім вмістом
function ftp_remove_dir($conn_id, $directory)
{ 
	if (!(@ftp_rmdir($conn_id, $directory) || @ftp_delete($conn_id, $directory))) { 
		$filelist = @ftp_nlist($conn_id, $directory); 
		print_r($filelist) ;
		if(count($filelist)>2){
		    $i=0;
		    foreach($filelist as $file) {
		        if($i < 2){
		            $i++;
		        }else {
		            ftp_remove_dir($conn_id, $file);
		        }
		} 
		}
		ftp_remove_dir($conn_id, $directory);
	} 
} 
ftp_remove_dir($conn_id, $_POST['submit']);
// Закриття з'єднання
ftp_close($conn_id);
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit;
