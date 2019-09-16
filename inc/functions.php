<?php
	// ENCRYPT PASSWORD to MD5
	function generatePassword($pass){
		$salt = "abacareAbvt";
		$md5 = md5($pass . $salt);

		return $md5.":".$salt;
	}

	function genuri($pass){
		$npass = "";
		$salt = "abacare";
		$md5 = md5($pass . $salt);
		$npass = md5($md5);

		return $npass;
	}

	// GENERATE RANDOM STRING
	function generateRandomString($length) {
	    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}

	// HIGHLIGHT TEXT
	function highlightKeywords($text, $keyword) {
		$wordsAry = explode(" ", $keyword);
		$wordsCount = count($wordsAry);
		
		for($i=0;$i<$wordsCount;$i++) {
			$highlighted_text = "<span style='font-weight: bold; color: #000; background: #FFFF00;'>$wordsAry[$i]</span>";
			$text = str_ireplace($wordsAry[$i], $highlighted_text, $text);
		}

		return $text;
	}

	// DATE FORM DDD D MMM YY
	function dtFormat($val){
		return !empty($val) ? date("D j M y", strtotime($val)) : "";
	}
	function formatDate($format,$val){
		return !empty($val) ? date($format, strtotime($val)) : "";	
	}
?>