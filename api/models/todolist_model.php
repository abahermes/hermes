<?php
	class TodoListModel extends Database{

		private $db = "";
		private $cn = "";

		function __construct(){
			$this->db = new Database();
			$this->cn = $this->db->connect();
		}

		function genActivityID(){
			$today = formatDate("ym",TODAY);
			$newnno = "";
			$sql = "SELECT COUNT(id) + 1 as idcnt FROM " . TODOLISTS . " WHERE DATE_FORMAT(" . TODOLISTS . ".createddate,'%y%m') = '$today'";
			$qry = $this->cn->query($sql);
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$cnt = $row['idcnt'];
			}

			$pre = "T" . formatDate("ymd",TODAY) . "00";
			switch(strlen($cnt)){
				// case 4:
				// 	$newno = substr($pre, 0, -3) . $cnt; break;
				// case 3:
				// 	$newno = substr($pre, 0, -3) . $cnt; break;
				case 2:
					$newno = substr($pre, 0, -2) . $cnt; break;
				default:
					$newno = substr($pre, 0, -1) . $cnt; break;
			}
			// $this->cn->close();
			return $newno;
		}

		public function saveTodoList($data){
			// $psd = $data['psd'] == "" ? "" : formatDate("Y-m-d",$data['psd']);
			// $pfu = $data['pfu'] == "" ? "" : formatDate("Y-m-d",$data['pfu']);
			$res = array();
			$atraildata=array();
			$res['err'] = 0;
			$psdtlbl="";
			$psdtval="";
			$pfudtlbl="";
			$pfudtval="";
			$activityid =$this->genActivityID();
			$type = $data['taskType'] == "" ? "" : $data['taskType'];
			$task = addslashes($data['task']) == "" ? "" : addslashes($data['task']);
			$prio = $data['prio']== "" ? "" : $data['prio'];
			$cat = $data['cat'] == "" ? "" : $data['cat'];
			$fuw = $data['fuw'] == "" ? "" : $data['fuw'];
			$ofc = $data['ofc'] == "" ? "" : $data['ofc'];
			$othppl = $data['othppl'] == "" ? "" : $data['othppl'];
			if($data['psd'] != ""){
				$psdt = formatDate("Y-m-d",$data['psd']);
				$psdtlbl = ",psd";
				$psdtval = ",'$psdt'";
			} else {
				$psdtlbl = ",psd";
				$psdtval = ",NULL";
			}
			if($data['pfu'] != ""){
				$pfudt = formatDate("Y-m-d",$data['pfu']);
				$pfudtlbl = ",pfu";
				$pfudtval = ",'$pfudt'";
			} else  {
				$pfudtlbl = ",pfu";
				$pfudtval = ",NULL";
			}
			$startdate = $data['startdate'] == "" ? "" : formatDate("Y-m-d",$data['startdate']);
			$nextctcdate = $data['nextctcdate'] == "" ? "" : formatDate("Y-m-d",$data['nextctcdate']);
			$duedate = $data['duedate'] == "" ? "" : formatDate("Y-m-d",$data['duedate']);
			$fumtext = $data['fumtext'] == "" ? "" : $data['fumtext'];
			$fumlink = $data['fumlink'] == "" ? "" : $data['fumlink'];
			$status = $data['status'] == "" ? "" : $data['status'];
			$remarks = addslashes($data['remarks']) == "" ? "" : addslashes($data['remarks']);
			$abaini = $data['abaini'] == "" ? "" : $data['abaini'];
			$userid = $data['userid'] == "" ? "" : $data['userid'];
			$noofrevisions = $data['noofrevisions'] == "" ? "" : $data['noofrevisions'];

			$today = TODAY;
	
			$sql = "INSERT INTO " . TODOLISTS . " (activityid,tasktype,taskortodo,priority,category,fuw,ofc,othppl $psdtlbl $pfudtlbl,startdate,nextctcdate,duedate,noofrevisions,statuspercent,fumtext,fumlink,remarks,createddate,createdby,assignedto) 
					VALUES('$activityid','$type','$task','$prio','$cat','$fuw','$ofc','$othppl' $psdtval $pfudtval,'$startdate','$nextctcdate','$duedate','$noofrevisions','$status','$fumtext','$fumlink','$remarks','$today','$userid','$userid')";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func saveTodoList()!". $this->cn->error;
				goto exitme;
			}

			//save to cdm_atrail
			$atraildata['activityid'] = $activityid;
			$atraildata['method'] = "CREATE";
			$atraildata['details1'] = $sql;
			$atraildata['createdby'] = $abaini;

			$tdlatrail = new TDLAuditTrailModel;
			$tdlatrail->saveTDLAtrail($atraildata);

			exitme:
			return $res;
		}

		public function getPendingTodoList($data){
			$res = array();
			$rows = array();
			$userid=$data['userid'];
			$searchtask=$data['searchtask'];
			if(!empty($searchtask)){
				$sql = "SELECT " . TODOLISTS . ".*
						  ,DATE_FORMAT(" . TODOLISTS . ".psd, '%a %d %b %y') AS psdt 
						  ,DATE_FORMAT(" . TODOLISTS . ".pfu, '%a %d %b %y') AS pfudt 
						  ,DATE_FORMAT(" . TODOLISTS . ".startdate, '%a %d %b %y') AS startdt  
						  ,DATE_FORMAT(" . TODOLISTS . ".nextctcdate, '%a %d %b %y') AS nextctcdt 
						  ,DATE_FORMAT(" . TODOLISTS . ".duedate, '%a %d %b %y') AS duedt 
						FROM ". TODOLISTS . " 
						WHERE " . TODOLISTS . ".taskortodo LIKE '%$searchtask%' AND ". TODOLISTS . ".assignedto = '$userid' 
						ORDER BY ". TODOLISTS .".nextctcdate ASC";

			} else {
			$sql = "SELECT " . TODOLISTS . ".*
						  ,DATE_FORMAT(" . TODOLISTS . ".psd, '%a %d %b %y') AS psdt 
						  ,DATE_FORMAT(" . TODOLISTS . ".pfu, '%a %d %b %y') AS pfudt 
						  ,DATE_FORMAT(" . TODOLISTS . ".startdate, '%a %d %b %y') AS startdt  
						  ,DATE_FORMAT(" . TODOLISTS . ".nextctcdate, '%a %d %b %y') AS nextctcdt 
						  ,DATE_FORMAT(" . TODOLISTS . ".duedate, '%a %d %b %y') AS duedt 
						FROM ". TODOLISTS . " 
						WHERE " . TODOLISTS . ".assignedto='$userid'
						ORDER BY ". TODOLISTS .".nextctcdate ASC limit 0,60 " ;
			}
			$qry = $this->cn->query($sql);
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;
			// $this->cn->close();
			return $res;
		}

		public function getSortedTodoList($data){
			$res = array();
			$rows = array();
			$sortby=$data['sortby'];
			$userid=$data['userid'];
			$sortin = $data['sortin'];

			$prioval="priority";
			if($sortby == $prioval){
				$sql = "SELECT " . TODOLISTS . ".*
							  ,DATE_FORMAT(" . TODOLISTS . ".psd, '%a %d %b %y') AS psdt 
							  ,DATE_FORMAT(" . TODOLISTS . ".pfu, '%a %d %b %y') AS pfudt 
							  ,DATE_FORMAT(" . TODOLISTS . ".startdate, '%a %d %b %y') AS startdt  
							  ,DATE_FORMAT(" . TODOLISTS . ".nextctcdate, '%a %d %b %y') AS nextctcdt 
							  ,DATE_FORMAT(" . TODOLISTS . ".duedate, '%a %d %b %y') AS duedt 
							FROM ". TODOLISTS . " 
							LEFT JOIN ".DROPDOWNSMST." ON ".DROPDOWNSMST. ".`ddid` = ".TODOLISTS.".`priority` 
							WHERE ".TODOLISTS.".assignedto = '$userid'  AND ".DROPDOWNSMST.".`dddisplay` = 'tdlprio' 
							ORDER BY ".DROPDOWNSMST.".`sort` $sortin";
			} else {
				$sql = "SELECT " . TODOLISTS . ".*
							  ,DATE_FORMAT(" . TODOLISTS . ".psd, '%a %d %b %y') AS psdt 
							  ,DATE_FORMAT(" . TODOLISTS . ".pfu, '%a %d %b %y') AS pfudt 
							  ,DATE_FORMAT(" . TODOLISTS . ".startdate, '%a %d %b %y') AS startdt  
							  ,DATE_FORMAT(" . TODOLISTS . ".nextctcdate, '%a %d %b %y') AS nextctcdt 
							  ,DATE_FORMAT(" . TODOLISTS . ".duedate, '%a %d %b %y') AS duedt 
							FROM ". TODOLISTS . " 
							WHERE ".TODOLISTS.".assignedto = '$userid'
							ORDER BY ".TODOLISTS.".$sortby $sortin";
			}		
			
			$qry = $this->cn->query($sql);
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;
			// $this->cn->close();
			return $res;
		}

		public function getTodoData($taskid){
			$res = array();
			$rows = array();
			$sql="SELECT " . TODOLISTS . ".* 
						,DATE_FORMAT(" . TODOLISTS . ".psd, '%a %d %b %y') AS psdt 
					    ,DATE_FORMAT(" . TODOLISTS . ".pfu, '%a %d %b %y') AS pfudt 
					    ,DATE_FORMAT(" . TODOLISTS . ".startdate, '%a %d %b %y') AS startdt 
					    ,DATE_FORMAT(" . TODOLISTS . ".nextctcdate, '%a %d %b %y') AS nextctcdt 
					    ,DATE_FORMAT(" . TODOLISTS . ".duedate, '%a %d %b %y') AS duedt 
					FROM " . TODOLISTS . " 
					WHERE " . TODOLISTS . ".activityid = '$taskid' 
					ORDER BY ". TODOLISTS . ".nextctcdate ASC " ;

			$qry = $this->cn->query($sql);
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;
			// $this->cn->close();
			return $rows;
		}


		public function updateTodoList($data){
			$res=array();
			$atraildata=array();
			$res['err'] = 0;
			$psdt="";
			$pfudt="";
			$activityid = $data['activityid'];
			$type = $data['taskType'] == "" ? "" : $data['taskType'];
			$task = addslashes($data['task']) == "" ? "" : addslashes($data['task']);
			$prio = $data['prio'] == "" ? "" : $data['prio'];
			$cat = $data['cat'] == "" ? "" : $data['cat'];
			$fuw = $data['fuw'] == "" ? "" : $data['fuw'];
			$ofc = $data['ofc'] == "" ? "" : $data['ofc'];
			$othppl = $data['othppl'] == "" ? "" : $data['othppl'];
			if($data['psd'] != ""){
				$psdt = formatDate("Y-m-d",$data['psd']);
				$psdtval = " " . TODOLISTS . ".psd = '$psdt', ";
			} else {
				$psdt = formatDate("Y-m-d",$data['psd']);
				$psdtval = " " . TODOLISTS . ".psd = NULL, ";
			}	
			if($data['pfu'] != ""){
				$pfudt = formatDate("Y-m-d",$data['pfu']);
				$pfudtval = " " . TODOLISTS . ".pfu = '$pfudt', ";
			} else {
				$pfudt = formatDate("Y-m-d",$data['pfu']);
				$pfudtval = " " . TODOLISTS . ".pfu = NULL, ";
			}		
			$startdate = $data['startdate'] == "" ? "" : formatDate("Y-m-d",$data['startdate']);
			$nextctcdate = $data['nextctcdate'] == "" ? "" : formatDate("Y-m-d",$data['nextctcdate']);
			$duedate = $data['duedate'] == "" ? "" : formatDate("Y-m-d",$data['duedate']);
			$fumtext = $data['fumtext'] == "" ? "" : $data['fumtext'];
			$fumlink = $data['fumlink'] == "" ? "" : $data['fumlink'];
			$status = $data['status'] == "" ? "" : $data['status'];
			$remarks = addslashes($data['remarks']) == "" ? "" : addslashes($data['remarks']);
			$abaini = $data['abaini'] == "" ? "" : $data['abaini'];
			$userid = $data['userid'] == "" ? "" : $data['userid'];
			$noofrevisions = $data['noofrevisions'] == 0 ? 0 : $data['noofrevisions'];
			$today = TODAY;

			$sql = "UPDATE " . TODOLISTS . " 
					SET " . TODOLISTS . ".tasktype = '$type', 
						" . TODOLISTS . ".taskortodo = '$task', 
						" . TODOLISTS . ".priority = '$prio', 
						" . TODOLISTS . ".category = '$cat', 
						" . TODOLISTS . ".fuw = '$fuw', 
						" . TODOLISTS . ".ofc = '$ofc', 
						" . TODOLISTS . ".othppl = '$othppl', 
						" .$psdtval."
						" .$pfudtval."
						" . TODOLISTS . ".startdate = '$startdate', 
						" . TODOLISTS . ".nextctcdate = '$nextctcdate', 
						" . TODOLISTS . ".duedate = '$duedate', 
						" . TODOLISTS . ".noofrevisions = '$noofrevisions', 
						" . TODOLISTS . ".statuspercent = '$status', 
						" . TODOLISTS . ".fumtext = '$fumtext', 
						" . TODOLISTS . ".fumlink = '$fumlink', 
						" . TODOLISTS . ".remarks = '$remarks', 
						" . TODOLISTS . ".modifiedby = '$userid', 
						" . TODOLISTS . ".modifieddate = '$today' 
					WHERE " . TODOLISTS . ".activityid = '$activityid' ";
			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func updateTodoList()! " . $this->cn->error;
				goto exitme;
			}

			//save to cdm_atrail
			$atraildata['activityid'] = $activityid;
			$atraildata['method'] = "EDIT";
			$atraildata['details1'] = $sql;
			$atraildata['createdby'] = $abaini;

			$tdlatrail = new TDLAuditTrailModel;
			$tdlatrail->saveTDLAtrail($atraildata);

			exitme:
			// $this->cn->close();
			return $res;
		}

		public function searchTDL($data){
			$res = array();
			$rows = array();
			$userid=$data['userid'];
			$searchtask=addslashes($data['searchtask']);
			$searchby=$data['searchby'];
			
			if(!empty($searchtask)){
				switch ($searchby) {
					case 'taskortodo':
						$where = " WHERE " . TODOLISTS . ".assignedto = '$userid' AND " . TODOLISTS . ".taskortodo LIKE '%$searchtask%' ";
						break;
					case 'category':
						$where = " WHERE " . TODOLISTS . ".assignedto = '$userid' AND " . TODOLISTS . ".category = '$searchtask' ";
						break;
					case 'fuw':
						$where = " WHERE " . TODOLISTS . ".assignedto = '$userid' AND " . TODOLISTS . ".fuw = '$searchtask' ";
						break;
					default:
						break;
				}
			} else {
				$where = "WHERE " . TODOLISTS . ".assignedto='$userid' ORDER BY ". TODOLISTS .".nextctcdate ASC";
			}

			$sql = "SELECT " . TODOLISTS . ".*
							  ,DATE_FORMAT(" . TODOLISTS . ".psd, '%a %d %b %y') AS psdt 
							  ,DATE_FORMAT(" . TODOLISTS . ".pfu, '%a %d %b %y') AS pfudt 
							  ,DATE_FORMAT(" . TODOLISTS . ".startdate, '%a %d %b %y') AS startdt  
							  ,DATE_FORMAT(" . TODOLISTS . ".nextctcdate, '%a %d %b %y') AS nextctcdt 
							  ,DATE_FORMAT(" . TODOLISTS . ".duedate, '%a %d %b %y') AS duedt 
							FROM ". TODOLISTS . " $where" ;
			
			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func searchTDL()! " . $this->cn->error;
				goto exitme;
			}
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;
			// $this->cn->close();
			exitme:
			return $res;
		}

		function filterHeaderTDL($data){
			$res = array();
			$rows=array();

			$headerval=$data['headerval'];
			$userid = $data['userid'];
			$today = formatDate("Y-m-d",TODAY);
			$where="";

			switch ($headerval){
				case 'overdue':
					$where = " WHERE " . TODOLISTS . ".assignedto = '$userid' AND ". TODOLISTS . ".nextctcdate < '$today' ";
					break;
				case 'duetoday':
					$where = " WHERE " . TODOLISTS . ".assignedto = '$userid' AND ". TODOLISTS . ".nextctcdate = '$today' ";
					break;
				case 'taskpending':
					$where = " WHERE " . TODOLISTS . ".assignedto = '$userid' AND ". TODOLISTS . ".statuspercent < 100 ";
					break;
				default:
					break;
			}

			$sql="SELECT " . TODOLISTS . ".* 
						,DATE_FORMAT(" . TODOLISTS . ".psd, '%a %d %b %y') AS psdt 
					    ,DATE_FORMAT(" . TODOLISTS . ".pfu, '%a %d %b %y') AS pfudt 
					    ,DATE_FORMAT(" . TODOLISTS . ".startdate, '%a %d %b %y') AS startdt 
					    ,DATE_FORMAT(" . TODOLISTS . ".nextctcdate, '%a %d %b %y') AS nextctcdt 
					    ,DATE_FORMAT(" . TODOLISTS . ".duedate, '%a %d %b %y') AS duedt 
					FROM " . TODOLISTS . " 
					$where " ;


			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func filterHeaderTDL()! " . $this->cn->error;
				goto exitme;
			}
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;
			// $this->cn->close();
			exitme:
			return $res;
		}

		public function DBClose(){
			$this->cn->close();
		}
	}

?>