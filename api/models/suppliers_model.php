<?php
	// include_once('auditlogs.php');
	class SuppliersModel extends Database{

		private $db = "";
		private $cn = "";

		function __construct(){
			$this->db = new Database();
			$this->cn = $this->db->connect();
		}

		// function genNewAcctNo(){
		// 	$today = formatDate("ym",TODAY);
		// 	$newnno = "";
		// 	$sql = "SELECT COUNT(id) + 1 as idcnt FROM " . CDMACCOUNTS . " WHERE DATE_FORMAT(" . CDMACCOUNTS . ".createddate,'%y%m') = '$today'";
		// 	$qry = $this->cn->query($sql);
		// 	while($row = $qry->fetch_array(MYSQLI_ASSOC)){
		// 		$cnt = $row['idcnt'];
		// 	}

		// 	$pre = "A" . formatDate("ym",TODAY) . "000";
		// 	switch(strlen($cnt)){
		// 		// case 4:
		// 		// 	$newno = substr($pre, 0, -3) . $cnt; break;
		// 		case 3:
		// 			$newno = substr($pre, 0, -3) . $cnt; break;
		// 		case 2:
		// 			$newno = substr($pre, 0, -2) . $cnt; break;
		// 		default:
		// 			$newno = substr($pre, 0, -1) . $cnt; break;
		// 	}

		// 	return $newno;
		// }

		// public function saveAccount($data){
		// 	$res = array();
		// 	$res['err'] = 0;
		// 	$acctid = "";
		// 	$sesid = "";
		// 	$acctid = $this->genNewAcctNo();
		// 	$sesid = genuri($acctid);

		// 	$ctcid = $data['ctcid'];
		// 	$fn = $data['firstname'] == "" ? "" : $data['firstname'];
		// 	$mn = $data['middlename'] == "" ? "" : $data['middlename'];
		// 	$ln = $data['lastname'] == "" ? "" : $data['lastname'];
		// 	$bustype = $data['businesstype'] == "" ? "" : $data['businesstype'];
		// 	$affinity = $data['affinity'] == "" ? "" : $data['affinity'];
		// 	$recomby = $data['recomby'] == "" ? "" : $data['recomby'];
		// 	$recomname = $data['recomname'] == "" ? "" : $data['recomname'];
		// 	$abainiofc = $data['abainiofc'] == "" ? "" : $data['abainiofc'];
		// 	$introducer = $data['introducer'] == "" ? "" : $data['introducer'];
		// 	$shared = $data['shared'] == "" ? "" : $data['shared'];
		// 	// $fumlinktype = $data['fumlinktype'] == "" ? "" : $data['fumlinktype'];
		// 	// $fummainfld = $data['fummainfld'] == "" ? "" : $data['fummainfld'];
		// 	// $fumbustypefld = $data['fumbustypefld'] == "" ? "" : $data['fumbustypefld'];
		// 	// $fumbdfld = $data['fumbdfld'] == "" ? "" : $data['fumbdfld'];
		// 	// $fumcltprostfld = $data['fumcltprostfld'] == "" ? "" : $data['fumcltprostfld'];
		// 	// $fumcltprostname = $data['fumcltprostname'] == "" ? "" : $data['fumcltprostname'];
		// 	$fumlink = $data['fumlink'] == "" ? "" : $data['fumlink'];
		// 	$assignedto = $data['assignedto'] == "" ? "" : $data['assignedto'];

		// 	$abauser = $data['abauser'];
		// 	$today = TODAY;

		// 	$sql = "INSERT INTO " . CDMACCOUNTS . " (ctcid,acctid,businesstype,affinity,recommendedby,recommendedname,abainiofc,introducer,sharedwith,fumlink,assignedto,createdby,createddate,sesid) 
		// 			VALUES('$ctcid','$acctid','$bustype','$affinity','$recomby','$recomname','$abainiofc','$introducer','$shared','$fumlink','$assignedto','$abauser','$today','$sesid') ";

		// 	$qry = $this->cn->query($sql);
		// 	if(!$qry){
		// 		$res['sesid'] = "";
		// 		$res['err'] = 1;
		// 		$res['errmsg'] = "An error occured in func saveAccount()!";
		// 		goto exitme;
		// 	}

		// 	// save activity
		// 	$n = $fn .' ' . $ln;
		// 	$actdata['type'] = "";
		// 	$actdata['details'] = '<p>Prospect <a href="cdm.php?id='. $sesid .'">'. $n .'</a> is created.</p>';
		// 	$actdata['assignedto'] = $assignedto;
		// 	$actdata['abauser'] = $abauser;
		// 	$actdata['acctid'] = $acctid;

		// 	$acts = new ActivitiesModel;
		// 	$res['act'] = $acts->saveActivity($actdata);

		// 	$res['sesid'] = $sesid;
		// 	exitme:
		// 	return $res;
		// }

		public function getSuppliers($supid=""){
			$where = "WHERE 1 ";
			if(!empty($supid)){
				$where .= SUPPLIERS . ".supplierid = '$supid' ";
			}
			$res = array();
			$sql = "SELECT * FROM " . SUPPLIERS . " 
					$where 
					ORDER BY " . SUPPLIERS . ".name ";
			$qry = $this->cn->query($sql);
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