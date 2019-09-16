<?php
	class TDLAuditTrailModel extends Database{
		private $db = "";
		private $cn = "";

		function __construct(){
			$this->db = new Database();
			$this->cn = $this->db->connect();
		}

		function saveTDLAtrail($data){
			$res = array();
			$res['err'] = 0;

			$activityid = $data['activityid'];
			$method = $data['method'];
			$details1 = addslashes($data['details1']);
			$createdby = $data['createdby'];
			$today = TODAY;

			$sql = "INSERT INTO " . TODOLISTSATRAIL . " (activityid,method,details1,createdby,createddate)
					VALUES('$activityid','$method','$details1','$createdby','$today')";

			$qry = $this->cn->query($sql);
			if(!$qry){
				echo $this->cn->error;
				exit();
			}

			exitme:
			$this->cn->close();
		}

		function countRevisions($data){
			$res=array();
			$sql = "SELECT COUNT (*) AS CountRev 
					WHERE ".TODOLISTSATRAIL.".activityid='$data'";

			$qry = $this->cn->query($sql);
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;
			// $this->cn->close();
			return $res;
		}
	}
?>