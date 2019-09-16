<?php
	// include_once('auditlogs.php');
	class ClientProspectModel extends Database{

		private $db = "";
		private $cn = "";

		function __construct(){
			$this->db = new Database();
			$this->cn = $this->db->connect();
		}

		public function saveClientProst($data){
			$res = array();
			$res['err'] = 0;
			$uid = $data['uid'];
			$etag = $data['etag'];
			$title = $data['title'] == "" ? "" : $data['title'];
			$fn = $data['firstname'] == "" ? "" : $data['firstname'];
			$mn = $data['middlename'] == "" ? "" : $data['middlename'];
			$ln = $data['lastname'] == "" ? "" : $data['lastname'];
			$cnn = $data['chinesename'] == "" ? "" : $data['chinesename'];
			$gender = $data['gender'] == "" ? "" : $data['gender'];
			$bdt = $data['birthdate'] == "" ? "" : formatDate("Y-m-d",$data['birthdate']);
			$abauser = $data['abauser'];
			$today = TODAY;

			$sql = "INSERT INTO " . CDMCONTACTS . " (uid,etag,title,firstname,middlename,lastname,chinesename,birthdate,gender,assignedto,createdby,createddate) 
					VALUES('$uid','$etag','$title','$fn','$mn','$ln','$cnn','$bdt','$gender','$abauser','$abauser','$today') ";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func saveClientProst()!";
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