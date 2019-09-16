<?php 
  include_once("inc/includes.php");
  include_once("inc/sessions.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo FAVICO; ?>" type="image/ico" />

    <title><?php echo TITLE; ?></title>

    <?php include_once('inc/bootstrap.php'); ?>

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <?php include_once('inc/logo.php'); ?>

            <?php include_once('inc/menuprofile.php'); ?>
            <br />
            <?php include_once('inc/sidebar.php'); ?>

        </div>

        <?php include_once('inc/header.php'); ?>

        <?php include_once('views/cdm/tasks.php'); ?>

        <?php include_once('inc/footer.php'); ?>
      </div>
    </div>
    <div id="preloader" style="display: none;">Please wait...........
        <div><img src="<?php echo IMAGES; ?>loader.gif" id="preloader_image"></div>
    </div>
    <?php include_once('inc/jquery.php'); ?>
    <script src="<?php echo VIEWS . "cdm/tasks.js"; ?>"></script>
  </body>
</html>