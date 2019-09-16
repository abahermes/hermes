<?php 
  include_once("inc/includes.php");
  include_once("inc/sessions.php");
  include_once("inc/functions.php");
  include_once("api/models/database.php");
  include_once("api/models/leads_model.php");
  include_once("api/models/vcard_model.php");
  include_once("controllers/leads_controller.php");
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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
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

        <?php include_once('views/cdm/leads.php'); ?>

        <?php include_once('inc/footer.php'); ?>
      </div>
    </div>
    <div id="preloader" style="display: none;">Please wait...........
        <div><img src="<?php echo IMAGES; ?>loader.gif" id="preloader_image"></div>
    </div>
    <?php include_once('inc/jquery.php'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
    <script src="//kjur.github.io/jsrsasign/jsrsasign-latest-all-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.min.js"></script>
    <script src="js/graph-js-sdk-web.js"></script>
    <script src="js/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="<?php echo VIEWS;?>cdm/leads.js"></script>
  	<script src="js/multi-step-modal.js"></script>
  	<script>
    	sendEvent = function(sel, step) {
    		var sel_event = new CustomEvent('next.m.' + step, {detail: {step: step}});
    		window.dispatchEvent(sel_event);
    	}
  	</script>
		
  </body>
</html>