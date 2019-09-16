<?php
	// include_once('auditlogs.php');
	class LeadsModel extends Database{

		private $db = "";
		private $cn = "";

		function __construct(){
			$this->db = new Database();
			$this->cn = $this->db->connect();
		}

		public function getLeads($userid){
			$res = array();
			$res['err'] = 0;

			$sql = "SELECT " . CDMLEADS . ".*
					FROM " . CDMLEADS . " 
					WHERE " . CDMLEADS . ".userid = '$userid' AND ". CDMLEADS .".status = 1 
					ORDER BY ". CDMLEADS . ".lastname,". CDMLEADS . ".firstname, ". CDMLEADS . ".companyname LIMIT 0,1000";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func getLeads()! " . $this->cn->error;
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

		public function getLeadDuplicates($userid){
			$res = array();
			$res['err'] = 0;

			$sql = "SELECT " . CDMLEADDUPS . ".*
					FROM " . CDMLEADDUPS . " 
					WHERE " . CDMLEADDUPS . ".userid = '$userid'
					ORDER BY ". CDMLEADDUPS . ".lastname,". CDMLEADDUPS . ".firstname, ". CDMLEADDUPS . ".companyname ";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func getLeadDuplicates()! " . $this->cn->error;
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

		public function getLead($leadid){
			$res = array();
			$res['err'] = 0;

			$sql = "SELECT " . CDMLEADS . ".*
						,DATE_FORMAT(" . CDMLEADS . ".birthdate,'%a %d %b %y') as birthdt  
					FROM " . CDMLEADS . " 
					WHERE " . CDMLEADS . ".leadid = '$leadid'";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func getLead()! " . $this->cn->error;
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

		public function getCountLeads($userid){
			$sql = "SELECT COUNT(" . CDMLEADS . ".id) as idcnt FROM " . CDMLEADS . " WHERE " . CDMLEADS . ".userid = '$userid' AND ". CDMLEADS .".status = 1 ";
			$qry = $this->cn->query($sql);
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$cnt = $row['idcnt'];
			}
			return $cnt;
		}

		public function getCountDuplicateLeads($userid){
			$sql = "SELECT COUNT(" . CDMLEADDUPS . ".id) as idcnt FROM " . CDMLEADDUPS . " WHERE " . CDMLEADDUPS . ".userid = '$userid' ";
			$qry = $this->cn->query($sql);
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$cnt = $row['idcnt'];
			}
			return $cnt;
		}

		public function getTotalLeads($userid){
			$cnt = 0;
			$sql = "SELECT RIGHT(" . CDMLEADS . ".leadid,5) AS lastcount FROM " . CDMLEADS . " WHERE " . CDMLEADS . ".userid = '$userid' ORDER BY " . CDMLEADS . ".leadid DESC LIMIT 0,1 ";
			$qry = $this->cn->query($sql);
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$cnt = $row['lastcount'];
			}
			return $cnt;
		}

		function genNewLeadNo($cnt){
			$newnno = "";
			$pre = "L" . formatDate("ym",TODAY) . "000000";
			switch(strlen($cnt)){
				case 6:
					$newno = substr($pre, 0, -6) . $cnt; break;
				case 5:
					$newno = substr($pre, 0, -5) . $cnt; break;
				case 4:
					$newno = substr($pre, 0, -4) . $cnt; break;
				case 3:
					$newno = substr($pre, 0, -3) . $cnt; break;
				case 2:
					$newno = substr($pre, 0, -2) . $cnt; break;
				default:
					$newno = substr($pre, 0, -1) . $cnt; break;
			}

			return $newno;
		}

		public function saveLead($data){
			$res = array();
			$res['err'] = 0;
			$userid = $data['userid'];
			$lno = $userid . $this->genNewLeadNo($data['cnt']);
			$fname = mysqli_real_escape_string($this->cn,addslashes($data['firstname']));
	    	$lname = mysqli_real_escape_string($this->cn,addslashes($data['lastname']));
	    	$mname = mysqli_real_escape_string($this->cn,addslashes($data['middlename']));
	    	$cnname = mysqli_real_escape_string($this->cn,addslashes($data['chinesename']));
	    	$bdate = isset($data['birthdate']) ? $data['birthdate'] : formatDate("Y-m-d","1900-01-01");
	    	$gender = $data['gender'];
	    	$company = mysqli_real_escape_string($this->cn,addslashes($data['companyname']));
	    	$jobtitle = mysqli_real_escape_string($this->cn,addslashes($data['jobtitle']));
	    	$eaddr = mysqli_real_escape_string($this->cn,addslashes($data['eaddr']));
	    	$homphno = mysqli_real_escape_string($this->cn,addslashes($data['homephoneno']));
	    	$mobphno = mysqli_real_escape_string($this->cn,addslashes($data['mobilephoneno']));
	    	$busphno = mysqli_real_escape_string($this->cn,addslashes($data['businessphoneno']));
	    	$st = mysqli_real_escape_string($this->cn,addslashes($data['street']));
	    	$city = mysqli_real_escape_string($this->cn,addslashes($data['city']));
	    	$state = mysqli_real_escape_string($this->cn,addslashes($data['state']));
	    	$country = mysqli_real_escape_string($this->cn,addslashes($data['countryorregion']));

			$today = TODAY;
			
			$sql = "INSERT INTO " . CDMLEADS . " (leadid,firstname,lastname,chinesename,birthdate,gender,companyname,jobtitle,emailaddress,homephoneno,mobilephoneno,businessphoneno
						,street,city,state,countryorregion,userid,assignedto,createdby,createddate) 
					VALUES('$lno','$fname','$lname','$cnname','$bdate','$gender','$company','$jobtitle','$eaddr','$homphno','$mobphno','$busphno','$st','$city','$state','$country','$userid'
						,'$userid','$userid','$today'); ";
			// $res['sql'] = $sql;

			// $qry = $this->cn->query($sql);
			// if(!$qry){
			// 	$res['err'] = 1;
			// 	$res['errmsg'] = 'error saving Lead! ' . $this->cn->error;
			// }

			// $sql1 = 

			return $sql;
		}

		public function syncLead($data){
			$res = array();
			$res['err'] = 0;
			$userid = $data['userid'];
			$lno = $userid . $this->genNewLeadNo($data['cnt']);
			$fname = mysqli_real_escape_string($this->cn,addslashes($data['firstname']));
	    	$lname = mysqli_real_escape_string($this->cn,addslashes($data['lastname']));
	    	$mname = mysqli_real_escape_string($this->cn,addslashes($data['middlename']));
	    	$cnname = mysqli_real_escape_string($this->cn,addslashes($data['chinesename']));
	    	$bdate = !isset($data['birthdate']) || $data['birthdate'] == "" || $data['birthdate'] == null ? formatDate("Y-m-d","1900-01-01") : formatDate("Y-m-d",$data['birthdate']);
	    	$company = mysqli_real_escape_string($this->cn,addslashes($data['companyname']));
	    	$jobtitle = mysqli_real_escape_string($this->cn,addslashes($data['jobtitle']));
	    	$mobphno = mysqli_real_escape_string($this->cn,addslashes($data['mobilephoneno']));
	    	$manager = mysqli_real_escape_string($this->cn,addslashes($data['manager']));
			$today = TODAY;
			
			$sql = "INSERT INTO " . CDMLEADS . " (leadid,firstname,lastname,chinesename,middlename,birthdate,companyname,jobtitle,mobilephoneno,manager
						,userid,assignedto,createdby,createddate) 
					VALUES('$lno','$fname','$lname','$cnname','$mname','$bdate','$company','$jobtitle','$mobphno','$manager','$userid','$userid','$userid','$today'); ";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = 'error auto sync Lead! ' . $this->cn->error;
			}

			return $res;
		}

		public function execLeadsMultiQuery($val){
			$res = array();
			$res['err'] = 0;
			$qry = $this->cn->multi_query($val);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = 'error saving execLeadsMultiQuery! ' . $this->cn->error;
			}

			return $res;
		}

		function searchLeads($data){
			$res = array();
			$rows = array();
			$userid=$data['userid'];
			$searchtext=addslashes($data['$searchtext']);
			$searchby=$data['searchby'];

			if(!empty($searchtext)){
				switch ($searchby) {
					case 'fullname':
						$where = " WHERE " . CDMLEADS . ".userid = '$userid' AND CONCAT(" . CDMLEADS . ".lastname,' '," . CDMLEADS . ".firstname) LIKE '%$searchtext%' AND ". CDMLEADS .".status = 1  ";
						break;
					case 'jobtitle':
						$where = " WHERE " . CDMLEADS . ".userid = '$userid' AND " . CDMLEADS . ".jobtitle LIKE '%$searchtext%' AND ". CDMLEADS .".status = 1  ";
						break;
					case 'company':
						$where = " WHERE " . CDMLEADS . ".userid = '$userid' AND " . CDMLEADS . ".companyname LIKE '%$searchtext%' AND ". CDMLEADS .".status = 1  ";
						break;
					default:
						break;
				}
			} else {
				$where = "WHERE " . CDMLEADS . ".userid ='$userid' AND ". CDMLEADS .".status = 1  ";
			}

			$sql = "SELECT * 
					FROM " . CDMLEADS . " 
					$where 
					ORDER BY ". CDMLEADS . ".lastname,". CDMLEADS . ".firstname, ". CDMLEADS . ".companyname ";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func searchLeads()! " . $this->cn->error;
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

		function getSortedLeads($data){
			$res = array();
			$rows = array();
			$sortby=$data['sortby'];
			$userid=$data['userid'];
			$sortin = $data['sortin'];

			switch ($sortby) {
				case 'fullname':
					$fieldname = CDMLEADS . ".lastname $sortin ";
					break;
				case 'jobtitle':
					$fieldname = CDMLEADS . ".jobtitle $sortin ";
					break;
				case 'companyname':
					$fieldname = "-" .CDMLEADS . ".companyname $sortin ";
					break;
				case 'emailadd':
					$fieldname = CDMLEADS . ".emailaddress $sortin ";
					break;
				default:
					break;
			}

			$sql = "SELECT * 
					FROM " . CDMLEADS . " 
					WHERE " . CDMLEADS . ".userid = '$userid' AND " . CDMLEADS . ".status = 1
					ORDER BY $fieldname ";

			$qry = $this->cn->query($sql);
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;
			// $this->cn->close();

			return $res;
		}

		public function deleteLead($data){
			$res = array();
			$res['err'] = 0;
			$userid = $data['userid'];
			$leadid = $data['leadid'];
			$today = TODAY;

			$sql = "UPDATE ". CDMLEADS ." SET ". CDMLEADS .".status = 0, ". CDMLEADS .".modifiedby = '$userid', ". CDMLEADS .".modifieddate = '$today' 
					WHERE ". CDMLEADS .".leadid = '$leadid' ";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func deleteLead()! " . $this->cn->error;
				// goto exitme;
			}

			return $res;
		}

		public function deleteLeads($data){
			$res = array();
			$res['err'] = 0;
			$userid = $data['userid'];
			$leadids = implode("','",$data['leadids']);
			$today = TODAY;

			$sql = "UPDATE ". CDMLEADS ." SET ". CDMLEADS .".status = 0, ". CDMLEADS .".modifiedby = '$userid', ". CDMLEADS .".modifieddate = '$today' 
					WHERE ". CDMLEADS .".leadid IN('$leadids') ";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func deleteLeads()! " . $this->cn->error;
				// goto exitme;
			}

			return $res;
		}

		public function saveVCard($data){
			$res = array();
			$res['err'] = 0;
			$userid = $data['userid'];
			$lno = $userid . $this->genNewLeadNo($data['cnt']);
			$fname = mysqli_real_escape_string($this->cn,addslashes($data['fname']));
	    	$lname = mysqli_real_escape_string($this->cn,addslashes($data['lname']));
	    	$mname = mysqli_real_escape_string($this->cn,addslashes($data['mname']));
	    	$cnname = mysqli_real_escape_string($this->cn,addslashes($data['cnname']));
	    	$bdate = mysqli_real_escape_string($this->cn,addslashes($data['dob']));
	    	$company = mysqli_real_escape_string($this->cn,addslashes($data['companyname']));
	    	$jobtitle = mysqli_real_escape_string($this->cn,addslashes($data['jobtitle']));
	    	$eaddr = mysqli_real_escape_string($this->cn,addslashes($data['emailaddr']));
	    	$website = mysqli_real_escape_string($this->cn,addslashes($data['website']));
	    	$homphno = mysqli_real_escape_string($this->cn,addslashes($data['homphno']));
	    	$mobphno = mysqli_real_escape_string($this->cn,addslashes($data['mobphno']));
	    	$busphno = mysqli_real_escape_string($this->cn,addslashes($data['busphno']));
			$today = TODAY;
			
			$sql = "INSERT INTO " . CDMLEADS . " (leadid,firstname,lastname,chinesename,birthdate,companyname,jobtitle,emailaddress,homephoneno,mobilephoneno,businessphoneno,savedas,website,userid,assignedto,createdby,createddate) 
					VALUES('$lno','$fname','$lname','$cnname','$bdate','$company','$jobtitle','$eaddr','$homphno','$mobphno','$busphno','vcard','$website','$userid','$userid','$userid','$today') ";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = 'error saving vcard! ' . $this->cn->error;
			}

			return $res;
		}

		public function saveVCardDuplicate($data){
			$res = array();
			$res['err'] = 0;
			$userid = $data['userid'];
			$fname = mysqli_real_escape_string($this->cn,addslashes($data['fname']));
	    	$lname = mysqli_real_escape_string($this->cn,addslashes($data['lname']));
	    	$mname = mysqli_real_escape_string($this->cn,addslashes($data['mname']));
	    	$cnname = mysqli_real_escape_string($this->cn,addslashes($data['cnname']));
	    	$bdate = mysqli_real_escape_string($this->cn,addslashes($data['dob']));
	    	$company = mysqli_real_escape_string($this->cn,addslashes($data['companyname']));
	    	$jobtitle = mysqli_real_escape_string($this->cn,addslashes($data['jobtitle']));
	    	$eaddr = mysqli_real_escape_string($this->cn,addslashes($data['emailaddr']));
	    	$website = mysqli_real_escape_string($this->cn,addslashes($data['website']));
	    	$homphno = mysqli_real_escape_string($this->cn,addslashes($data['homphno']));
	    	$mobphno = mysqli_real_escape_string($this->cn,addslashes($data['mobphno']));
	    	$busphno = mysqli_real_escape_string($this->cn,addslashes($data['busphno']));
			$today = TODAY;
			
			$sql = "INSERT INTO " . CDMLEADDUPS . " (firstname,lastname,chinesename,birthdate,companyname,jobtitle,emailaddress,homephoneno,mobilephoneno,businessphoneno,savedas,website
						,userid,assignedto,createdby,createddate) 
					VALUES('$fname','$lname','$cnname','$bdate','$company','$jobtitle','$eaddr','$homphno','$mobphno','$busphno','vcard','$website','$userid','$userid','$userid','$today') ";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = 'error saving vcard! ' . $this->cn->error;
			}

			return $res;
		}

		public function chkLeadExist($data){
			$res = array();
			$fname = $data['firstname'];
			$lname = $data['lastname'];
			$userid = $data['userid'];

			$sql = "SELECT count(". CDMLEADS .".id) as cnt 
					FROM ". CDMLEADS ." 
					WHERE ". CDMLEADS .".firstname = '$fname' AND ". CDMLEADS .".lastname = '$lname' AND ". CDMLEADS .".assignedto = '$userid' AND ". CDMLEADS .".status = 1 ";
			$qry = $this->cn->query($sql);
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$cnt = $row['cnt'];
			}
			return $cnt;
		}

		public function getDuplicateLead($leadid){
			$res = array();
			$res['err'] = 0;

			$sql = "SELECT " . CDMLEADDUPS . ".*
					FROM " . CDMLEADDUPS . " 
					WHERE " . CDMLEADDUPS . ".id = '$leadid'";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func getDuplicateLead()! " . $this->cn->error;
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

		public function saveDuplicateLead($data){
			$res = array();
			$res['err'] = 0;
			$id = $data['id'];
			$userid = $data['userid'];
			$lno = $userid . $this->genNewLeadNo($data['cnt']);
			$fname = mysqli_real_escape_string($this->cn,addslashes($data['firstname']));
	    	$lname = mysqli_real_escape_string($this->cn,addslashes($data['lastname']));
	    	$mname = mysqli_real_escape_string($this->cn,addslashes($data['middlename']));
	    	$cnname = mysqli_real_escape_string($this->cn,addslashes($data['chinesename']));
	    	$bdate = isset($data['birthdate']) ? $data['birthdate'] : formatDate("Y-m-d","1900-01-01");
	    	$gender = $data['gender'];
	    	$company = mysqli_real_escape_string($this->cn,addslashes($data['companyname']));
	    	$jobtitle = mysqli_real_escape_string($this->cn,addslashes($data['jobtitle']));
	    	$eaddr = mysqli_real_escape_string($this->cn,addslashes($data['emailaddress']));
	    	$homphno = mysqli_real_escape_string($this->cn,addslashes($data['homephoneno']));
	    	$mobphno = mysqli_real_escape_string($this->cn,addslashes($data['mobilephoneno']));
	    	$busphno = mysqli_real_escape_string($this->cn,addslashes($data['businessphoneno']));
	    	$st = mysqli_real_escape_string($this->cn,addslashes($data['street']));
	    	$city = mysqli_real_escape_string($this->cn,addslashes($data['city']));
	    	$state = mysqli_real_escape_string($this->cn,addslashes($data['state']));
	    	$country = mysqli_real_escape_string($this->cn,addslashes($data['countryorregion']));
			$today = TODAY;
			
			$sql = "INSERT INTO " . CDMLEADS . " (leadid,firstname,lastname,chinesename,birthdate,gender,companyname,jobtitle,emailaddress,homephoneno,mobilephoneno,businessphoneno
						,street,city,state,countryorregion,userid,assignedto,createdby,createddate) 
					VALUES('$lno','$fname','$lname','$cnname','$bdate','$gender','$company','$jobtitle','$eaddr','$homphno','$mobphno','$busphno','$st','$city','$state','$country','$userid'
						,'$userid','$userid','$today'); ";
			$qry = $this->cn->query($sql);

			$sql1 = "DELETE FROM ". CDMLEADDUPS ." WHERE ". CDMLEADDUPS .".id = '$id' ";
			$this->cn->query($sql1);

			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func saveDuplicateLead()! " . $this->cn->error;
				goto exitme;
			}
			exitme:
			return $res;
		}

		public function deleteDuplicateLead($leadid){
			$res = array();
			$res['err'] = 0;
			$id = $leadid;

			$sql = "DELETE FROM ". CDMLEADDUPS ." WHERE ". CDMLEADDUPS .".id = '$id' ";
			$qry = $this->cn->query($sql);

			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func deleteDuplicateLead()! " . $this->cn->error;
				goto exitme;
			}
			exitme:
			return $res;
		}

		public function getExistAccounts($userid){
			$res = array();
			$res['err'] = 0;
			$id = $leadid;

			$sql = "SELECT * FROM ". CDMACCOUNTS ." WHERE ". CDMACCOUNTS .".userid = '$userid' ";
			$qry = $this->cn->query($sql);

			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func deleteDuplicateLead()! " . $this->cn->error;
				goto exitme;
			}
			exitme:
			return $res;
		}

		public function closeDB(){
			$this->cn->close();
		}
	}
?>