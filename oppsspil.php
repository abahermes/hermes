<?php 
  include_once("inc/config.php");
  include_once("inc/global.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.png" type="image/ico" />

    <title>Abacare International Limited</title>

    <?php include_once('inc/bootstrap.php'); ?>

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela!</span></a>
            </div>

            <div class="clearfix"></div>

            <?php include_once('inc/menuprofile.php'); ?>
            <br />
            <?php include_once('inc/sidebar.php'); ?>

        </div>

        <?php include_once('inc/header.php'); ?>

        <?php include_once('views/opportunities/oppsspil.php'); ?>

        <?php include_once('inc/footer.php'); ?>
      </div>
    </div>

    <?php include_once('inc/jquery.php'); ?>

  </body>
</html>