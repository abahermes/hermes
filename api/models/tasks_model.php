<?php
	// include_once('auditlogs.php');
	class TasksModel extends Database{

		private $db = "";
		private $cn = "";

		function __construct(){
			$this->db = new Database();
			$this->cn = $this->db->connect();
		}

		public function saveTask($data){
			$res = array();
			$actdata = array();
			$res['err'] = 0;
			$sesid = $data['sesid'];
			$abauser = $data['abaini'];
			$userid = $data['userid'];
			$acctid = $data['acctid'];
			$cltprost = $data['cltprost'];
			$etime = $data['endtime'];
			$noofmtg = $data['noofmtg'] == "" ? 1 : $data['noofmtg'];
			$otppl = $data['otppl'];
			$resultexpected = $data['resultexpected'];
			$specificresult = $data['specificresult'];
			$stime = $data['starttime'];
			$taskdate = formatDate("Y-m-d",$data['taskdate']);
			$tasktype = $data['tasktype'];
			$tasktypedesc = $data['tasktypedesc'];
			$remarks = $data['taskremarks'];
			$taskid = $acctid ."-T-". formatDate("ymdhis",TODAY);
			$assignedto = $data['assignedto'];
			$userid = $data['userid'];
			$today = TODAY;

			$sql = "INSERT INTO " . CDMTASKS . " (acctid,taskid,taskdate,tasktype,cmpresent,starttime,endtime,noofmtgs,resultexpected,specificresult,remarks,assignedto,createdby,createddate,userid) 
					VALUES('$acctid','$taskid','$taskdate','$tasktype','$otppl','$stime','$etime','$noofmtg','$resultexpected','$specificresult','$remarks','$userid','$userid','$today','$userid') ";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func saveTask()! " . $this->cn->error;
				goto exitme;
			}

			$specificres = "";
			if(!empty($specificresult)){
				$specificres = " about ". $specificresult;
			}
			$cmpres = "";
			if(!empty($otppl)){
				$cmpres = " with " . $otppl;
			}
			$taskdt = " on " . formatDate("D d M y",$taskdate);

			// save activity
			$actdata['type'] = $tasktype;
			$actdata['details'] = 'Task created to '. strtolower($tasktypedesc) .' <a href="cdm.php?id='. $sesid .'">'. $cltprost .'</a> '. $cmpres . $specificres . $taskdt .'.';
			$actdata['assignedto'] = $assignedto;
			$actdata['abauser'] = $abauser;
			$actdata['userid'] = $userid;
			$actdata['acctid'] = $acctid;

			$acts = new ActivitiesModel;
			$res['act'] = $acts->saveActivity($actdata);
			exitme:
			return $res;
		}

		public function updateTask($data){
			$res = array();
			$actdata = array();
			$status = 0;
			$res['err'] = 0;
			$sesid = $data['sesid'];
			$userid = $data['userid'];
			$taskid = $data['taskid'];
			$abauser = $data['abaini'];
			$acctid = $data['acctid'];
			$cltprost = $data['cltprost'];
			$etime = $data['endtime'];
			$noofmtgs = $data['noofmtg'];
			$otppl = $data['otppl'];
			$resultexpected = $data['resultexpected'];
			$specificresult = $data['specificresult'];
			$stime = $data['starttime'];
			$taskdate = formatDate("Y-m-d",$data['taskdate']);
			$tasktype = $data['tasktype'];
			$tasktypedesc = $data['tasktypedesc'];
			$remarks = $data['taskremarks'];
			$resultachieve = $data['resultachieve'];
			$action = 'updated';
			if(!empty($resultachieve)){
				$status = 1;
				$action = 'done';
			}
			if(empty($noofmtgs)){
				$noofmtgs = 0;
			}
			$assignedto = $data['assignedto'];
			$today = TODAY;

			$sql = "UPDATE " . CDMTASKS . " SET taskdate = '$taskdate', tasktype = '$tasktype', cmpresent = '$otppl', starttime = '$stime', endtime = '$etime', noofmtgs = '$noofmtgs', 
						resultexpected = '$resultexpected', specificresult = '$specificresult', remarks = '$remarks', modifiedby = '$userid', modifieddate = '$today', 
						achieved = '$resultachieve', status = '$status' 
					WHERE " . CDMTASKS . ".taskid = '$taskid' ";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func updateTask()!" . $this->cn->error;
				goto exitme;
			}

			$specificres = "";
			if(!empty($specificresult)){
				$specificres = " about ". $specificresult;
			}
			$cmpres = "";
			if(!empty($otppl)){
				$cmpres = " with " . $otppl;
			}
			$taskdt = " on " . formatDate("D d M y",$taskdate);

			// save activity

			if(!empty($remarks)){
				$rem = ' Discussions/Remarks: ' . $remarks . '.';
			} else {
				$rem = "";
			}


			$actdata['type'] = $tasktype;
			if ($resultachieve == 'y'){
				$actdata['details'] = 'Task '. $action .' to '. strtolower($tasktypedesc) .' <a href="cdm.php?id='. $sesid .'">'. $cltprost . '</a> ' . $cmpres . $specificres . $taskdt . '. ' . $rem . ' RESULT ACHIEVED. ' ;
			}
			elseif ($resultachieve == 'n') {
				$actdata['details'] = 'Task '. $action .' to '. strtolower($tasktypedesc) .' <a href="cdm.php?id='. $sesid .'">'. $cltprost . '</a> ' . $cmpres . $specificres . $taskdt . '. ' . $rem . ' RESULT NOT ACHIEVED. ';
			}
			else {
				$actdata['details'] = 'Task '. $action .' to '. strtolower($tasktypedesc) .' <a href="cdm.php?id='. $sesid .'">'. $cltprost . '</a> ' . $cmpres . $specificres . $taskdt . '. ' . $rem ;
			}
			$actdata['assignedto'] = $assignedto;
			$actdata['abauser'] = $abauser;
			$actdata['userid'] = $userid;
			$actdata['acctid'] = $acctid;

			$acts = new ActivitiesModel;
			$res['act'] = $acts->saveActivity($actdata);
			exitme:
			return $res;
		}

		public function getPendingTasks($acctid){
			$res = array();
			$sql = "SELECT " . CDMTASKS . ".*
						,DATE_FORMAT(" . CDMTASKS . ".taskdate,'%a %d %b %y') as taskdt 
						,a.dddescription as tasktypedesc 
						,b.dddescription as resultexpecteddesc
					FROM " . CDMTASKS . " 
					LEFT JOIN ". DROPDOWNSMST ." a
						ON a.ddid = " . CDMTASKS . ".tasktype AND a.dddisplay = 'cdmtasktypes'
					LEFT JOIN ". DROPDOWNSMST ." b
						ON b.ddid = " . CDMTASKS . ".resultexpected AND b.dddisplay = 'cdmresultexpected'
					WHERE " . CDMTASKS . ".acctid = '$acctid' AND " . CDMTASKS . ".status = 0 
					ORDER BY " . CDMTASKS . ".taskdate ASC ";
			$qry = $this->cn->query($sql);
			$rows = array();
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;

			return $res;
		}

		public function getTask($taskid){
			$res = array();
			$sql = "SELECT " . CDMTASKS . ".*
						,DATE_FORMAT(" . CDMTASKS . ".taskdate,'%a %d %b %y') as taskdt 
						,a.dddescription as tasktypedesc 
						,b.dddescription as resultexpecteddesc
					FROM " . CDMTASKS . " 
					LEFT JOIN ". DROPDOWNSMST ." a
						ON a.ddid = " . CDMTASKS . ".tasktype AND a.dddisplay = 'cdmtasktypes'
					LEFT JOIN ". DROPDOWNSMST ." b
						ON b.ddid = " . CDMTASKS . ".resultexpected AND b.dddisplay = 'cdmresultexpected'
					WHERE " . CDMTASKS . ".taskid = '$taskid' ";
			$qry = $this->cn->query($sql);
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;

			return $res;
		}

		public function saveComments($data){
			$res = array();
			$actdata = array();
			$res['err'] = 0;
			$sesid = $data['sesid'];
			$userid = $data['userid'];
			$abauser = $data['abaini'];
			$acctid = $data['acctid'];
			$cltprost = $data['cltprost'];
			$cmts = $data['comments'];
			$assignedto = $data['assignedto'];
			$today = TODAY;

			// save activity
			$actdata['type'] = "cmts";
			$actdata['details'] = 'Comments for <a href="cdm.php?id='. $sesid .'">'. $cltprost .'</a>: '. $cmts . '.';
			$actdata['assignedto'] = $assignedto;
			$actdata['abauser'] = $abauser;
			$actdata['userid'] = $userid;
			$actdata['acctid'] = $acctid;

			$acts = new ActivitiesModel;
			$res['act'] = $acts->saveActivity($actdata);
			exitme:
			return $res;
		}

		public function getAllTasks($userid){
			$res = array();
			$sql = "SELECT " . CDMTASKS . ".*
						,DATE_FORMAT(" . CDMTASKS . ".taskdate,'%a %d %b %y') as taskdt 
						,a.dddescription as tasktypedesc 
						,b.dddescription as resultexpecteddesc
						,c.businesstype
						,(CASE WHEN c.businesstype = 'c' THEN 'Corporate' ELSE 'Individual' END) AS bustype
						,d.firstname
						,d.lastname
						,d.companyname
						,c.acctid
						,c.sesid AS uid
						,(SELECT COUNT(id) FROM " . CDMOPPS . " WHERE " . CDMOPPS . ".`acctid` = aba_cdm_tasks.`acctid` AND " . CDMOPPS . ".`producttype` = 'm' AND " . CDMOPPS . ".`oppsstatus` IN('p','q','c')) AS medcnt
						,(SELECT COUNT(id) FROM " . CDMOPPS . " WHERE " . CDMOPPS . ".`acctid` = aba_cdm_tasks.`acctid` AND " . CDMOPPS . ".`producttype` = 'l' AND " . CDMOPPS . ".`oppsstatus` IN('p','q','c')) AS lifecnt
						,(SELECT COUNT(id) FROM " . CDMOPPS . " WHERE " . CDMOPPS . ".`acctid` = aba_cdm_tasks.`acctid` AND " . CDMOPPS . ".`producttype` = 'g' AND " . CDMOPPS . ".`oppsstatus` IN('p','q','c')) AS gencnt
					FROM " . CDMTASKS . " 
					LEFT JOIN ". DROPDOWNSMST ." a
						ON a.ddid = " . CDMTASKS . ".tasktype AND a.dddisplay = 'cdmtasktypes'
					LEFT JOIN ". DROPDOWNSMST ." b
						ON b.ddid = " . CDMTASKS . ".resultexpected AND b.dddisplay = 'cdmresultexpected'
					LEFT JOIN ". CDMACCOUNTS ." c 
						ON c.acctid = " . CDMTASKS . ".acctid
					LEFT JOIN ". CDMCONTACTS ." d 
						ON d.ctcid = c.ctcid 
					WHERE " . CDMTASKS . ".userid = '$userid'
					ORDER BY " . CDMTASKS . ".taskdate ASC ";
			$qry = $this->cn->query($sql);
			$rows = array();
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;

			return $res;
		}

		function sortingTask($data){
			$res = array();
			$rows=array();

			$userid = $data['userid'];
			$sortby = $data['sortby'];
			$sortin = $data['sortin'];

			switch ($sortby) {
				case 'taskdate':
					$fieldname = CDMTASKS . ".taskdate $sortin";
					break;
				case 'tasktyp':
					$fieldname = "tasktypedesc $sortin";
					break;
				case 'lname':
					$fieldname = "d.lastname $sortin";
					break;
				case 'fname':
					$fieldname = "d.firstname $sortin";
					break;
				case 'company':
					$fieldname = "d.companyname $sortin";
					break;
				case 'ic':
					$fieldname = "bustype $sortin";
					break;
				case 'resexpected':
					$fieldname = "resultexpecteddesc $sortin";
					break;
				case 'specificres':
					$fieldname = CDMTASKS . ".specificresult $sortin";
					break;
				default:
					break;
			}

			$sql = "SELECT " . CDMTASKS . ".*
						,DATE_FORMAT(" . CDMTASKS . ".taskdate,'%a %d %b %y') as taskdt 
						,a.dddescription as tasktypedesc 
						,b.dddescription as resultexpecteddesc
						,c.businesstype
						,(CASE WHEN c.businesstype = 'c' THEN 'Corporate' ELSE 'Individual' END) AS bustype
						,d.firstname
						,d.lastname
						,d.companyname
						,c.acctid
						,c.sesid AS uid
					FROM " . CDMTASKS . " 
					LEFT JOIN ". DROPDOWNSMST ." a
						ON a.ddid = " . CDMTASKS . ".tasktype AND a.dddisplay = 'cdmtasktypes'
					LEFT JOIN ". DROPDOWNSMST ." b
						ON b.ddid = " . CDMTASKS . ".resultexpected AND b.dddisplay = 'cdmresultexpected'
					LEFT JOIN ". CDMACCOUNTS ." c 
						ON c.acctid = " . CDMTASKS . ".acctid
					LEFT JOIN ". CDMCONTACTS ." d 
						ON d.ctcid = c.ctcid 
					WHERE " . CDMTASKS . ".userid = '$userid'
					ORDER BY $fieldname";
			$qry = $this->cn->query($sql);
			$rows = array();
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;

			return $res;
		}

		function searchTask($data){
			$res = array();
			$rows=array();

			$searchtext =addslashes($data['searchtext']);
			$searchby=$data['searchby'];
			$userid = $data['userid'];
			
			if(!empty($searchtext)){
				switch ($searchby){
					case 'lname':
						$where = " WHERE ". CDMTASKS . ".userid = '$userid' AND d.lastname LIKE '%$searchtext%' ";
						break;
					case 'fname':
						$where = " WHERE " . CDMTASKS . ".userid = '$userid' AND d.firstname LIKE '%$searchtext%' ";
						break;
					case 'company':
						$where = " WHERE " . CDMTASKS . ".userid = '$userid' AND d.companyname LIKE '%$searchtext%' ";
						break;
					case 'tasktype':
						$where = " WHERE " . CDMTASKS . ".userid = '$userid' AND  a.dddescription = '$searchtext' ";
						break;
					case 'resexpected':
						$where = " WHERE " . CDMTASKS . ".userid = '$userid' AND  b.dddescription = '$searchtext' ";
						break;
					// case 'specificres':
					// 	$where = " WHERE " . CDMTASKS . ".userid = '$userid' AND " . CDMTASKS . ".specificresult LIKE '%$searchtext%' ";
					// 	break;
					default:
						break;
				}
			} else {
				$where = " WHERE " . CDMTASKS . ".userid = '$userid' ";
			}

			$sql = "SELECT " . CDMTASKS . ".*
					,DATE_FORMAT(" . CDMTASKS . ".taskdate,'%a %d %b %y') as taskdt 
					,a.dddescription as tasktypedesc 
					,b.dddescription as resultexpecteddesc
					,c.businesstype
					,(CASE WHEN c.businesstype = 'c' THEN 'Corporate' ELSE 'Individual' END) AS bustype
					,d.firstname
					,d.lastname
					,d.companyname
					,c.acctid
					,c.sesid AS uid
				FROM " . CDMTASKS . " 
				LEFT JOIN ". DROPDOWNSMST ." a
					ON a.ddid = " . CDMTASKS . ".tasktype AND a.dddisplay = 'cdmtasktypes'
				LEFT JOIN ". DROPDOWNSMST ." b
					ON b.ddid = " . CDMTASKS . ".resultexpected AND b.dddisplay = 'cdmresultexpected'
				LEFT JOIN ". CDMACCOUNTS ." c 
					ON c.acctid = " . CDMTASKS . ".acctid
				LEFT JOIN ". CDMCONTACTS ." d 
					ON d.ctcid = c.ctcid 
				$where
				ORDER BY " . CDMTASKS . ".taskdate DESC";

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
			$today = formatDate("Y-m-d",TODAY);
			$where="";
			switch ($headerval){
				case 'duetask':
					$where = " WHERE " . CDMTASKS . ".userid = '$userid' AND ". CDMTASKS . ".taskdate < '$today' ";
					break;
				case 'duetodaytask':
					$where = " WHERE " . CDMTASKS . ".userid = '$userid' AND ". CDMTASKS . ".taskdate = '$today' ";
					break;
				case 'ttltasks':
					$where = " WHERE " . CDMTASKS . ".userid = '$userid' ORDER BY ". CDMTASKS . ".taskdate DESC ";
					break;
				case 'ttlcalls':
					$where = " WHERE " . CDMTASKS . ".userid = '$userid' AND a.dddescription = 'Call' ";
					break;
				case 'ttlmtg':
					$where = " WHERE " . CDMTASKS . ".userid = '$userid' AND a.dddescription = 'Meeting' ";
					break;
				case 'ttlcm':
					$where = " WHERE " . CDMTASKS . ".userid = '$userid' AND a.dddescription = 'Call-Meeting' ";
					break;
				default:
					break;
			}
			

			$sql = "SELECT " . CDMTASKS . ".*
					,DATE_FORMAT(" . CDMTASKS . ".taskdate,'%a %d %b %y') as taskdt 
					,a.dddescription as tasktypedesc 
					,b.dddescription as resultexpecteddesc
					,c.businesstype
					,(CASE WHEN c.businesstype = 'c' THEN 'Corporate' ELSE 'Individual' END) AS bustype
					,d.firstname
					,d.lastname
					,d.companyname
					,c.acctid
					,c.sesid AS uid
				FROM " . CDMTASKS . " 
				LEFT JOIN ". DROPDOWNSMST ." a
					ON a.ddid = " . CDMTASKS . ".tasktype AND a.dddisplay = 'cdmtasktypes'
				LEFT JOIN ". DROPDOWNSMST ." b
					ON b.ddid = " . CDMTASKS . ".resultexpected AND b.dddisplay = 'cdmresultexpected'
				LEFT JOIN ". CDMACCOUNTS ." c 
					ON c.acctid = " . CDMTASKS . ".acctid
				LEFT JOIN ". CDMCONTACTS ." d 
					ON d.ctcid = c.ctcid 
				$where ";
				// ORDER BY " . CDMTASKS . ".taskdate DESC";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func filterHeaderTask()! " . $this->cn->error;
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

		function BulkUpdateTaskDates($data){
			$res = array();
			$rows=array();
			$selecteddata = $data['selecteddata']['selected'];
			$fieldname = $data['fieldname'];
			$datereplace = formatDate("Y-m-d",$data['datereplace']);
			$taskids = implode("','", $selecteddata);

			$sql = "UPDATE " . CDMTASKS . " SET ". CDMTASKS .".$fieldname = '$datereplace' 
				 	WHERE "  . CDMTASKS . ".taskid IN ('$taskids') ";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func BulkUpdateTaskDates()! " . $this->cn->error;
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