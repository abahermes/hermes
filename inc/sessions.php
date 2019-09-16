<?php
	session_start();
	if(!empty($_SESSION['ee']['abaini'])){
        // print_r($_SESSION);
      // exit();
		$abaini = $_SESSION['ee']['abaini'];
		// $accsslvl = $_SESSION['userAccessLvl'];
		$abaemail = $_SESSION['ee']['abaemail'];
		$userid = $_SESSION['ee']['userid'];
		$eename = $_SESSION['ee']['name'];
		$eejt = $_SESSION['ee']['jobtitle'];
		$ofc = $_SESSION['ee']['ofc'];
		$pw = $_SESSION['ee']['pw'];

		// if($_SESSION['hasPWChanged'] == 0){
		// 	echo '<script type="text/javascript">alert("Its your first time to logged in to this website and you are required to changed your password immediately!");</script>';
		// 	echo '<script type="text/javascript">window.location="'. CHANGEPASSWORD .'"</script>';
		// 	exit();
		// }
	}
	// print_r($_SESSION);
	// exit();
	if(empty($_SESSION['ee']['abaini'])){
		header("Location: login.php");
		exit();
	}
?>