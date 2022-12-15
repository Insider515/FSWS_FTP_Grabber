<?php
include_once('/assets/env/config.php');
header('Content-Type: text/html; charset=utf-8');
// Установка з'єднання
$conn_id = ftp_connect($resource_path);
$login_result = ftp_login($conn_id, $login_ftp, $passwd_ftp);
ftp_pasv($conn_id, true);
// Прочитати файл у змінну
$file = $_POST['submit'];
$handle = fopen('php://temp', 'r+');
// Отримати поточну url-адресу
$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
// Парсим url
$parts = parse_url($url);
if (isset($parts['query'])) {
  parse_str($parts['query'], $query);
}
// Отримуємо директорію
if (isset($query['folder'])) {
  // Отримати вміст поточної директорії в яку перейшли
  // $contents = ftp_rawlist($conn_id, $query['folder']);
} else {
}
if (ftp_fget($conn_id, $handle, $file, FTP_BINARY, 0)) {
  $fstats = fstat($handle);
  fseek($handle, 0);
  $contents = fread($handle, $fstats['size']);
} else {
  echo 'Помилка читання файлу';
}
// Закриття файлу та з'єднання
fclose($handle);
ftp_close($conn_id);
?>

<!doctype html>
<html lang="ua">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Відправка файлів по ftp</title>
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <!-- Custom styles for this template -->
  <link href="/assets/css/style.css" rel="stylesheet">
</head>

<body class="d-flex flex-column">
  <nav class="bg-light d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm w-100">
    <div class="d-flex justify-content-between flex-row w-100">
      <a href="/assets/php/index.php"><img style="width: 5rem;" src="https://fsws.ru/img/logo/logo_150.svg"></a>
      <div class="d-flex flex-row">
        <div class="p-2 pe-5">Ви увійшли, як <strong><?php echo $auth_login; ?></strong></div>
        <form method="post" action="/assets/php/session_destroy.php"><input class="btn btn-dark" type="submit" name="submit" value="Вийти"></form>
      </div>
    </div>
  </nav>
  <div>
    <p class="text-danger" onclick="history.back();" style="cursor:pointer;">Назад</p>
  </div>
  </div>
  <div class=" py-3 h-100">
    <main>
      <div class="px-5 row row-cols-1 row-cols-md-1 mb-1 text-center pt-1">
        <div class="col w-auto" style="margin: 0 auto;">
          <div class="card mb-4 rounded-3 shadow-sm">
            <div class="card-header py-3">
              <h4 class="my-0 fw-normal">Вміст файлу "<?php echo $_POST['submit']; ?>"</h4>
            </div>
            <div class="card-body">
              <div>
                <?php echo $contents; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <div id="alertDown"></div>
    <footer class="text-center container pt-4 my-md-5 pt-md-5 border-top">
      <small class="d-block mb-3 text-muted">Всі права захищені. © <?php echo date("Y"); ?>. <a target="_blank" href="https://fsws.ru">Розроблено FSWS</a></small>
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
  <script type="text/javascript" src="/assets/js/alert.js"></script>
</body>
</html>