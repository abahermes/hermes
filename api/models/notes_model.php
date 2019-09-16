<?php
	// include_once('auditlogs.php');
	class NotesModel extends Database{

		private $db = "";
		private $cn = "";

		function __construct(){
			$this->db = new Database();
			$this->cn = $this->db->connect();
		}

		// function genNewNo(){
		// 	$today = formatDate("ymd",TODAY);
		// 	$newnno = "";
		// 	$sql = "SELECT COUNT(id) + 1 as idcnt FROM " . CDMACTIVITIES . " WHERE DATE_FORMAT(" . CDMACTIVITIES . ".createddate,'%y%m%d') = '$today'";
		// 	$qry = $this->cn->query($sql);
		// 	while($row = $qry->fetch_array(MYSQLI_ASSOC)){
		// 		$cnt = $row['idcnt'];
		// 	}

		// 	$pre = "A" . formatDate("ymd",TODAY) . "00000";
		// 	switch(strlen($cnt)){
		// 		case 5:
		// 			$newno = substr($pre, 0, -5) . $cnt; break;
		// 		case 4:
		// 			$newno = substr($pre, 0, -4) . $cnt; break;
		// 		case 3:
		// 			$newno = substr($pre, 0, -3) . $cnt; break;
		// 		case 2:
		// 			$newno = substr($pre, 0, -2) . $cnt; break;
		// 		default:
		// 			$newno = substr($pre, 0, -1) . $cnt; break;
		// 	}

		// 	return $newno;
		// }

		public function saveNotes($data){
			$res = array();
			$res['err'] = 0;

			$notes = stripslashes($data['notes']);
			$acctid = $data['acctid'];
			$userid = $data['userid'];
			$cltprost = $data['cltprost'];
			$today = TODAY;

			$sql = "INSERT INTO " . CDMNOTES . " (acctid,notes,userid,createdby,createddate) 
					VALUES('$acctid','$notes','$userid','$userid','$today') ";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func saveNotes()!"  . $this->cn->error;
				goto exitme;
			}

			$actdata = array();
			$actdata['type'] = "";
			$actdata['details'] = 'A notes created for '. $cltprost;
			$actdata['assignedto'] = $userid;
			$actdata['abauser'] = $userid;
			$actdata['userid'] = $userid;
			$actdata['acctid'] = $acctid;

			$acts = new ActivitiesModel;
			$res['act'] = $acts->saveActivity($actdata);

			exitme:
			return $res;
		}

		public function getNotes($acctid){
			$res = array();
			$rows = array();
			$sql = "SELECT " . CDMNOTES . ".*
						,DATE_FORMAT(" . CDMNOTES . ".createddate,'%a %d %b %y') AS createddt
						,DATE_FORMAT(" . CDMNOTES . ".createddate,'%H:%i') AS createdtm
						,DATE_FORMAT(" . CDMNOTES . ".createddate,'%y%m%d') AS creadt
					FROM " . CDMNOTES . " 
					WHERE " . CDMNOTES . ".acctid = '$acctid' 
					ORDER BY " . CDMNOTES . ".createddate DESC LIMIT 0,50";
			$qry = $this->cn->query($sql);
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;

			return $res;
		}

		// public function getActivitiesDashBoard($userid){
		// 	$res = array();
		// 	$rows=array();
		// 	$sql = "SELECT " . CDMACTIVITIES . ".*
		// 				,DATE_FORMAT(" . CDMACTIVITIES . ".createddate,'%a %d %b %y') AS createddt
		// 				,DATE_FORMAT(" . CDMACTIVITIES . ".createddate,'%H:%i') AS createdtm
		// 				,DATE_FORMAT(" . CDMACTIVITIES . ".createddate,'%y%m%d') AS creadt
		// 			FROM " . CDMACTIVITIES . " 
		// 			WHERE " . CDMACTIVITIES . ".userid = '$userid' AND " . CDMACTIVITIES . ".acttype <> 'login' 
		// 			ORDER BY " . CDMACTIVITIES . ".createddate DESC";
		// 	$qry = $this->cn->query($sql);
		// 	while($row = $qry->fetch_array(MYSQLI_ASSOC)){
		// 		$rows[] = $row;
		// 	}

		// 	$res['rows'] = $rows;

		// 	return $res;
		// }

		public function updateNotes($data){
			$res = array();
			$res['err'] = 0;

			$notes = stripslashes($data['notes']);
			$acctid = $data['acctid'];
			$userid = $data['userid'];
			$cltprost = $data['cltprost'];
			$today = TODAY;

			$sql = "UPDATE " . CDMNOTES . " 
					SET notes = '$notes', modifiedby = '$userid', modifieddate = '$today' 
					WHERE " . CDMNOTES . ".acctid = '$acctid' ";

			// $sql = "INSERT INTO " . CDMNOTES . " (acctid,notes,userid,createdby,createddate) 
			// 		VALUES('$acctid','$notes','$userid','$userid','$today') ";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func updateNotes()!"  . $this->cn->error;
				goto exitme;
			}

			$actdata = array();
			$actdata['type'] = "";
			$actdata['details'] = 'A notes updated for '. $cltprost;
			$actdata['assignedto'] = $userid;
			$actdata['abauser'] = $userid;
			$actdata['userid'] = $userid;
			$actdata['acctid'] = $acctid;

			$acts = new ActivitiesModel;
			$res['act'] = $acts->saveActivity($actdata);

			exitme:
			return $res;
		}


		public function closeDB(){
			$this->cn->close();
		}
	}
?>