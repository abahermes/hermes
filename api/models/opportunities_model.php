<?php
	// include_once('auditlogs.php');
	class OpportunitiesModel extends Database{

		private $db = "";
		private $cn = "";

		function __construct(){
			$this->db = new Database();
			$this->cn = $this->db->connect();
		}

		public function saveOpps($data){
			$res = array();
			$actdata = array();
			$res['err'] = 0;
			$srwtargetdtlbl = "";
			$srwtargetdtval = "";
			$premiumlbl = "";
			$premiumval = "";
			$comratelbl = "";
			$comrateval = "";
			$polissueddtlbl = "";
			$polissueddtval = "";
			$signeddatelbl = "";
			$signeddateval = "";
			$lostdatelbl = "";
			$lostdateval = "";
			$sesid = $data['sesid'];
			$userid = $data['userid'];
			$abauser = $data['abaini'];
			$acctid = $data['acctid'];
			$oppsid = $acctid ."-O-". formatDate("ymdhis",TODAY);
			$prodtype = $data['prodtype'];
			
			if($data['srwtargetdt'] != ""){
				$srwtargetdt = formatDate("Y-m-d",$data['srwtargetdt']);
				$srwtargetdtlbl = ",srwtargetdate";
				$srwtargetdtval = ",'$srwtargetdt'";
			}
			
			$potential = $data['potential'];
			$ccy = $data['ccy'];

			if($data['premium'] != ""){
				$premium = $data['premium'];
				$premiumlbl = ",premium";
				$premiumval = ",'$premium'";
			}
			if($data['comrate'] != ""){
				$comrate = $data['comrate'];
				$comratelbl = ",comrate";
				$comrateval = ",'$comrate'";
			}
			if($data['polissueddate'] != ""){
				$polissueddt = formatDate("Y-m-d",$data['polissueddate']);
				$polissueddtlbl = ",polissueddate";
				$polissueddtval = ",'$polissueddt'";
			}
			if($data['signeddate'] !=""){
				$signeddate = formatDate("Y-m-d",$data['signeddate']);
				$signeddatelbl = ",signeddate";
				$signeddateval = ",'$signeddate'";
			}
			if($data['lostdate'] != ""){
				$lostdate = formatDate("Y-m-d",$data['lostdate']);
				$lostdatelbl = ",lostdate";
				$lostdateval = ",'$lostdate'";
			}
			$polnum = $data['polnumber'];
			$status = $data['status'];
			$supplier = $data['supplier'];
			$remarks = $data['remarks'];
			$premhkd = $data['premhkd'];
			$abarevhkd = $data['abarevhkd'];
			$assignedto = $data['assignedto'];
			$cltprost = $data['cltprost'];
			$prodtypedesc = $data['prodtypedesc'];
			$shared = $data['shared'] == "" ? "" : $data['shared'];
			$today = TODAY;

			$sql = "INSERT INTO " . CDMOPPS . " (oppsid,acctid,producttype $srwtargetdtlbl ,potential,ccy $premiumlbl $comratelbl,premiumhkd,abarevhkd,supplier,remarks,oppsstatus,assignedto,createdby,createddate,userid $signeddatelbl $polissueddtlbl,polnumber $lostdatelbl, sharedwith) 
					VALUES('$oppsid','$acctid','$prodtype' $srwtargetdtval ,'$potential','$ccy' $premiumval $comrateval,'$premhkd','$abarevhkd','$supplier','$remarks','$status','$userid','$userid','$today','$userid' $signeddateval $polissueddtval,'$polnum' $lostdateval,'$shared') ";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func saveOpps()! " . $this->cn->error;
				goto exitme;
			}

			switch ($status){
				case 'p':
					$statusdisplay = "POTENTIAL";
					break;
				case 'q':
					$statusdisplay = "QOUTE GIVEN / IN DISCUSSION";
					break;
				case 'c':
					$statusdisplay = "CLOSING STAGE";
					break;
				case 's':
					$statusdisplay = "SIGNED";
					break;
				case 'sp':
					$statusdisplay = "SIGNED AND POLICY ISSUED";
					break;
				case 'l':
					$statusdisplay = "LOST";
					break;
				case 'x':
					$statusdisplay = "CANCELLED";
					break;
				default:
					break;
			}

			// save activity
			$actdata['type'] = "";
			if($status == 'l'){
				$actdata['details'] = 'Opportunity '. $prodtypedesc .' created for <a href="cdm.php?id='. $sesid .'">'. $cltprost .'</a>.Status ' . $statusdisplay . '. Reason: ' . $remarks ;
			}
			else {
				if($remarks == ""){
					$actdata['details'] = 'Opportunity '. $prodtypedesc .' created for <a href="cdm.php?id='. $sesid .'">'. $cltprost .'</a>. Status ' . $statusdisplay ;
				}
				else {
					$actdata['details'] = 'Opportunity '. $prodtypedesc .' created for <a href="cdm.php?id='. $sesid .'">'. $cltprost .'</a>. Status ' . $statusdisplay . '. Remarks: ' . $remarks ;
				}
			}
			
			$actdata['assignedto'] = $assignedto;
			$actdata['abauser'] = $abauser;
			$actdata['userid'] = $userid;
			$actdata['acctid'] = $acctid;

			$acts = new ActivitiesModel;
			$acts->saveActivity($actdata);

			exitme:
			return $res;
		}

		public function updateOpps($data){
			$res = array();
			$actdata = array();
			$res['err'] = 0;
			$srwtargetdtval = "";
			$premiumval = "";
			$comrateval = "";
			$polissueddateval = "";
			$signeddateval ="";
			$lostdateval = "";
			$oppsid = $data['oppsid'];
			$userid = $data['userid'];
			$sesid = $data['sesid'];
			$abauser = $data['abaini'];
			$acctid = $data['acctid'];
			$prodtype = $data['prodtype'];
			if($data['srwtargetdt'] != ""){
				$srwtargetdt = $data['srwtargetdt'];
				$srwtargetdtval = ", srwtargetdate = '$srwtargetdt'";
			}
			
			$potential = $data['potential'];
			$ccy = $data['ccy'];
			if($data['premium'] != ""){
				$premium = $data['premium'];
				$premiumval = ", premium = '$premium'";
			}
			if($data['comrate'] != ""){
				$comrate = $data['comrate'];
				$comrateval = ", comrate = '$comrate'";
			}
			if($data['polissueddt'] != ""){
				$polissueddate = $data['polissueddt'];
				$polissueddateval = ", polissueddate = '$polissueddate'";
			}
			if($data['signeddate'] != ""){
				$signeddate = $data['signeddate'];
				$signeddateval = ", signeddate = '$signeddate'";
			}
			if($data['lostdate'] != ""){
				$lostdate = $data['lostdate'];
				$lostdateval = ", lostdate = '$lostdate'";
			}
			$polnum = $data['polnumber'];
			$status = $data['status'];
			$supplier = $data['supplier'];
			$remarks = $data['remarks'];
			$premhkd = $data['premhkd'];
			$abarevhkd = $data['abarevhkd'];
			$assignedto = $data['assignedto'];
			$cltprost = $data['cltprost'];
			$prodtypedesc = $data['prodtypedesc'];
			$shared = $data['shared'] == "" ? "" : $data['shared'];
			// $polissueddate = $data['polissueddt'];
			$today = TODAY;

			$sql = "UPDATE " . CDMOPPS . " SET producttype = '$prodtype' $srwtargetdtval , potential = '$potential', 
						ccy = '$ccy' $premiumval $comrateval, supplier = '$supplier', remarks = '$remarks', oppsstatus = '$status', 
						modifiedby = '$userid', modifieddate = '$today', premiumhkd = '$premhkd', abarevhkd = '$abarevhkd' $polissueddateval, polnumber = '$polnum' $signeddateval $lostdateval , sharedwith = '$shared' 
					WHERE " . CDMOPPS . ".oppsid = '$oppsid' ";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func updateOpps()! " . $this->cn->error;
				goto exitme;
			}

			switch ($status){
				case 'p':
					$statusdisplay = "POTENTIAL";
					break;
				case 'q':
					$statusdisplay = "QOUTE GIVEN / IN DISCUSSION";
					break;
				case 'c':
					$statusdisplay = "CLOSING STAGE";
					break;
				case 's':
					$statusdisplay = "SIGNED";
					break;
				case 'sp':
					$statusdisplay = "SIGNED AND POLICY ISSUED";
					break;
				case 'l':
					$statusdisplay = "LOST";
					break;
				case 'x':
					$statusdisplay = "CANCELLED";
					break;
				default:
					break;
			}
			// save activity
			$actdata['type'] = "";
			if($status == 'l'){
				$actdata['details'] = 'Opportunity '. $prodtypedesc .' updated for <a href="cdm.php?id='. $sesid .'">'. $cltprost .'</a>.Status ' . $statusdisplay . '. Reason: ' . $remarks ;
			}
			else if($status == 's'){
				$actdata['details'] = 'Opportunity '. $prodtypedesc .' updated for <a href="cdm.php?id='. $sesid .'">'. $cltprost .'</a>.Status ' . $statusdisplay . ' with Premium in HKD $ '. $premhkd . ' and Aba Rev in HKD ' .$abarevhkd;
			}
			else if($status == 'sp'){
				if($polnum == ""){
					$actdata['details'] = 'Opportunity '. $prodtypedesc .' updated for <a href="cdm.php?id='. $sesid .'">'. $cltprost .'</a>.Status ' . $statusdisplay . '. Policy Issued on ' . $polissueddate ;
				}
				else {
					$actdata['details'] = 'Opportunity '. $prodtypedesc .' updated for <a href="cdm.php?id='. $sesid .'">'. $cltprost .'</a>.Status ' . $statusdisplay . '. Policy Issued on ' . $polissueddate . ' with Policy No. ' . $polnum ;
				}
			}
			else {
				if($remarks == ""){
					$actdata['details'] = 'Opportunity '. $prodtypedesc .' updated for <a href="cdm.php?id='. $sesid .'">'. $cltprost .'</a>. Status ' . $statusdisplay ;
				}
				else {
					$actdata['details'] = 'Opportunity '. $prodtypedesc .' updated for <a href="cdm.php?id='. $sesid .'">'. $cltprost .'</a>. Status ' . $statusdisplay . '. Remarks: ' . $remarks ;
				}
			}
			$actdata['assignedto'] = $assignedto;
			$actdata['abauser'] = $abauser;
			$actdata['userid'] = $userid;
			$actdata['acctid'] = $acctid;

			$acts = new ActivitiesModel;
			$acts->saveActivity($actdata);
			exitme:
			return $res;
		}

		public function getPendingOpps($acctid){
			$res = array();
			$sql = "SELECT " . CDMOPPS . ".*
						,DATE_FORMAT(" . CDMOPPS . ".srwtargetdate,'%a %d %b %y') AS srwtargetdt 
						,DATE_FORMAT(" . CDMOPPS . ".polissueddate,'%a %d %b %y') AS polissueddt 
						,DATE_FORMAT(" . CDMOPPS . ".signeddate,'%a %d %b %y') AS signeddt 
						,DATE_FORMAT(" . CDMOPPS . ".lostdate,'%a %d %b %y') AS lostdt 
						,a.dddescription AS prodtypedesc 
						,b.abaini as sharedabaini 
					FROM " . CDMOPPS . " 
					LEFT JOIN ". DROPDOWNSMST ." a
						ON a.ddid = " . CDMOPPS . ".producttype AND a.dddisplay = 'cdmproducttypes' 
					LEFT JOIN ". ABAPEOPLESMST ." b 
						ON b.userid = " . CDMOPPS . ".sharedwith 
					WHERE " . CDMOPPS . ".acctid = '$acctid' AND " . CDMOPPS . ".oppsstatus NOT IN('s','l','x','sp') 
					ORDER BY " . CDMOPPS . ".srwtargetdate";
			$qry = $this->cn->query($sql);
			$rows = array();
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;

			return $res;
		}

		public function getSignedOpps($acctid){
			$res = array();
			$sql = "SELECT " . CDMOPPS . ".*
						,DATE_FORMAT(" . CDMOPPS . ".srwtargetdate,'%a %d %b %y') AS srwtargetdt 
						,DATE_FORMAT(" . CDMOPPS . ".polissueddate,'%a %d %b %y') AS polissueddt 
						,DATE_FORMAT(" . CDMOPPS . ".signeddate,'%a %d %b %y') AS signeddt 
						,DATE_FORMAT(" . CDMOPPS . ".lostdate,'%a %d %b %y') AS lostdt 
						,a.dddescription AS prodtypedesc 
						,b.abaini as sharedabaini 
					FROM " . CDMOPPS . " 
					LEFT JOIN ". DROPDOWNSMST ." a
						ON a.ddid = " . CDMOPPS . ".producttype AND a.dddisplay = 'cdmproducttypes'
					LEFT JOIN ". ABAPEOPLESMST ." b 
						ON b.userid = " . CDMOPPS . ".sharedwith
					WHERE " . CDMOPPS . ".acctid = '$acctid' AND " . CDMOPPS . ".oppsstatus IN ('s', 'sp')
					ORDER BY " . CDMOPPS . ".srwtargetdate";
			$qry = $this->cn->query($sql);
			$rows = array();
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;

			return $res;
		}

		public function getOpps($oppsid){
			$res = array();
			$sql = "SELECT " . CDMOPPS . ".*
						,DATE_FORMAT(" . CDMOPPS . ".srwtargetdate,'%a %d %b %y') as srwtargetdt 
						,DATE_FORMAT(" . CDMOPPS . ".polissueddate,'%a %d %b %y') AS polissueddt 
						,DATE_FORMAT(" . CDMOPPS . ".signeddate,'%a %d %b %y') AS signeddt 
						,DATE_FORMAT(" . CDMOPPS . ".lostdate,'%a %d %b %y') AS lostdt 
					FROM " . CDMOPPS . " 
					WHERE " . CDMOPPS . ".oppsid = '$oppsid' ";
			$qry = $this->cn->query($sql);
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;

			return $res;
		}

		public function getAllOpportunities($userid){
			$res = array();
			$sql = "SELECT " . CDMOPPS . ".*
						,DATE_FORMAT(" . CDMOPPS . ".srwtargetdate,'%a %d %b %y') as srwtargetdt 
						,DATE_FORMAT(" . CDMOPPS . ".polissueddate,'%a %d %b %y') AS polissueddt 
						,DATE_FORMAT(" . CDMOPPS . ".signeddate,'%a %d %b %y') AS signeddt 
						,DATE_FORMAT(" . CDMOPPS . ".lostdate,'%a %d %b %y') AS lostdt 
						,b.firstname
						,b.lastname
						,b.companyname
						,a.acctid
						,a.sesid AS uid
						,CONCAT(d.fname,' ', d.lname) AS sharedabaini 
						,(CASE WHEN a.businesstype = 'c' THEN 'Corporate' ELSE 'Individual' END) AS bustype
						,c.dddescription AS prodtypedesc
						,(CASE WHEN " . CDMOPPS . ".oppsstatus = 'p' THEN 'Potential' 
							WHEN " . CDMOPPS . ".oppsstatus = 'q' THEN 'Quote given/in discussion' 
							WHEN " . CDMOPPS . ".oppsstatus = 'c' THEN 'Closing stage' 
							WHEN " . CDMOPPS . ".oppsstatus = 's' THEN 'Signed' 
							WHEN " . CDMOPPS . ".oppsstatus = 'sp' THEN 'Signed and Policy Issued' 
							WHEN " . CDMOPPS . ".oppsstatus = 'l' THEN 'Lost' 
							WHEN " . CDMOPPS . ".oppsstatus = 'x' THEN 'Cancel' ELSE '' END) AS statusdesc
					FROM " . CDMOPPS . " 
					LEFT JOIN ". CDMACCOUNTS ." a 
						ON a.acctid = " . CDMOPPS . ".acctid
					LEFT JOIN ". CDMCONTACTS ." b 
						ON b.ctcid = a.ctcid 
					LEFT JOIN ". DROPDOWNSMST ." c
						ON c.ddid = " . CDMOPPS . ".producttype AND c.dddisplay = 'cdmproducttypes'
					LEFT JOIN ". ABAPEOPLESMST ." d 
						ON d.userid = " . CDMOPPS . ".sharedwith 
					WHERE " . CDMOPPS . ".userid = '$userid' OR " . CDMOPPS . ".sharedwith = '$userid' 
					ORDER BY " . CDMOPPS . ".createddate DESC";
			$qry = $this->cn->query($sql);
			$rows = array();
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;
			
			return $res;
		}

		public function closeDB(){
			$this->cn->close();
		}

		public function getSortedOpps($data){
			$res = array();
			$rows = array();

			$userid = $data['userid'];
			$sortby = $data['sortby'];
			$sortin = $data['sortin'];

			switch ($sortby) {
				case 'lname':
					$fieldname = "b.lastname $sortin";
					break;
				case 'fname':
					$fieldname = "b.firstname $sortin";
					break;
				case 'companyname':
					$fieldname = "b.companyname $sortin";
					break;
				case 'ic':
					$fieldname = "bustype $sortin";
					break;
				case 'prod':
					$fieldname = "prodtypedesc $sortin";
					break;
				case 'startrwdt':
					$fieldname = "srwtargetdt $sortin";
					break;
				case 'prem':
					$fieldname = CDMOPPS .".premium $sortin";
					break;
				case 'stat':
					$fieldname = "statusdesc $sortin";
					break;
				default:
					break;
			}

			$sql = "SELECT " . CDMOPPS . ".*
						,DATE_FORMAT(" . CDMOPPS . ".srwtargetdate,'%a %d %b %y') as srwtargetdt 
						,DATE_FORMAT(" . CDMOPPS . ".polissueddate,'%a %d %b %y') AS polissueddt 
						,DATE_FORMAT(" . CDMOPPS . ".signeddate,'%a %d %b %y') AS signeddt 
						,b.firstname
						,b.lastname
						,b.companyname
						,a.acctid
						,a.sesid AS uid
						,(CASE WHEN a.businesstype = 'c' THEN 'Corporate' ELSE 'Individual' END) AS bustype
						,c.dddescription AS prodtypedesc
						,CONCAT(d.fname,' ', d.lname) AS sharedabaini 
						,(CASE WHEN " . CDMOPPS . ".oppsstatus = 'p' THEN 'Potential' 
							WHEN " . CDMOPPS . ".oppsstatus = 'q' THEN 'Quote given/in discussion' 
							WHEN " . CDMOPPS . ".oppsstatus = 'c' THEN 'Closing stage' 
							WHEN " . CDMOPPS . ".oppsstatus = 's' THEN 'Signed / Paid / Issued' 
							WHEN " . CDMOPPS . ".oppsstatus = 'l' THEN 'Lost' 
							WHEN " . CDMOPPS . ".oppsstatus = 'x' THEN 'Cancel' ELSE '' END) AS statusdesc
					FROM " . CDMOPPS . " 
					LEFT JOIN ". CDMACCOUNTS ." a 
						ON a.acctid = " . CDMOPPS . ".acctid
					LEFT JOIN ". CDMCONTACTS ." b 
						ON b.ctcid = a.ctcid 
					LEFT JOIN ". DROPDOWNSMST ." c
						ON c.ddid = " . CDMOPPS . ".producttype AND c.dddisplay = 'cdmproducttypes' 
					LEFT JOIN ". ABAPEOPLESMST ." d 
						ON d.userid = " . CDMOPPS . ".sharedwith 
					WHERE " . CDMOPPS . ".userid = '$userid' OR " . CDMOPPS . ".sharedwith = '$userid' 
					ORDER BY $fieldname";
			$qry = $this->cn->query($sql);
			$rows = array();
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;
			
			return $res;
		}

		function searchCltPros($data){
			$res = array();
			$rows = array();

			$searchtext=$data['searchtext'];
			$userid=$data['userid'];

			if(!empty($searchtext)){
				$sql = "SELECT " . CDMOPPS . ".*
						,DATE_FORMAT(" . CDMOPPS . ".srwtargetdate,'%a %d %b %y') as srwtargetdt 
						,DATE_FORMAT(" . CDMOPPS . ".polissueddate,'%a %d %b %y') AS polissueddt 
						,DATE_FORMAT(" . CDMOPPS . ".signeddate,'%a %d %b %y') AS signeddt 
						,DATE_FORMAT(" . CDMOPPS . ".lostdate,'%a %d %b %y') AS lostdt 
						,b.firstname
						,b.lastname
						,b.companyname
						,a.acctid
						,a.sesid AS uid
						,(CASE WHEN a.businesstype = 'c' THEN 'Corporate' ELSE 'Individual' END) AS bustype
						,c.dddescription AS prodtypedesc
						,CONCAT(d.fname,' ', d.lname) AS sharedabaini 
						,(CASE WHEN " . CDMOPPS . ".oppsstatus = 'p' THEN 'Potential' 
							WHEN " . CDMOPPS . ".oppsstatus = 'q' THEN 'Quote given/in discussion' 
							WHEN " . CDMOPPS . ".oppsstatus = 'c' THEN 'Closing stage' 
							WHEN " . CDMOPPS . ".oppsstatus = 's' THEN 'Signed / Paid / Issued' 
							WHEN " . CDMOPPS . ".oppsstatus = 'l' THEN 'Lost' 
							WHEN " . CDMOPPS . ".oppsstatus = 'x' THEN 'Cancel' ELSE '' END) AS statusdesc
					FROM " . CDMOPPS . " 
					LEFT JOIN ". CDMACCOUNTS ." a 
						ON a.acctid = " . CDMOPPS . ".acctid
					LEFT JOIN ". CDMCONTACTS ." b 
						ON b.ctcid = a.ctcid 
					LEFT JOIN ". DROPDOWNSMST ." c
						ON c.ddid = " . CDMOPPS . ".producttype AND c.dddisplay = 'cdmproducttypes' 
					LEFT JOIN ". ABAPEOPLESMST ." d 
						ON d.userid = " . CDMOPPS . ".sharedwith 
					WHERE " . CDMOPPS . ".userid = '$userid' AND b.lastname LIKE '%$searchtext%'";
					// ORDER BY " . CDMOPPS . ".premium DESC";
				$sql .= " UNION ";
				$sql .= "SELECT " . CDMOPPS . ".*
					,DATE_FORMAT(" . CDMOPPS . ".srwtargetdate,'%a %d %b %y') as srwtargetdt 
					,DATE_FORMAT(" . CDMOPPS . ".polissueddate,'%a %d %b %y') AS polissueddt 
					,DATE_FORMAT(" . CDMOPPS . ".signeddate,'%a %d %b %y') AS signeddt 
					,DATE_FORMAT(" . CDMOPPS . ".lostdate,'%a %d %b %y') AS lostdt 
					,b.firstname
					,b.lastname
					,b.companyname
					,a.acctid
					,a.sesid AS uid
					,(CASE WHEN a.businesstype = 'c' THEN 'Corporate' ELSE 'Individual' END) AS bustype
					,c.dddescription AS prodtypedesc 
					,CONCAT(d.fname,' ', d.lname) AS sharedabaini  
					,(CASE WHEN " . CDMOPPS . ".oppsstatus = 'p' THEN 'Potential' 
						WHEN " . CDMOPPS . ".oppsstatus = 'q' THEN 'Quote given/in discussion' 
						WHEN " . CDMOPPS . ".oppsstatus = 'c' THEN 'Closing stage' 
						WHEN " . CDMOPPS . ".oppsstatus = 's' THEN 'Signed / Paid / Issued' 
						WHEN " . CDMOPPS . ".oppsstatus = 'l' THEN 'Lost' 
						WHEN " . CDMOPPS . ".oppsstatus = 'x' THEN 'Cancel' ELSE '' END) AS statusdesc
					FROM " . CDMOPPS . " 
					LEFT JOIN ". CDMACCOUNTS ." a 
						ON a.acctid = " . CDMOPPS . ".acctid
					LEFT JOIN ". CDMCONTACTS ." b 
						ON b.ctcid = a.ctcid 
					LEFT JOIN ". DROPDOWNSMST ." c
						ON c.ddid = " . CDMOPPS . ".producttype AND c.dddisplay = 'cdmproducttypes' 
					LEFT JOIN ". ABAPEOPLESMST ." d 
						ON d.userid = " . CDMOPPS . ".sharedwith 
					WHERE " . CDMOPPS . ".userid = '$userid' AND b.firstname LIKE '%$searchtext%'";
					// ORDER BY " . CDMOPPS . ".premium DESC";
				$sql .= " UNION ";
				$sql .= "SELECT " . CDMOPPS . ".*
					,DATE_FORMAT(" . CDMOPPS . ".srwtargetdate,'%a %d %b %y') as srwtargetdt 
					,DATE_FORMAT(" . CDMOPPS . ".polissueddate,'%a %d %b %y') AS polissueddt 
					,DATE_FORMAT(" . CDMOPPS . ".signeddate,'%a %d %b %y') AS signeddt 
					,DATE_FORMAT(" . CDMOPPS . ".lostdate,'%a %d %b %y') AS lostdt 
					,b.firstname
					,b.lastname
					,b.companyname
					,a.acctid
					,a.sesid AS uid
					,(CASE WHEN a.businesstype = 'c' THEN 'Corporate' ELSE 'Individual' END) AS bustype
					,c.dddescription AS prodtypedesc 
					,CONCAT(d.fname,' ', d.lname) AS sharedabaini 
					,(CASE WHEN " . CDMOPPS . ".oppsstatus = 'p' THEN 'Potential' 
						WHEN " . CDMOPPS . ".oppsstatus = 'q' THEN 'Quote given/in discussion' 
						WHEN " . CDMOPPS . ".oppsstatus = 'c' THEN 'Closing stage' 
						WHEN " . CDMOPPS . ".oppsstatus = 's' THEN 'Signed / Paid / Issued' 
						WHEN " . CDMOPPS . ".oppsstatus = 'l' THEN 'Lost' 
						WHEN " . CDMOPPS . ".oppsstatus = 'x' THEN 'Cancel' ELSE '' END) AS statusdesc
					FROM " . CDMOPPS . " 
					LEFT JOIN ". CDMACCOUNTS ." a 
						ON a.acctid = " . CDMOPPS . ".acctid
					LEFT JOIN ". CDMCONTACTS ." b 
						ON b.ctcid = a.ctcid 
					LEFT JOIN ". DROPDOWNSMST ." c
						ON c.ddid = " . CDMOPPS . ".producttype AND c.dddisplay = 'cdmproducttypes' 
					LEFT JOIN ". ABAPEOPLESMST ." d 
						ON d.userid = " . CDMOPPS . ".sharedwith 
					WHERE " . CDMOPPS . ".userid = '$userid' AND b.companyname LIKE '%$searchtext%'";
					// ORDER BY " . CDMOPPS . ".premium DESC";
			} else {
				$sql = "SELECT " . CDMOPPS . ".*
						,DATE_FORMAT(" . CDMOPPS . ".srwtargetdate,'%a %d %b %y') as srwtargetdt 
						,DATE_FORMAT(" . CDMOPPS . ".polissueddate,'%a %d %b %y') AS polissueddt 
						,DATE_FORMAT(" . CDMOPPS . ".signeddate,'%a %d %b %y') AS signeddt 
						,DATE_FORMAT(" . CDMOPPS . ".lostdate,'%a %d %b %y') AS lostdt 
						,b.firstname
						,b.lastname
						,b.companyname
						,a.acctid
						,a.sesid AS uid
						,(CASE WHEN a.businesstype = 'c' THEN 'Corporate' ELSE 'Individual' END) AS bustype
						,c.dddescription AS prodtypedesc 
						,CONCAT(d.fname,' ', d.lname) AS sharedabaini 
						,(CASE WHEN " . CDMOPPS . ".oppsstatus = 'p' THEN 'Potential' 
							WHEN " . CDMOPPS . ".oppsstatus = 'q' THEN 'Quote given/in discussion' 
							WHEN " . CDMOPPS . ".oppsstatus = 'c' THEN 'Closing stage' 
							WHEN " . CDMOPPS . ".oppsstatus = 's' THEN 'Signed / Paid / Issued' 
							WHEN " . CDMOPPS . ".oppsstatus = 'l' THEN 'Lost' 
							WHEN " . CDMOPPS . ".oppsstatus = 'x' THEN 'Cancel' ELSE '' END) AS statusdesc
					FROM " . CDMOPPS . " 
					LEFT JOIN ". CDMACCOUNTS ." a 
						ON a.acctid = " . CDMOPPS . ".acctid
					LEFT JOIN ". CDMCONTACTS ." b 
						ON b.ctcid = a.ctcid 
					LEFT JOIN ". DROPDOWNSMST ." c
						ON c.ddid = " . CDMOPPS . ".producttype AND c.dddisplay = 'cdmproducttypes' 
					LEFT JOIN ". ABAPEOPLESMST ." d 
						ON d.userid = " . CDMOPPS . ".sharedwith 
					WHERE " . CDMOPPS . ".userid = '$userid' OR " . CDMOPPS . ".sharedwith = '$userid' 
					ORDER BY " . CDMOPPS . ".createddate DESC ";
			}
			
			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func searchCltPros()! " . $this->cn->error;
				goto exitme;
			}
			$rows = array();
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;
			exitme:
			return $res;
		}

		function filterHeaderTask($data){
			$res = array();
			$rows=array();

			$headerval=$data['headerval'];
			$userid = $data['userid'];
			$today = TODAY;
			$where="";
			switch ($headerval){
				case 'ttlops':
					$where = " WHERE " . CDMOPPS . ".userid = '$userid' AND ". CDMOPPS . ".oppsstatus IN ('p', 'q', 'c') ";
					break;
				case 'ttlmedins':
					$where = " WHERE " . CDMOPPS . ".userid = '$userid' AND ". CDMOPPS . ".producttype = 'm' ";
					break;
				case 'ttllins':
					$where = " WHERE " . CDMOPPS . ".userid = '$userid' AND ". CDMOPPS . ".producttype = 'l' ";
					break;
				case 'ttlgenins':
					$where = " WHERE " . CDMOPPS . ".userid = '$userid' AND ". CDMOPPS . ".producttype = 'g' ";
					break;
				case 'ttlspi':
					$where = " WHERE " . CDMOPPS . ".userid = '$userid' AND ". CDMOPPS . ".oppsstatus = 'sp' ";
					break;
				case 'ttlsigned':
					$where = " WHERE " . CDMOPPS . ".userid = '$userid' AND ". CDMOPPS . ".oppsstatus = 's' ";
					break;
				case 'ttllost':
					$where = " WHERE " . CDMOPPS . ".userid = '$userid' AND ". CDMOPPS . ".oppsstatus = 'l' ";
					break;
				default:
					break;	
			}

			$sql = "SELECT " . CDMOPPS . ".*
						,DATE_FORMAT(" . CDMOPPS . ".srwtargetdate,'%a %d %b %y') as srwtargetdt 
						,DATE_FORMAT(" . CDMOPPS . ".polissueddate,'%a %d %b %y') AS polissueddt 
						,DATE_FORMAT(" . CDMOPPS . ".signeddate,'%a %d %b %y') AS signeddt 
						,DATE_FORMAT(" . CDMOPPS . ".lostdate,'%a %d %b %y') AS lostdt 
						,b.firstname
						,b.lastname
						,b.companyname
						,a.acctid
						,a.sesid AS uid
						,(CASE WHEN a.businesstype = 'c' THEN 'Corporate' ELSE 'Individual' END) AS bustype
						,c.dddescription AS prodtypedesc 
						,CONCAT(d.fname,' ', d.lname) AS sharedabaini  
						,(CASE WHEN " . CDMOPPS . ".oppsstatus = 'p' THEN 'Potential' 
							WHEN " . CDMOPPS . ".oppsstatus = 'q' THEN 'Quote given/in discussion' 
							WHEN " . CDMOPPS . ".oppsstatus = 'c' THEN 'Closing stage' 
							WHEN " . CDMOPPS . ".oppsstatus = 's' THEN 'Signed / Paid / Issued' 
							WHEN " . CDMOPPS . ".oppsstatus = 'l' THEN 'Lost' 
							WHEN " . CDMOPPS . ".oppsstatus = 'x' THEN 'Cancel' ELSE '' END) AS statusdesc
					FROM " . CDMOPPS . " 
					LEFT JOIN ". CDMACCOUNTS ." a 
						ON a.acctid = " . CDMOPPS . ".acctid
					LEFT JOIN ". CDMCONTACTS ." b 
						ON b.ctcid = a.ctcid 
					LEFT JOIN ". DROPDOWNSMST ." c
						ON c.ddid = " . CDMOPPS . ".producttype AND c.dddisplay = 'cdmproducttypes' 
					LEFT JOIN ". ABAPEOPLESMST ." d 
						ON d.userid = " . CDMOPPS . ".sharedwith 
					$where ";

			$qry = $this->cn->query($sql);
			$rows = array();
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;
			
			return $res;
		}
	}
?>