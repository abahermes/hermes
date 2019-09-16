<?php
	// include_once('auditlogs.php');
	class abaUserModel extends Database{

		private $db = "";
		private $cn = "";

		function __construct(){
			$this->db = new Database();
			$this->cn = $this->db->connect();
		}

		function logMeIn($uname){
			$res = array();
			$rows = array();
			$sql = "SELECT ". ABAPEOPLESMST .".* 
						,". ABAUSER .".`password` 
					FROM ". ABAPEOPLESMST ." 
					LEFT JOIN ". ABAUSER ." 
						ON ". ABAUSER .".`abaini` = ". ABAPEOPLESMST .".`abaini` 
					WHERE ". ABAPEOPLESMST .".`abaini` = '$uname' 
						AND ". ABAPEOPLESMST .".`status` = 1 AND ". ABAPEOPLESMST .".`contactcategory` IN(1,3) ";
			$qry = $this->cn->query($sql);
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;

			return $res;
		}

		function changePassword($data){
			$res = array();
			$rows = array();
			$res['err'] = 0;
			$abaini = $data['abaini'];
			$pw = $data['password'];
			$today = TODAY;

			$sql = "UPDATE ". ABAUSER ." 
					SET ". ABAUSER .".password = '$pw' 
					WHERE ". ABAUSER .".username = '$abaini' AND ". ABAUSER .".status = 1 ";
			$qry = $this->cn->query($sql);

			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "error in changePassword func(). " . $this->cn->error;
			}

			return $res;
		}

		function userLoggedActivity(){
			$res = array();
			$rows = array();
			$res['err'] = 0;

			$sql = "SELECT ". ABAPEOPLESMST .".`fname`,
					      ". ABAPEOPLESMST .".`lname`,
					      ". ABAPEOPLESMST .".`mname`,
					      ". ABAPEOPLESMST .".`webhr_designation`,
					      DATE_FORMAT((SELECT ". CDMACTIVITIES .".`createddate`  
					      FROM ". CDMACTIVITIES ." 
					      WHERE ". CDMACTIVITIES .".`userid` = ". ABAPEOPLESMST .".`userid` 
					      ORDER BY ". CDMACTIVITIES .".`createddate` DESC LIMIT 0,1),'%a %d %b %y %H %I %p') AS last_logged 
					FROM ". ABAPEOPLESMST ." 
					WHERE ". ABAPEOPLESMST .".`webhr_designation` IN('business development director','business development executive','business development manager',
										'general manager beijing','general manager for china','general manager hong kong','general manager singapore')
					     AND ". ABAPEOPLESMST .".`status` = 1 AND ". ABAPEOPLESMST .".`contactcategory` = 1";
			$qry = $this->cn->query($sql);
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;

			if(!$qry){
				$res['err'] = 1;
				$res['errmsg'] = "error in userLoggedActivity func(). " . $this->cn->error;
			}
			return $res;
		}

		public function closeDB(){
			$this->cn->close();
		}
	}
?>