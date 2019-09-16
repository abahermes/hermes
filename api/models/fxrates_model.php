<?php
	// include_once('auditlogs.php');
	class FXRatesModel extends Database{

		private $db = "";
		private $cn = "";

		function __construct(){
			$this->db = new Database();
			$this->cn = $this->db->connect();
		}

		public function getFXRates($data){
			$res = array();
			$res['err'] = 0;
			$fisyr = $data['fisyr'];
			$month = $data['month'];

			if(!empty($month)){
				$period = $fisyr.$month;
				$where = "WHERE " . FXRATESMST . ".period = '$period' ";
			}else{
				$where = "WHERE " . FXRATESMST . ".fiscalyear = '$fisyr' ";
			}

			$sql = "SELECT " . FXRATESMST . ".* 
					FROM " . FXRATESMST . " 
					$where
					ORDER BY " . FXRATESMST . ".period DESC, ccy ASC";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func getFXRates()!";
				goto exitme;
			}
			$rows = array();
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;
			$res['sql'] = $sql;
			exitme:
			return $res;
		}

		public function chkFXRate($fxcode){
			$res = array();
			$res['err'] = 0;

			$sql = "SELECT " . FXRATESMST . ".* 
					FROM " . FXRATESMST . " 
					WHERE " . FXRATESMST . ".fxcode = '$fxcode'";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func chkFXRate()!";
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

		public function saveFXRate($data){
			$res = array();
			$res['err'] = 0;
			$fxcode = $data['fxcode'];
			$period = $data['period'];
			$ccy = $data['ccy'];
			$rate = $data['rate'];
			$fxrate = $data['fxrate'];
			$fisyr = $data['fiscalyear'];
			$cby = $data['abauser'];
			$today = TODAY;

			$sql = "INSERT INTO " . FXRATESMST . " (fxcode,period,ccy,rate,fxrate,fiscalyear,createdby,createddate) 
					VALUES('$fxcode','$period','$ccy','$rate','$fxrate','$fisyr','$cby','$today') ";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func saveFXRate()!";
				goto exitme;
			}
			exitme:
			return $res;
		}

		public function updateFXRate($data){
			$res = array();
			$res['err'] = 0;
			$fxcode = $data['fxcode'];
			$period = $data['period'];
			$ccy = $data['ccy'];
			$rate = $data['rate'];
			$fxrate = $data['fxrate'];
			$fisyr = $data['fiscalyear'];
			$mby = $data['abauser'];
			$today = TODAY;

			$sql = "UPDATE " . FXRATESMST . " 
					SET " . FXRATESMST . ".period = '$period', " . FXRATESMST . ".ccy = '$ccy', " . FXRATESMST . ".rate = '$rate', " . FXRATESMST . ".fxrate = '$fxrate', " . FXRATESMST . ".fiscalyear = '$fisyr', " . FXRATESMST . ".modifiedby = '$mby', " . FXRATESMST . ".modifieddate = '$today' 
					WHERE " . FXRATESMST . ".fxcode = '$fxcode' ";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func updateFXRate()!";
				goto exitme;
			}
			exitme:
			return $res;
		}

		public function setRatesActiveInactive($data){
			$res = array();
			$res['err'] = 0;
			$fxcode = $data['fxcode'];
			$status = $data['status'];
			$mby = $data['abauser'];
			$today = TODAY;

			$sql = "UPDATE " . FXRATESMST . " 
					SET " . FXRATESMST . ".status = '$status', " . FXRATESMST . ".modifiedby = '$mby', " . FXRATESMST . ".modifieddate = '$today' 
					WHERE " . FXRATESMST . ".fxcode = '$fxcode' ";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func setRatesActiveInactive()!";
				goto exitme;
			}
			exitme:
			return $res;
		}

		public function computePremiumHKD($data){
			$res = array();
			$where = "";
			$res['err'] = 0;
			$ccy = $data['ccy'];
			$period = $data['period'];

			if(!empty($period)){
				$todayperiod = formatDate("Ym",TODAY);
				$prevperiod = ($todayperiod - 1);
				$sql = "SELECT " . FXRATESMST . ".* 
					FROM " . FXRATESMST . " 
					WHERE " . FXRATESMST . ".ccy = '$ccy' AND " . FXRATESMST . ".period = '$period' 
					UNION 
					SELECT " . FXRATESMST . ".* 
					FROM " . FXRATESMST . " 
					WHERE " . FXRATESMST . ".ccy = '$ccy' AND " . FXRATESMST . ".period = '$todayperiod' 
					UNION 
					SELECT " . FXRATESMST . ".* 
					FROM " . FXRATESMST . " 
					WHERE " . FXRATESMST . ".ccy = '$ccy' AND " . FXRATESMST . ".period = '$prevperiod' ";
			}else{
				$sql = "SELECT " . FXRATESMST . ".* 
					FROM " . FXRATESMST . " 
					WHERE " . FXRATESMST . ".ccy = '$ccy' 
					ORDER BY " . FXRATESMST . ".period DESC ";
			}

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func chkFXRate()!";
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
	}
?>