<?php
	// include_once('auditlogs.php');
	class AccountsModel extends Database{

		private $db = "";
		private $cn = "";

		function __construct(){
			$this->db = new Database();
			$this->cn = $this->db->connect();
		}

		function genNewAcctNo(){
			$today = formatDate("ym",TODAY);
			$newnno = "";
			$sql = "SELECT COUNT(id) + 1 as idcnt FROM " . CDMACCOUNTS . " WHERE DATE_FORMAT(" . CDMACCOUNTS . ".createddate,'%y%m') = '$today'";
			$qry = $this->cn->query($sql);
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$cnt = $row['idcnt'];
			}

			$pre = "ACC" . formatDate("ym",TODAY) . "000";
			switch(strlen($cnt)){
				// case 4:
				// 	$newno = substr($pre, 0, -3) . $cnt; break;
				case 3:
					$newno = substr($pre, 0, -3) . $cnt; break;
				case 2:
					$newno = substr($pre, 0, -2) . $cnt; break;
				default:
					$newno = substr($pre, 0, -1) . $cnt; break;
			}

			return $newno;
		}

		public function saveAccount($data){
			$res = array();
			$res['err'] = 0;
			$acctid = "";
			$sesid = "";
			$userid = $data['userid'];
			$acctid = $userid . $this->genNewAcctNo();
			$sesid = genuri($acctid);

			$ctcid = $data['ctcid'];
			$fn = $data['firstname'] == "" ? "" : $data['firstname'];
			$mn = $data['middlename'] == "" ? "" : $data['middlename'];
			$ln = $data['lastname'] == "" ? "" : $data['lastname'];
			$bustype = $data['businesstype'] == "" ? "" : $data['businesstype'];
			$affinity = $data['affinity'] == "" ? "" : $data['affinity'];
			$recomby = $data['recomby'] == "" ? "" : $data['recomby'];
			$recomname = $data['recomname'] == "" ? "" : $data['recomname'];
			$abainiofc = $data['abainiofc'] == "" ? "" : $data['abainiofc'];
			$introducer = $data['introducer'] == "" ? "" : $data['introducer'];
			$shared = $data['shared'] == "" ? "" : $data['shared'];
			$salesofc = $data['salesofc'] == "" ? "" : $data['salesofc'];
			$fumlink = $data['fumlink'] == "" ? "" : $data['fumlink'];
			$galinfo1 = $data['galinfo1'] == "" ? "" : $data['galinfo1'];
			$galinfo2 = $data['galinfo2'] == "" ? "" : $data['galinfo2'];
			$galinfo3 = $data['galinfo3'] == "" ? "" : $data['galinfo3'];
			$galinfo4 = $data['galinfo4'] == "" ? "" : $data['galinfo4'];
			$galinfo5 = $data['galinfo5'] == "" ? "" : $data['galinfo5'];
			$assignedto = $data['assignedto'] == "" ? "" : $data['assignedto'];

			$abauser = $data['abauser'];
			$today = TODAY;

			$sql = "INSERT INTO " . CDMACCOUNTS . " (ctcid,acctid,businesstype,affinity,recommendedby,recommendedname,abainiofc,introducer,sharedwith,fumlink,galinfo1,galinfo2,galinfo3,galinfo4,galinfo5,assignedto,createdby,createddate,sesid,userid,salesoffice) 
					VALUES('$ctcid','$acctid','$bustype','$affinity','$recomby','$recomname','$abainiofc','$introducer','$shared','$fumlink','$galinfo1','$galinfo2','$galinfo3','$galinfo4','$galinfo5','$userid','$userid','$today','$sesid','$userid','$salesofc') ";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['sesid'] = "";
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func saveAccount()! " . $this->cn->error;
				goto exitme;
			}

			// save activity
			$n = $fn .' ' . $ln;
			$actdata['type'] = "";
			$actdata['details'] = 'Account <a href="cdm.php?id='. $sesid .'">'. $n .'</a> is created.';
			$actdata['assignedto'] = $assignedto;
			$actdata['abauser'] = $abauser;
			$actdata['userid'] = $userid;
			$actdata['acctid'] = $acctid;

			$acts = new ActivitiesModel;
			$acts->saveActivity($actdata);

			$res['acctid'] = $acctid;
			$res['sesid'] = $sesid;
			exitme:
			return $res;
		}

		public function updateAccount($data){
			$res = array();
			$res['err'] = 0;
			$acctid = "";
			$sesid = "";

			$userid = $data['userid'];
			$acctid = $data['acctid'];
			$fn = $data['firstname'] == "" ? "" : $data['firstname'];
			$mn = $data['middlename'] == "" ? "" : $data['middlename'];
			$ln = $data['lastname'] == "" ? "" : $data['lastname'];
			$bustype = $data['businesstype'] == "" ? "" : $data['businesstype'];
			$affinity = $data['affinity'] == "" ? "" : $data['affinity'];
			$recomby = $data['recomby'] == "" ? "" : $data['recomby'];
			$recomname = $data['recomname'] == "" ? "" : $data['recomname'];
			$abainiofc = $data['abainiofc'] == "" ? "" : $data['abainiofc'];
			$introducer = $data['introducer'] == "" ? "" : $data['introducer'];
			$shared = $data['shared'] == "" ? "" : $data['shared'];
			$salesofc = $data['salesofc'] == "" ? "" : $data['salesofc'];
			$fumlink = $data['fumlink'] == "" ? "" : $data['fumlink'];
			$galinfo1 = $data['galinfo1'] == "" ? "" : $data['galinfo1'];
			$galinfo2 = $data['galinfo2'] == "" ? "" : $data['galinfo2'];
			$galinfo3 = $data['galinfo3'] == "" ? "" : $data['galinfo3'];
			$galinfo4 = $data['galinfo4'] == "" ? "" : $data['galinfo4'];
			$galinfo5 = $data['galinfo5'] == "" ? "" : $data['galinfo5'];
			$assignedto = $data['assignedto'] == "" ? "" : $data['assignedto'];

			$abauser = $data['abauser'];
			$today = TODAY;

			$sql = "UPDATE " . CDMACCOUNTS . " 
					SET " . CDMACCOUNTS . ".businesstype = '$bustype', " . CDMACCOUNTS . ".affinity = '$affinity', " . CDMACCOUNTS . ".recommendedby = '$recomby',
						" . CDMACCOUNTS . ".recommendedname = '$recomname', " . CDMACCOUNTS . ".abainiofc = '$abainiofc', " . CDMACCOUNTS . ".introducer = '$introducer',
						" . CDMACCOUNTS . ".sharedwith = '$shared', " . CDMACCOUNTS . ".fumlink = '$fumlink', " . CDMACCOUNTS . ".salesoffice = '$salesofc', 
						" . CDMACCOUNTS . ".galinfo1 = '$galinfo1', " . CDMACCOUNTS . ".galinfo2 = '$galinfo2', " . CDMACCOUNTS . ".galinfo3 = '$galinfo3',
						" . CDMACCOUNTS . ".galinfo4 = '$galinfo4', " . CDMACCOUNTS . ".galinfo5 = '$galinfo5',
						" . CDMACCOUNTS . ".assignedto = '$userid', " . CDMACCOUNTS . ".modifiedby = '$userid', " . CDMACCOUNTS . ".modifieddate = '$today' 
					WHERE " . CDMACCOUNTS . ".acctid = '$acctid'";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['sesid'] = "";
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func updateAccount()! " . $this->cn->error;
				goto exitme;
			}

			// save activity
			$n = $fn .' ' . $ln;
			$actdata['type'] = "";
			$actdata['details'] = 'Account <a href="cdm.php?id='. $sesid .'">'. $n .'</a> is updated.';
			$actdata['assignedto'] = $assignedto;
			$actdata['abauser'] = $abauser;
			$actdata['userid'] = $userid;
			$actdata['acctid'] = $acctid;

			$acts = new ActivitiesModel;
			$res['act'] = $acts->saveActivity($actdata);

			exitme:
			return $res;
		}

		public function getAccount($sesid){
			$res = array();
			// (CASE WHEN " .CDMACCOUNTS. ".businesstype = 'c' THEN CONCAT('01 fumclt '))
			$sql = "SELECT " . CDMACCOUNTS . ".*,
						(CASE WHEN " .CDMACCOUNTS. ".businesstype = 'c' THEN CONCAT('01 fumclt ', a.companyname) ELSE CONCAT('01 fumclt ', a.lastname, ' ', a.firstname ) END) as fumname
					FROM " . CDMACCOUNTS . " 
					LEFT JOIN " . CDMCONTACTS . " a 
						ON a.ctcid = " . CDMACCOUNTS . ".ctcid 
					WHERE " . CDMACCOUNTS . ".sesid = '$sesid' 
					LIMIT 0,1 ";
			$qry = $this->cn->query($sql);
			$rows = array();
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}
			$res['rows'] = $rows;

			return $res;
		}

		function genNewGalInfoNo($acctid,$cnt){
			$pre = $acctid . "-GAL-" . formatDate("ym",TODAY) . "00";
			switch(strlen($cnt)){
				case 2:
					$newno = substr($pre, 0, -2) . $cnt; break;
				default:
					$newno = substr($pre, 0, -1) . $cnt; break;
			}

			return $newno;
		}

		public function saveAddtlGalInfo($data){
			$acctid = $data['acctid'];
			$galinfoask = $data['question'];
			$galinfoans = $data['answer'];
			$userid = $data['userid'];
			$cnt = $data['cnt'];
			$galinfoid = $this->genNewGalInfoNo($acctid,$cnt);
			$today = TODAY;

			$sql = "INSERT INTO " . CDMGALINFOS . " (acctid,galinfoid,galinfoask,galinfoans,userid,createdby,createddate) 
					VALUES('$acctid','$galinfoid','$galinfoask','$galinfoans','$userid','$userid','$today') ";

			$qry = $this->cn->query($sql);
		}

		public function getAddtlGalInfo($acctid){
			$res = array();
			$sql = "SELECT " . CDMGALINFOS . ".* FROM " . CDMGALINFOS . " 
					WHERE " . CDMGALINFOS . ".acctid = '$acctid' ";
			$qry = $this->cn->query($sql);
			$rows = array();
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}
			$res['rows'] = $rows;

			return $res;
		}

		public function getAllAccounts($userid){
			$res = array();
			$sql = "SELECT " . CDMACCOUNTS . ".* 
						,b.dddescription AS titledesc
						,a.lastname
						,a.firstname
						,a.middlename
						,a.chinesename
						,a.companyname
						,a.jobtitle 
						,a.emailaddress
						,a.initials
						,(CASE WHEN " . CDMACCOUNTS . ".businesstype = 'c' THEN 'Corporate' ELSE 'Individual' END) AS bustype
						,(CASE WHEN " . CDMACCOUNTS . ".status = 1 THEN 'Client'
							WHEN " . CDMACCOUNTS . ".status = 2 THEN 'Former Client'
							ELSE 'Prospect' END) as accounttypedesc
						,d.description AS natdesc 
					FROM " . CDMACCOUNTS . " 
					LEFT JOIN ". CDMCONTACTS ." a 
						ON a.ctcid = " . CDMACCOUNTS . ".ctcid 
					LEFT JOIN " . CDMLEADS . " c 
						ON c.leadid = a.`leadid`
					LEFT JOIN ". DROPDOWNSMST ." b 
						ON b.ddid = a.title AND b.dddisplay = 'cltprosttitles' 
					LEFT JOIN ". NATIONALITYMST ." d
						ON d.nationalityid = a.nationality
					WHERE " . CDMACCOUNTS . ".userid = '$userid' AND c.status = 1 ORDER BY a.lastname ASC";
			$qry = $this->cn->query($sql);
			$rows = array();
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}
			$res['rows'] = $rows;

			return $res;
		}

		function getSortedCltPros($data){
			$res = array();
			$rows = array();

			$userid = $data['userid'];
			$sortby = $data['sortby'];
			$sortin = $data['sortin'];

			switch ($sortby) {
				case 'fullname':
					$fieldname = "a.lastname $sortin";
					break;
				case 'cnname':
					$fieldname = "a.chinesename $sortin";
					break;
				case 'initials':
					$fieldname = "a.initials $sortin";
					break;
				case 'company':
					$fieldname = "a.companyname $sortin";
					break;
				case 'eadd':
					$fieldname = "a.emailaddress $sortin";
					break;
				case 'jobt':
					$fieldname = "a.jobtitle  $sortin";
					break;
				case 'ic':
					$fieldname = "bustype $sortin";
					break;
				case 'acttype':
					$fieldname = "accounttypedesc $sortin";
					break;
				default:
					break;
			}

			$sql = "SELECT " . CDMACCOUNTS . ".* 
						,b.dddescription AS titledesc
						,a.lastname
						,a.firstname
						,a.middlename
						,a.chinesename
						,a.companyname
						,a.jobtitle 
						,a.emailaddress
						,a.initials
						,(CASE WHEN " . CDMACCOUNTS . ".businesstype = 'c' THEN 'Corporate' ELSE 'Individual' END) AS bustype
						,(CASE WHEN " . CDMACCOUNTS . ".status = 1 THEN 'Client'
							WHEN " . CDMACCOUNTS . ".status = 2 THEN 'Former Client'
							ELSE 'Prospect' END) as accounttypedesc 
					FROM " . CDMACCOUNTS . " 
					LEFT JOIN ". CDMCONTACTS ." a 
						ON a.ctcid = " . CDMACCOUNTS . ".ctcid 
					LEFT JOIN ". DROPDOWNSMST ." b 
						ON b.ddid = a.title AND b.dddisplay = 'cltprosttitles' 
					WHERE " . CDMACCOUNTS . ".userid = '$userid' 
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
				$sql = "SELECT " . CDMACCOUNTS . ".* 
							,b.dddescription AS titledesc
							,a.lastname
							,a.firstname
							,a.middlename
							,a.chinesename
							,a.companyname
							,a.jobtitle 
							,a.emailaddress
							,a.initials
							,(CASE WHEN " . CDMACCOUNTS . ".businesstype = 'c' THEN 'Corporate' ELSE 'Individual' END) AS bustype
							,(CASE WHEN " . CDMACCOUNTS . ".status = 1 THEN 'Client'
								WHEN " . CDMACCOUNTS . ".status = 2 THEN 'Former Client'
								ELSE 'Prospect' END) as accounttypedesc 
						FROM " . CDMACCOUNTS . " 
						LEFT JOIN ". CDMCONTACTS ." a 
							ON a.ctcid = " . CDMACCOUNTS . ".ctcid 
						LEFT JOIN ". DROPDOWNSMST ." b 
							ON b.ddid = a.title AND b.dddisplay = 'cltprosttitles' 
							WHERE " . CDMACCOUNTS . ".userid = '$userid' AND a.lastname LIKE '%$searchtext%' ";
				$sql .= " UNION ";
				$sql .= "SELECT " . CDMACCOUNTS . ".* 
							,b.dddescription AS titledesc
							,a.lastname
							,a.firstname
							,a.middlename
							,a.chinesename
							,a.companyname
							,a.jobtitle 
							,a.emailaddress
							,a.initials
							,(CASE WHEN " . CDMACCOUNTS . ".businesstype = 'c' THEN 'Corporate' ELSE 'Individual' END) AS bustype
							,(CASE WHEN " . CDMACCOUNTS . ".status = 1 THEN 'Client'
								WHEN " . CDMACCOUNTS . ".status = 2 THEN 'Former Client'
								ELSE 'Prospect' END) as accounttypedesc 
						FROM " . CDMACCOUNTS . " 
						LEFT JOIN ". CDMCONTACTS ." a 
							ON a.ctcid = " . CDMACCOUNTS . ".ctcid 
						LEFT JOIN ". DROPDOWNSMST ." b 
							ON b.ddid = a.title AND b.dddisplay = 'cltprosttitles' 
							WHERE " . CDMACCOUNTS . ".userid = '$userid' AND a.firstname LIKE '%$searchtext%' ";
				$sql .= " UNION ";
				$sql .= "SELECT " . CDMACCOUNTS . ".* 
							,b.dddescription AS titledesc
							,a.lastname
							,a.firstname
							,a.middlename
							,a.chinesename
							,a.companyname
							,a.jobtitle 
							,a.emailaddress
							,a.initials
							,(CASE WHEN " . CDMACCOUNTS . ".businesstype = 'c' THEN 'Corporate' ELSE 'Individual' END) AS bustype
							,(CASE WHEN " . CDMACCOUNTS . ".status = 1 THEN 'Client'
								WHEN " . CDMACCOUNTS . ".status = 2 THEN 'Former Client'
								ELSE 'Prospect' END) as accounttypedesc 
						FROM " . CDMACCOUNTS . " 
						LEFT JOIN ". CDMCONTACTS ." a 
							ON a.ctcid = " . CDMACCOUNTS . ".ctcid 
						LEFT JOIN ". DROPDOWNSMST ." b 
							ON b.ddid = a.title AND b.dddisplay = 'cltprosttitles' 
							WHERE " . CDMACCOUNTS . ".userid = '$userid' AND a.chinesename LIKE '%$searchtext%' ";
				$sql .= " UNION ";
				$sql .= "SELECT " . CDMACCOUNTS . ".* 
							,b.dddescription AS titledesc
							,a.lastname
							,a.firstname
							,a.middlename
							,a.chinesename
							,a.companyname
							,a.jobtitle 
							,a.emailaddress
							,a.initials
							,(CASE WHEN " . CDMACCOUNTS . ".businesstype = 'c' THEN 'Corporate' ELSE 'Individual' END) AS bustype
							,(CASE WHEN " . CDMACCOUNTS . ".status = 1 THEN 'Client'
								WHEN " . CDMACCOUNTS . ".status = 2 THEN 'Former Client'
								ELSE 'Prospect' END) as accounttypedesc 
						FROM " . CDMACCOUNTS . " 
						LEFT JOIN ". CDMCONTACTS ." a 
							ON a.ctcid = " . CDMACCOUNTS . ".ctcid 
						LEFT JOIN ". DROPDOWNSMST ." b 
							ON b.ddid = a.title AND b.dddisplay = 'cltprosttitles' 
							WHERE " . CDMACCOUNTS . ".userid = '$userid' AND a.companyname LIKE '%$searchtext%' ";
				$sql .= " UNION ";
				$sql .= "SELECT " . CDMACCOUNTS . ".* 
							,b.dddescription AS titledesc
							,a.lastname
							,a.firstname
							,a.middlename
							,a.chinesename
							,a.companyname
							,a.jobtitle 
							,a.emailaddress
							,a.initials
							,(CASE WHEN " . CDMACCOUNTS . ".businesstype = 'c' THEN 'Corporate' ELSE 'Individual' END) AS bustype
							,(CASE WHEN " . CDMACCOUNTS . ".status = 1 THEN 'Client'
								WHEN " . CDMACCOUNTS . ".status = 2 THEN 'Former Client'
								ELSE 'Prospect' END) as accounttypedesc 
						FROM " . CDMACCOUNTS . " 
						LEFT JOIN ". CDMCONTACTS ." a 
							ON a.ctcid = " . CDMACCOUNTS . ".ctcid 
						LEFT JOIN ". DROPDOWNSMST ." b 
							ON b.ddid = a.title AND b.dddisplay = 'cltprosttitles' 
							WHERE " . CDMACCOUNTS . ".userid = '$userid' AND a.emailaddress LIKE '%$searchtext%' ";
				$sql .= " UNION ";
				$sql .= "SELECT " . CDMACCOUNTS . ".* 
							,b.dddescription AS titledesc
							,a.lastname
							,a.firstname
							,a.middlename
							,a.chinesename
							,a.companyname
							,a.jobtitle 
							,a.emailaddress
							,a.initials
							,(CASE WHEN " . CDMACCOUNTS . ".businesstype = 'c' THEN 'Corporate' ELSE 'Individual' END) AS bustype
							,(CASE WHEN " . CDMACCOUNTS . ".status = 1 THEN 'Client'
								WHEN " . CDMACCOUNTS . ".status = 2 THEN 'Former Client'
								ELSE 'Prospect' END) as accounttypedesc 
						FROM " . CDMACCOUNTS . " 
						LEFT JOIN ". CDMCONTACTS ." a 
							ON a.ctcid = " . CDMACCOUNTS . ".ctcid 
						LEFT JOIN ". DROPDOWNSMST ." b 
							ON b.ddid = a.title AND b.dddisplay = 'cltprosttitles' 
							WHERE " . CDMACCOUNTS . ".userid = '$userid' AND a.jobtitle LIKE '%$searchtext%' ";
			} else {
				$sql = "SELECT " . CDMACCOUNTS . ".* 
						,b.dddescription AS titledesc
						,a.lastname
						,a.firstname
						,a.middlename
						,a.chinesename
						,a.companyname
						,a.jobtitle 
						,a.emailaddress
						,a.initials
						,(CASE WHEN " . CDMACCOUNTS . ".businesstype = 'c' THEN 'Corporate' ELSE 'Individual' END) AS bustype
						,(CASE WHEN " . CDMACCOUNTS . ".status = 1 THEN 'Client'
							WHEN " . CDMACCOUNTS . ".status = 2 THEN 'Former Client'
							ELSE 'Prospect' END) as accounttypedesc 
					FROM " . CDMACCOUNTS . " 
					LEFT JOIN ". CDMCONTACTS ." a 
						ON a.ctcid = " . CDMACCOUNTS . ".ctcid 
					LEFT JOIN ". DROPDOWNSMST ." b 
						ON b.ddid = a.title AND b.dddisplay = 'cltprosttitles' 
					WHERE " . CDMACCOUNTS . ".userid = '$userid' ";
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
			$today = formatDate("Y-m-d",TODAY);
			$where="";

			switch ($headerval){
				case 'ttlctcs':
					$where = " WHERE " . CDMACCOUNTS . ".userid = '$userid' ORDER by a.lastname ASC ";
					break;
				case 'ttlprosts':
					$where = " WHERE " . CDMACCOUNTS . ".userid = '$userid' AND ". CDMACCOUNTS ." .status = 0 ORDER BY a.lastname ASC";
					break;
				case 'ttlclts':
					$where = " WHERE " . CDMACCOUNTS . ".userid = '$userid' AND ". CDMACCOUNTS ." .status = 1 ORDER BY a.lastname ASC";
					break;
				default:
					break;
			}

			$sql = "SELECT " . CDMACCOUNTS . ".* 
						,b.dddescription AS titledesc
						,a.lastname
						,a.firstname
						,a.middlename
						,a.chinesename
						,a.companyname
						,a.jobtitle 
						,a.emailaddress
						,a.initials
						,(CASE WHEN " . CDMACCOUNTS . ".businesstype = 'c' THEN 'Corporate' ELSE 'Individual' END) AS bustype
						,(CASE WHEN " . CDMACCOUNTS . ".status = 1 THEN 'Client'
							WHEN " . CDMACCOUNTS . ".status = 2 THEN 'Former Client'
							ELSE 'Prospect' END) as accounttypedesc 
					FROM " . CDMACCOUNTS . " 
					LEFT JOIN ". CDMCONTACTS ." a 
						ON a.ctcid = " . CDMACCOUNTS . ".ctcid 
					LEFT JOIN ". DROPDOWNSMST ." b 
						ON b.ddid = a.title AND b.dddisplay = 'cltprosttitles' 
					$where ";

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

		function updateAccountStatus($data){
			$res = array();
			$rows = array();
			$status = $data['status'];
			$acctid = $data['acctid'];
			$userid = $data['userid'];
			$today = TODAY;

			$sql = "UPDATE " . CDMACCOUNTS . " 
					SET " . CDMACCOUNTS . ".status = '$status', 
						" . CDMACCOUNTS . ".modifiedby = '$userid', 
						" . CDMACCOUNTS . ".modifieddate = '$today' 
					WHERE " . CDMACCOUNTS . ".acctid = '$acctid'";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['sesid'] = "";
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func updateAccountStatus()! " . $this->cn->error;
				goto exitme;
			}
			exitme:
			return $res;
		}

		function getLeadAccounts($leadid){
			$res = array();
			$sql = "SELECT ". CDMACCOUNTS .".*
					FROM ". CDMACCOUNTS ."
					LEFT JOIN ". CDMCONTACTS ." a
						ON a.`ctcid` = ". CDMACCOUNTS .".`ctcid`
					LEFT JOIN ". CDMLEADS ." b
						ON b.`leadid` = a.`leadid`
					WHERE b.`leadid` = '$leadid'";
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
	}
?>