<!doctype html>
<html lang="ua">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Вхiд</title>

  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <link rel="icon" type="image/png" sizes="32x32" href="https://fsws.ru/img/favicon/favicon-32x32.png">
  <meta name="theme-color" content="#712cf9">

  <!-- Custom styles for this template -->
  <link href="/assets/css/style.css" rel="stylesheet">
  <link rel="manifest" href="/manifest.json">
  <link rel="apple-touch-icon" href="https://fsws.ru/img/favicon/favicon-96x96.png">
  <meta name="apple-mobile-web-app-status-bar" content="#9d4bff">
  <meta name="theme-color" content="#e3e3e3">
  <script src="/assets/js/app.js"></script>
</head>

<body class="text-center">
  <main class="form-signin w-100 m-auto">
    <form method="post" action="/assets/php/auth.php">
      <img class="mb-4" src="https://fsws.ru/img/logo/logo_150.svg" alt="" width="72" height="57">
      <h1 class="h3 mb-3 fw-normal">Будь ласка авторизуйтесь</h1>
      <!--<div class="form-floating">
      <input type="text" name="folder" style="margin-bottom: .5rem;" class="form-control" id="floatingInputFolder" placeholder="JTXrf57sNffwHSuTmyQ">
      <label for="floatingInputFolder">Цільова папка</label>
    </div>-->
      <div class="form-floating">
        <input type="text" name="user" class="form-control" id="floatingInput" placeholder="name@example.com">
        <label for="floatingInput">Логiн</label>
      </div>
      <div class="form-floating">
        <input type="password" name="pass" class="form-control" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Пароль</label>
      </div>

      <input class="w-100 btn btn-lg btn-dark" name="submit" value="Увiйти" type="submit">
      <p class="mt-5 mb-3 text-muted">&copy;
        <?php echo date("Y"); ?>
      </p>
    </form>
  </main>
  <div id="alertDown"></div>
  
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script type="text/javascript" src="/assets/js/alert.js"></script>
  <script>
    $.get('/assets/php/auth.php',
      {},
      function (returnedData) {
        let params = (new URL(document.location)).searchParams;
        if (params.get("param") == 'error') {
          showMassage('Ви помилилися при введенні логіна або пароля');
        } else if (params.get("param") == 'errorKey') {
          showMassage('Невірний ключ пристрою');
        }
      },
      'text'
    );
  </script>
</body>

</html>