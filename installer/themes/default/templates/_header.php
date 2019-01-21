<!DOCTYPE html>
<html lang="<?= locales() ?>">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?= './themes/' . _THEME_  ?>/logo.png">

    <title><?= $title ? $title . ' - ' . _APPNAME_ : _APPNAME_ ?></title>

    <link href="<?= './themes/' . _THEME_  ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= './themes/' . _THEME_  ?>/assets/css/sticky-footer.css" rel="stylesheet">
    <link href="<?= './themes/' . _THEME_  ?>/assets/css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="langSelector">
      <select class="form-control" id="#langselect" style="width: 70px;" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);" >
        <?php foreach (allAvailableLang () as  $key): ?>
            <?php
              if ( isset($_GET['lang']) && $_GET['lang'] == $key ) {
                $s = 'selected';
              } else {
                if ( isset($_SESSION['lang']) && $_SESSION['lang'] == $key ) {
                  $s = 'selected';
                } else {
                  $s = '';
                }
              }
            ?>
            <option <?= $s ?> value="?lang=<?= $key ?>"><?= strtoupper($key) ?></option>
        <?php endforeach ?>
      </select>
    </div>