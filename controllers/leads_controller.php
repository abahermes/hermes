<?php
	if(isset($_POST['leadImport']) && !empty($_POST['leadImport']) && $_POST['leadImport'] == 1){
		// echo '<script type="text/javascript">$(function(){ $.blockUI({ message: $("#preloader_image"), fadeIn: 1000, onBlock: function() { } }); });</script>';

		// $ctcCat = $_POST['chkContactCat'];
		$tmpname = $_FILES['txtFileImport']['name'];
		$tmpFile = $_FILES['txtFileImport']['tmp_name'];
		$fileType = $_FILES['txtFileImport']['type'];
		// $mimes = array('text/csv','text/x-vcard','application/vnd.ms-excel');

		// print_r($_FILES);
	 //    exit();

		if (empty($tmpFile) && $tmpFile == '') {
			echo '<script type="text/javascript">alert("No CSV/VCF file has selected! Please browse a correct csv/vcf file.");</script>';
			echo '<script type="text/javascript">window.location="leads.php";</script>';
			exit();
		}

		$uploaddir = 'temp/';
		$uploadfile = $uploaddir . $_FILES['txtFileImport']['name'];

		if (!move_uploaded_file($tmpFile, $uploadfile)) {
		    echo "Failed to upload csv/vcf file!\n Please contact the web administrator.";
		    exit();
		}

		switch($fileType){
	    	case "application/vnd.ms-excel":
	    			goto csv;
	    		break;
	    	case "text/x-vcard":
	    			goto vcf;
	    		break;
	    	default:
	    			goto exitme;
	    		break;
	    }
		// echo $tmpFile . '<br />';
		// echo $uploadfile . '<br />';

		csv: // if csv file is imported
		// echo 'xls';
		// exit();
		$rows = array();
		$file_handle = fopen($uploadfile, 'r');
	    while (!feof($file_handle) ) {
	        $rows[] = fgetcsv($file_handle, 1000);
	    }
	    // print_r($rows);
	    // exit();
	    fclose($file_handle);
	    unlink($uploadfile);

	    $data = array();
	    for($a=0;$a<count($rows[0]);$a++){
	    	$fields[] = str_replace([" ","/","(",")","'",'"',"-"],"",strtolower($rows[0][$a])) . '.' . $a;
	    }
	    // print_r($rows);
	    // exit();
	    $row = array();
	    for($i=1;$i<count($rows);$i++){
	    	$cnt = 0;
	    	for($a=0;$a<count($rows[$i]);$a++){
		    	$row = $rows[$i];
		    	foreach($fields as $val){

			    	$val1 = explode(".",$val);
			    	$fldnme = $val1[0];
			    	$colno = $val1[1];

			    	if($colno == $a){
			    		$rec[$fldnme] = $row[$a];
			    	}
			    }
	    		$cnt++;
			}
			$data[] = $rec;
	    }

	    // print_r($data);
	    // exit();
	    $abaUser = $_POST['txtuserid'];
	    $rows = array();
	    for($i=0;$i<count($data);$i++){
	    	$row['firstname'] = $data[$i]['firstname'];
	    	$row['lastname'] = strtoupper($data[$i]['lastname']);
	    	$row['middlename'] = $data[$i]['middlename'];
	    	$row['chinesename'] = isset($data[$i]['suffix']) ? $data[$i]['suffix'] : "";
	    	$row['birthdate'] = isset($data[$i]['birthday']) ? formatDate("Y-m-d",$data[$i]['birthday']) : "1900-01-01";
	    	$row['gender'] = isset($data[$i]['gender']) ? $data[$i]['gender'] : "";
	    	$row['companyname'] = $data[$i]['company'];
	    	$row['jobtitle'] = $data[$i]['jobtitle'];
	    	$row['emailaddress'] = isset($data[$i]['emailaddress']) ? $data[$i]['emailaddress'] : "";
	    	$row['homephoneno'] = isset($data[$i]['homephone']) ? $data[$i]['homephone'] : "";
	    	$row['mobilephoneno'] = isset($data[$i]['mobilephone']) ? $data[$i]['mobilephone'] : "";
	    	$row['businessphoneno'] = isset($data[$i]['businessphone']) ? $data[$i]['businessphone'] : "";
	    	$row['street'] = isset($data[$i]['businessstreet']) ? $data[$i]['businessstreet'] : "";
	    	$row['city'] = isset($data[$i]['businesscity']) ? $data[$i]['businesscity'] : "";
	    	$row['state'] = isset($data[$i]['businessstate']) ? $data[$i]['businessstate'] : "";
	    	$row['countryorregion'] = isset($data[$i]['businesscountryregion']) ? $data[$i]['businesscountryregion'] : "";
	    	$row['account'] = isset($data[$i]['account']) ? $data[$i]['account'] : "";

	    	$row['userid'] = $abaUser;
	    	$row['today'] = TODAY;

	    	array_push($rows, $row);
	    }
	    // print_r($rows);
	    // exit();
	    $leads = new LeadsModel;
	    $cnt = ($leads->getTotalLeads($abaUser) + 1);
	    // foreach($rows as $val){

	    // print_r($cnt);
	    // exit();
	    
	   	$res = array();
	   	$leadsqls = "";
	   	$leads = new LeadsModel;
	   	// echo count($rows) . '<br /><br />';
	    for($i=0;$i<count($rows);$i++){
	    	$row = array();
	    	$row = $rows[$i];
	    	$row['userid'] = $abaUser;
	    	$email = "";
	    	if( !empty($rows[$i]['emailaddress']) ){
	    		if( strstr($rows[$i]['emailaddress'],"@") ){
	    			$email = $rows[$i]['emailaddress'];
	    		}else{
	    			$email = $rows[$i]['emailaddress'];
			    	$email = explode("-", $email);
			    	$email = $email[count($email) - 1];
			    	$email = $email."@abacare.com";
	    		}
	    	}else{
	    		if( !empty($rows[$i]['account']) ){
	    			$email = $rows[$i]['account'];
	    		}
	    	}
	    	
	    	$row['gender'] = $rows[$i]['gender'] != 'm' || $rows[$i]['gender'] != 'f' ? "" : $rows[$i]['gender'];
	    	$row['eaddr'] = $email;
	    	$row['birthdate'] = $rows[$i]['birthdate'] == "" || $rows[$i]['birthdate'] == NULL ? NULL : formatDate("Y-m-d",$rows[$i]['birthdate']);
	    	$row['cnt'] = $cnt;
	    	
	    	$res = "";
	    	$res = $leads->saveLead($row);
	    	// echo '<script type="text/javascript">alert("'.$i.'");</script>';
	    	$leadsqls .= $res;
	    	if($i%15==0){
	    		// echo '<script type="text/javascript">alert("exec");</script>';
	    		// echo $leadsqls . '<br /><br />';
	    		$res = $leads->execLeadsMultiQuery($leadsqls);
	    		// print_r($res) . '<br /><br />';
	    		$leads->closeDB();

	    		$leads = new LeadsModel;
	    		$leadsqls = "";
	    	}

	    	if($i == (count($rows) - 1)){
	    		// echo $leadsqls . '<br /><br />';
	    		$res = $leads->execLeadsMultiQuery($leadsqls);
	    		// print_r($res) . '<br /><br />';
	    		$leads->closeDB();
	    	}
	    	// $leads->closeDB();
	    	$cnt++;
	    }
	    goto exitme;
	    // echo '<script type="text/javascript">$(function(){ $.unblockUI(); });</script>';
	    // echo $leadsqls;
	    // $res = $leads->execLeadsMultiQuery($leadsqls);
	    // print_r($res);
	    // exit();
	    // -- end csv

	    vcf: // if vcf is imported
	 //    echo 'vcf';
		// exit();
	    $vCard = new vCard(
			$uploadfile, // Path to vCard file
			false, // Raw vCard text, can be used instead of a file
			array( // Option array
				// This lets you get single values for elements that could contain multiple values but have only one value.
				//	This defaults to false so every value that could have multiple values is returned as array.
				'Collapse' => false
			)
		);

		// array_push($abaUser, $vCard);

		if (count($vCard) == 0)
		{
			throw new Exception('vCard test: empty vCard!');
		}
		// if the file contains a single vCard, it is accessible directly.
		elseif (count($vCard) == 1)
		{
			OutputvCard($vCard,$userid);
		}
		// if the file contains multiple vCards, they are accessible as elements of an array
		else
		{
			foreach ($vCard as $Index => $vCardPart)
			{
				OutputvCard($vCardPart,$userid);
			}
		}
		unlink($uploadfile);
	    // -- end vcf

	    exitme: // exit
	    // exit();
	    echo '<script type="text/javascript">alert("Leads successfully imported.");</script>';
	    // exit();
        echo '<script type="text/javascript">window.location="leads.php";</script>';
	    exit();
	}
?>