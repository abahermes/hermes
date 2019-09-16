<?php
	class UsefulLinkModel extends Database{
		private $db = "";
		private $cn = "";

		function __construct(){
			$this->db = new Database();
			$this->cn = $this->db->connect();
		}


		function getAllUsefulLinks($userid){
			$res = array();
			$rows = array();

			$sql = "SELECT " .USEFULINKS. ".* 
					FROM " .USEFULINKS. " 
					WHERE " .USEFULINKS. ".userid = '$userid'  AND " .USEFULINKS. ".status = 0   
					ORDER BY " .USEFULINKS. ".category ASC ";

			$qry = $this->cn->query($sql);
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;
			$this->cn->close();

			return $res;
		}

		function getUsefulLinkData($data){
			$res = array();
			$rows = array();

			$userid = $data['userid'];
			$usefullinkid = $data['usefullinkid'];

			$sql = "SELECT " .USEFULINKS. ".* 
					FROM " .USEFULINKS. " 
					WHERE " .USEFULINKS. ".userid = '$userid'  AND " .USEFULINKS. ".id = '$usefullinkid' AND " .USEFULINKS. ".status = 0 
					ORDER BY " .USEFULINKS. ".category ASC ";

			$qry = $this->cn->query($sql);
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;
			$this->cn->close();

			return $res;
		}

		function saveUsefulLink($data){
			$res = array();
			$rows = array();

			$userid = $data['userid'];
			$cat = addslashes($data['cat']);
			$fumtext = $data['fumtext'] == "" ? "" : addslashes($data['fumtext']);
			$fumlink = $data['fumlink'] == "" ? "" : addslashes($data['fumlink']);
			$today = TODAY;

			$sql = "INSERT INTO " .USEFULINKS. " (category,fumname,fumlink,userid,createdby,createddate) 
					VALUES ('$cat','$fumtext','$fumlink','$userid','$userid','$today')";

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func saveUsefulLink()!". $this->cn->error;
				goto exitme;
			}
			exitme:
			return $res;
		}

		function updateUsefulLink($data){
			$res = array();
			$rows = array();

			$userid = $data['userid'];
			$ulid = $data['ulid'];
			$cat = addslashes($data['cat']);
			$fumtext = $data['fumtext'] == "" ? "" : addslashes($data['fumtext']);
			$fumlink = $data['fumlink'] == "" ? "" : addslashes($data['fumlink']);
			$today = TODAY;

			$sql = "UPDATE " .USEFULINKS. "
					SET " .USEFULINKS. ".category = '$cat',
						" .USEFULINKS. ".fumname = '$fumtext',
					    " .USEFULINKS. ".fumlink = '$fumlink',
					    " .USEFULINKS. ".modifiedby = '$userid',
					    " .USEFULINKS. ".modifieddate = '$today' 
					WHERE " .USEFULINKS. ".id = '$ulid' " ;

			$qry = $this->cn->query($sql);
			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "An error occured in func updateUsefulLink()!". $this->cn->error;
				goto exitme;
			}
			exitme:
			return $res;
		}

		function searchUsefulLink($data){
			$res = array();
			$rows = array();

			$userid=$data['userid'];
			$searchtask=addslashes($data['searchtask']);
			$searchby=$data['searchby'];

			if(!empty($searchtask)){
				switch ($searchby) {
					case 'usefullink':
						$where = "WHERE " .USEFULINKS. ".userid = '$userid'  AND " .USEFULINKS. ".fumname LIKE '%$searchtask%'  AND " .USEFULINKS. ".status = 0  ORDER BY " .USEFULINKS. ".category ASC ";
						break;
					case 'category':
						$where = "WHERE " .USEFULINKS. ".userid = '$userid'  AND " .USEFULINKS. ".category = '$searchtask' AND " .USEFULINKS. ".status = 0 ";
						break;
					default:
						break;
				}
			} 
			else {
				$where = "WHERE " .USEFULINKS. ".userid = '$userid' AND " .USEFULINKS. ".status = 0  ORDER BY " .USEFULINKS. ".category ASC  ";
			}

			$sql = "SELECT " .USEFULINKS. ".* 
					FROM " .USEFULINKS. " 
					$where";
					


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