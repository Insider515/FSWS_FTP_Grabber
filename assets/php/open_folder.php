<?php
include_once('/assets/env/config.php');
header('Content-Type: text/html; charset=utf-8');
session_start();
if ($_SESSION['auth'] != $auth_login) {
  header("Location: /index.php");
  exit;
} else {
  $conn_id = ftp_connect($resource_path);
  $login_result = ftp_login($conn_id, $login_ftp, $passwd_ftp);
  ftp_pasv($conn_id, true);
  // Отримати поточну url-адресу
  $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  // Парсим url
  $parts = parse_url($url);
  parse_str($parts['query'], $query);
  // Отримуємо директорію
  if (isset($query['folder'])) {
    // Отримати вміст поточної директорії в яку перейшли
    $contents = ftp_rawlist($conn_id, $query['folder']);
  } else {
    // Отримати вміст поточної директорії
    $contents = ftp_rawlist($conn_id, '.');
  }
  //$contents = ftp_rawlist($conn_id, '1111');
  $items = array();
  foreach ($contents as $row) {
    $chunks = preg_split("/\s+/", $row);
    $items[] = array(
      'name'   => $chunks[8],
      'chmod'  => $chunks[0],
      'number' => $chunks[1],
      'user'   => $chunks[2],
      'group'  => $chunks[3],
      'size'   => $chunks[4],
      'month'  => $chunks[5],
      'day'    => $chunks[6],
      'time'   => $chunks[7],
      'type'   => $chunks[0][0] === 'd' ? 'directory' : 'file'
    );
  }
  // Закриття з'єднання
  ftp_close($conn_id);
?>

  <!doctype html>
  <html lang="ru">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Відправка файлів по ftp</title>
    <link rel="icon" type="image/png" sizes="32x32" href="https://fsws.ru/img/favicon/favicon-32x32.png">
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
    <div class=" py-3 h-100">
      <main>
        <div class="row row-cols-1 row-cols-md-1 mb-1 text-center pt-5">
          <div class="col w-auto" style="margin: 0 auto;">
            <div class="card mb-4 rounded-3 shadow-sm">
              <div class="card-header py-3">
                <h4 class="my-0 fw-normal">Відправка файлів по ftp</h4>
              </div>
              <div class="card-body" style="text-align: left;">
                <form enctype="multipart/form-data" method="post" action="/assets/php/send_file.php">
                  <div class="p-2">
                    <label class="form-label" for="">Виберіть файл для надсилання <em>(не більше <?php echo $php_sittings_size; ?> MB)</em></label>
                    <input type="file" required="" class="form-control custom-file-input" id="customFile" name="filename" accept=".txt,.tif">
                    <input class="btn btn-danger mt-3" type="submit" name="submit" value="Відправити" />
                  </div>
                </form>
              </div>
            </div>
            <div class="card mb-4 rounded-3 shadow-sm">
              <div class="card-header py-3">
                <h4 class="my-0 fw-normal">Файли джерела</h4>
              </div>
              <div class="card-body">
                <div style="text-align: left;">
                  <table class="w-100 table">
                    <!--<tr>
                                <th>Перегляд</th>
                                <th>Видалення</th>
                               </tr>-->
                    <?php
                    foreach ($items as $arrays) {
                      if ($arrays['type'] == 'directory') {
                        $folderName = $arrays['name'];
                        echo "<tr><td><form method='post' action='/assets/php/get_file.php'><img src='/assets/img/folder.svg'><input class='file_' type='submit' name='submit' value='$folderName' data-toggle='tooltip' data-placement='top' title='Просмотр'/></form></td>" .
                          "<td><form method='post' style='margin-left: 3rem;' action='/assets/php/remove_file.php'><li class='trash'><input class='file_r' type='submit' name='submit' value='$folderName' data-toggle='tooltip' data-placement='top' title='Видалення'/></li></form></td></tr>";
                      } else {
                        $fileName = $arrays['name'];
                        echo "<tr><td><form method='post' action='/assets/php/get_file.php'><img src='/assets/img/txt.svg'><input class='file_' type='submit' name='submit' value='$fileName' data-toggle='tooltip' data-placement='top' title='Просмотр'/></form></td>" .
                          "<td><form method='post' style='margin-left: 3rem;' action='/assets/php/remove_file.php'><li class='trash'><input class='file_r' type='submit' name='submit' value='$fileName' data-toggle='tooltip' data-placement='top' title='Видалення'/></li></form></td></tr>";
                      }
                    }
                    ?>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
      <div id="alertDown"></div>
      <footer class="text-center pt-4 my-md-5 pt-md-5 border-top">
        <small class="d-block mb-3 text-muted">Всі права захищені. © <?php echo date("Y"); ?>. <a target="_blank" href="https://fsws.ru">Розроблено FSWS</a></small>
      </footer>
    </div>
    <!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script type="text/javascript" src="/assets/js/alert.js"></script>
  </body>

  </html>

<?php }


?>