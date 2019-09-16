<?php 
  include_once("inc/includes.php");
  include_once("inc/sessions.php");
  // print_r($_SESSION);
  // exit();
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

    <?php //include_once('inc/bootstrap.php'); ?>
    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">

    <!-- bootstrap-progressbar -->
    <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
    <link href="css/mystyle.css" rel="stylesheet">
    <link href="css/style-for-dashboard.css" rel="stylesheet">

    <!-- JQuery UI css -->
    <link  href="css/jquery-ui.css" rel="stylesheet">

    <!-- <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script> -->

    <link href="https://fonts.googleapis.com/css?family=Bitter&subset=latin" rel="stylesheet" type="text/css">

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

        <?php include_once('views/cdm/dashboard1.php'); ?>

        <?php include_once('inc/footer.php'); ?>
      </div>
    </div>
    <div id="preloader" style="display: none;">Please wait...........
        <div><img src="<?php echo IMAGES; ?>loader.gif" id="preloader_image"></div>
    </div>
    <?php //include_once('inc/jquery.php'); ?>
    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="vendors/Chart.js/dist/Chart.min.js"></script>


    <!-- gauge.js -->
    <script src="vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="vendors/Flot/jquery.flot.js"></script>
    <script src="vendors/Flot/jquery.flot.pie.js"></script>
    <script src="vendors/Flot/jquery.flot.time.js"></script>
    <script src="vendors/Flot/jquery.flot.stack.js"></script>
    <script src="vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="vendors/moment/min/moment.min.js"></script>
    <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <!--<script src="build/js/custom.min.js"></script>-->
    <script src="build/js/custom.js"></script>

    <!-- <script src="js/vendor/jquery-1.11.2.min.js"></script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/jQuery.highlight.js"></script> -->
    <script src="js/jquery.blockUI.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/config.js"></script>

    <!--multi step modal-->
    <script src="js/multi-step-modal.js"></script>

    <!--<script src="vendors/chartjs-plugin-labels-master/src/chartjs-plugin-labels.js"></script>-->

    <!--
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.5.0"></script>-->
    <!-- ECharts -->
    <script src="vendors/echarts/dist/echarts.min.js"></script>
    
    <script src="<?php echo VIEWS . "cdm/dashboard.js"; ?>"></script>
  </body>
</html>