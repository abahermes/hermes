<?php 
  include_once("inc/includes.php");
  if(isset($_POST['log']) && !empty($_POST['log']) && $_POST['log'] == 1){

    if(isset($_POST['abaini']) && !empty($_POST['abaini']) && isset($_POST['abaemail']) && !empty($_POST['abaemail'])){
      session_start();
      $abaini = $_POST['abaini'];
      // $_SESSION['abaini'] = $abaini;
      $abaemail = $_POST['abaemail'];
      // $_SESSION['abaemail'] = $abaemail;
      $userid = $_POST['userid'];
      // $_SESSION['userid'] = $userid;
      $name = $_POST['eename'];
      // $_SESSION['name'] = $name;
      $jobtitle = $_POST['eejobtitle'];
      // $_SESSION['jobtitle'] = $jobtitle;
      $ofc = $_POST['ofc'];
      $pw = $_POST['pw'];
      $_SESSION['ee'] = array("abaini"=>$abaini,
                              "abaemail"=>$abaemail,
                              "userid"=>$userid,
                              "name"=>$name,
                              "jobtitle"=>$jobtitle,
                              "ofc"=>$ofc,
                              "pw"=>$pw);
      header("Location: dashboardcdm.php");
      // header("Location: cdm.php?id=d2670f1445f99383d36072fccaf9ba1b");
      exit();
    }
    header("Location: login.php");
    exit();
  }
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
	<link href="https://fonts.googleapis.com/css?family=Montserrat|Varela+Round&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/style-for-login.css">
  </head>

  <body class="login">
    <div>

      <div class="login_wrapper">
    		<div class="intro_text">
    		      <h1><img src="images/hermes-logo.png" style="height: 70px;">   hermes</h1>
    			  <h2>Login to start</h2> 
    		</div>
        <div class="animate form login_form">
          <section class="login_content">
            <form method="Post" id="frmLogin" name="frmLogin">
              <span id="divLogin">
                <div class="row">
                  <div class="col-lg-12 col-sm-12 col-xs-12">
                    <input type="text" class="form-control" placeholder="Username (abaini: i.e. pmhe)" required="" id="txtUsername" name="txtUsername" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12 col-sm-12 col-xs-12">
                    <input type="password" class="form-control" placeholder="Password" required="" id="txtPassword" name="txtPassword" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12 col-sm-12 col-xs-12 text-center ">
                    <input type="button" id="btnLogin" class="btn btn-danger" name="btnLogin" value="Login" />
                    <!-- <button class="btn btn-danger" id="btnLogin" name="btnLogin">Log in</button> -->
                  </div>
                  <div class="col-lg-12 col-sm-12 col-xs-12 text-left mt-5">
                    <a class="reset_pass" href="#" onClick="gotoForgotPW();">Lost your password?</a>
                  </div>
                </div>
              </span>
              <span id="divForgotPW" style="display: none;">
                <div class="row">
                  <div class="col-lg-12 col-sm-12 col-xs-12">
                    <input type="text" class="form-control" placeholder="Username (abaini: i.e. pmhe)" required="" id="txtUsername1" name="txtUsername1" />
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-12 col-sm-12 col-xs-12 text-center ">
                    <input type="button" id="btnForgot" class="btn btn-danger" name="btnForgot" value="Send Password" style="width: 100%;" />
                    <!-- <button class="btn btn-danger" id="btnLogin" name="btnLogin">Log in</button> -->
                  </div>
                  <div class="col-lg-12 col-sm-12 col-xs-12 text-left mt-5">
                    <a class="reset_pass" href="#" onClick="return gotoLogin();">Go Back</a>
                  </div>
                </div>
              </span>
              <div class="clearfix"></div>

              <div class="separator">
                <div>
                  <img class="login_logo" src="images/logo.png">
                  <p>©2017 All Rights Reserved. Privacy and Terms</p>
                </div>
              </div>
              <input type="hidden" id="abaini" name="abaini" value="" />
              <input type="hidden" id="abaemail" name="abaemail" value="" />
              <input type="hidden" id="userid" name="userid" value="" />
              <input type="hidden" id="eename" name="eename" value="" />
              <input type="hidden" id="eejobtitle" name="eejobtitle" value="" />
              <input type="hidden" id="ofc" name="ofc" value="" />
              <input type="hidden" id="log" name="log" value="1" />
              <input type="hidden" id="pw" name="pw" value="" />
            </form>
            
          </section>
        </div>
      </div>
    </div>
    <div id="preloader" style="display: none;">Please wait...........
        <div><img src="<?php echo IMAGES; ?>loader.gif" id="preloader_image"></div>
    </div>
    <?php include_once('inc/jquery.php'); ?>
    <script src="<?php echo VIEWS . "home/login.js"; ?>"></script>
  </body>
</html>