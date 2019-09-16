<?php
	// include_once('auditlogs.php');
	class ContactsModel extends Database{

		private $db = "";
		private $cn = "";

		function __construct(){
			$this->db = new Database();
			$this->cn = $this->db->connect();
		}

		function genNewCtcNo(){
			$today = formatDate("ym",TODAY);
			$newnno = "";
			$sql = "SELECT COUNT(id) + 1 as idcnt FROM " . CDMCONTACTS . " WHERE DATE_FORMAT(" . CDMCONTACTS . ".createddate,'%y%m') = '$today'";
			$qry = $this->cn->query($sql);
			$cnt = 1;
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$cnt = $row['idcnt'];
			}

			$pre = "CTC" . formatDate("ym",TODAY) . "000";
			switch(strlen($cnt)){
				case 3:
					$newno = substr($pre, 0, -3) . $cnt; break;
				case 2:
					$newno = substr($pre, 0, -2) . $cnt; break;
				default:
					$newno = substr($pre, 0, -1) . $cnt; break;
			}

			return $newno;
		}

		public function saveContact($data){
			$res = array();
			$res['err'] = 0;
			$bdt = "";
			$bdtlbl = "";
			$bdtval = "";
			// $newctcno = "";
			$userid = $data['userid'];
			$ctcid = $userid . $this->genNewCtcNo();

			$leadid = $data['leadid'];
			$uid = $data['uid'];
			$etag = $data['etag'];
			$title = $data['title'] == "" ? "" : $data['title'];
			$fn = $data['firstname'] == "" ? "" : $data['firstname'];
			$mn = $data['middlename'] == "" ? "" : $data['middlename'];
			$ln = $data['lastname'] == "" ? "" : $data['lastname'];
			$cnn = $data['chinesename'] == "" ? "" : $data['chinesename'];
			$ini = $data['ini'] == "" ? "" : $data['ini'];
			// $bdt = $data['birthdate'] == "" ? "0000-00-00 00:00:00" : formatDate("Y-m-d",$data['birthdate']);
			if($data['birthdate'] != ""){
				$bdt = formatDate("Y-m-d",$data['birthdate']);
				$bdtlbl = ",birthdate";
				$bdtval = ",'$bdt'";
			}
			$gender = $data['gender'] == "" ? "" : $data['gender'];
			$company = $data['company'] == "" ? "" : $data['company'];
			$jobtitle = $data['jobtitle'] == "" ? "" : $data['jobtitle'];
			$eaddr = $data['eaddr'] == "" ? "" : $data['eaddr'];
			$website = $data['website'] == "" ? "" : $data['website'];
			$homphno = $data['homphno'] == "" ? "" : $data['homphno'];
			$mobphno = $data['mobphno'] == "" ? "" : $data['mobphno'];
			$addr = $data['addr'] == "" ? "" : $data['addr'];
			$nat = $data['nationality'] == "" ? "" : $data['nationality'];
			$eth = $data['ethnicity'] == "" ? "" : $data['ethnicity'];

			$assignedto = $data['assignedto'];
			$abauser = $data['abauser'];
			
			$today = TODAY;

			$sql = "INSERT INTO " . CDMCONTACTS . " (leadid,ctcid,uid,etag,title,firstname,middlename,lastname,chinesename,initials $bdtlbl ,gender,companyname,jobtitle,emailaddress,website,homephoneno,mobilephoneno,address,nationality,ethnicity,assignedto,createdby,createddate,userid) 
					VALUES('$leadid','$ctcid','$uid','$etag','$title','$fn','$mn','$ln','$cnn','$ini' $bdtval ,'$gender','$company','$jobtitle','$eaddr','$website','$homphno','$mobphno','$addr','$nat','$eth','$userid','$userid','$today','$userid') ";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['ctcid'] = "";
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func saveContact()! "  . $this->cn->error;
				goto exitme;
			}
			$res['ctcid'] = $ctcid;
			exitme:
			return $res;
		}

		public function updateContact($data){
			$res = array();
			$res['err'] = 0;
			$bdtval = "";
			$userid = $data['userid'];
			$ctcid = $data['ctcid'];
			$acctid = $data['acctid'];
			$title = $data['title'] == "" ? "" : $data['title'];
			$fn = $data['firstname'] == "" ? "" : $data['firstname'];
			$mn = $data['middlename'] == "" ? "" : $data['middlename'];
			$ln = $data['lastname'] == "" ? "" : $data['lastname'];
			$cnn = $data['chinesename'] == "" ? "" : $data['chinesename'];
			$ini = $data['ini'] == "" ? "" : $data['ini'];
			if($data['birthdate'] != ""){
				$bdt = formatDate("Y-m-d",$data['birthdate']);
				$bdtval = ", " . CDMCONTACTS . ".birthdate = '$bdt'";
			}
			$gender = $data['gender'] == "" ? "" : $data['gender'];
			$company = $data['company'] == "" ? "" : $data['company'];
			$jobtitle = $data['jobtitle'] == "" ? "" : $data['jobtitle'];
			$eaddr = $data['eaddr'] == "" ? "" : $data['eaddr'];
			$homphno = $data['homphno'] == "" ? "" : $data['homphno'];
			$mobphno = $data['mobphno'] == "" ? "" : $data['mobphno'];
			$addr = $data['addr'] == "" ? "" : $data['addr'];
			$nat = $data['nationality'] == "" ? "" : $data['nationality'];
			$eth = $data['ethnicity'] == "" ? "" : $data['ethnicity'];

			$assignedto = $data['assignedto'];
			$abauser = $data['abauser'];
			$today = TODAY;		

			$sql = "UPDATE " . CDMCONTACTS . " 
					SET " . CDMCONTACTS . ".title = '$title', " . CDMCONTACTS . ".firstname = '$fn', " . CDMCONTACTS . ".middlename = '$mn', " . CDMCONTACTS . ".lastname = '$ln',
						" . CDMCONTACTS . ".chinesename = '$cnn', ". CDMCONTACTS . ".initials = '$ini' $bdtval, " . CDMCONTACTS . ".gender = '$gender',
						" . CDMCONTACTS . ".companyname = '$company', " . CDMCONTACTS . ".jobtitle = '$jobtitle', " . CDMCONTACTS . ".emailaddress = '$eaddr',
						" . CDMCONTACTS . ".homephoneno = '$homphno', " . CDMCONTACTS . ".mobilephoneno = '$mobphno', " . CDMCONTACTS . ".address = '$addr',
			 			" . CDMCONTACTS . ".nationality = '$nat', " . CDMCONTACTS . ".ethnicity = '$eth', " . CDMCONTACTS . ".assignedto = '$userid',
						" . CDMCONTACTS . ".modifiedby = '$userid', " . CDMCONTACTS . ".modifieddate = '$today' 
					WHERE " . CDMCONTACTS . ".ctcid = '$ctcid'";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func updateContact()! " . $this->cn->error;
				goto exitme;
			}
			exitme:
			return $res;
		}

		public function getContact($ctcid){
			$res = array();
			$sql = "SELECT " . CDMCONTACTS . ".*
						,DATE_FORMAT(" . CDMCONTACTS . ".birthdate,'%a %d %b %y') AS bdt
						,TIMESTAMPDIFF(YEAR, " . CDMCONTACTS . ".birthdate, CURDATE()) AS cltage
					FROM " . CDMCONTACTS . " 
					WHERE " . CDMCONTACTS . ".ctcid = '$ctcid' 
					LIMIT 0,1 ";
			$qry = $this->cn->query($sql);
			$rows = array();
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;

			return $res;
		}

		// public function chkCltProst($data){
		// 	$res = array();
		// 	$rows = array();
		// 	$res['err'] = 0;
		// 	$uid = $data['uid'];
		// 	$etag = $data['etag'];

		// 	$sql = "SELECT * FROM " . CDMCONTACTS . " WHERE " . CDMCONTACTS . ".uid = '$uid' AND " . CDMCONTACTS . ".etag = '$etag' ";
		// 	$qry = $this->cn->query($sql);
		// 	if(!$qry){
		// 		$res['err'] = 1;
		// 		$res['errmsg'] = "An error occured in func chkCltProst()!";
		// 		goto exitme;
		// 	}
		// 	while($row = $qry->fetch_array(MYSQLI_ASSOC)){
		// 		$rows[] = $row;
		// 	}
		// 	$this->cn->close();

		// 	$res = $rows;
			
		// 	exitme:
		// 	return $res;
		// }

		public function closeDB(){
			$this->cn->close();
		}
	}
?>