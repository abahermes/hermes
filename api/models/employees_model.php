<?php
	// include_once('auditlogs.php');
	class EmployeesModel extends Database{

		private $db = "";
		private $cn = "";

		function __construct(){
			$this->db = new Database();
			$this->cn = $this->db->connect();
		}
		function setInsertId($id){
			$this->id = $id;
		}
		public function getInsertId(){
			return $this->id;
		}
		// SAVE ABBREVIATION
		public function saveabaPeople($data){
			$eeid = !empty($data['eeid']) ? $data['eeid'] : "";
			$sal = !empty($data['salutation']) ? $data['salutation'] : "";
			$abaini = strtolower($data['abaini']);
			$fname = ucfirst($data['fname']);
			$mname = !empty($data['mname']) ? ucfirst($data['mname']) : "";
			$lname = strtoupper($data['lname']);
			$cnname = !empty($data['cnname']) ? $data['cnname'] : "";
			$email = !empty($data['email']) ? strtolower($data['email']) : "";
			$joindt = !empty($data['joineddate']) ? formatDate("Y-m-d",$data['joineddate']) : "";
			$gender = !empty($data['gender']) ? $data['gender'] : "";
			$bdate = !empty($data['birthdate']) ? formatDate("Y-m-d",$data['birthdate']) : "";
			$mobno = !empty($data['mobileno']) ? $data['mobileno'] : "";
			$degree = !empty($data['degree']) ? $data['degree'] : "";
			$desig = !empty($data['designation']) ? $data['designation'] : "";
			$dept = !empty($data['department']) ? $data['department'] : "";
			$salesofc = !empty($data['salesoffice']) ? $data['salesoffice'] : "";
			$eetype = !empty($data['eetype']) ? $data['eetype'] : "";
			$eecat = !empty($data['eecategory']) ? $data['eecategory'] : "";
			$bloodtype = !empty($data['bloodtype']) ? $data['bloodtype'] : "";
			$nat = !empty($data['nationality']) ? $data['nationality'] : "";
			$rel = !empty($data['religion']) ? $data['religion'] : "";
			$marital = !empty($data['maritalstatus']) ? $data['maritalstatus'] : "";
			$country = !empty($data['country']) ? $data['country'] : "";

			$emerconperson = !empty($data['emerconperson']) ? $data['emerconperson'] : null;
			$emerconaddress = !empty($data['emerconaddress']) ? $data['emerconaddress'] : null;
			$emerconrel = !empty($data['emerconrelationship']) ? $data['emerconrelationship'] : null;
			$emerconno = !empty($data['emerconno']) ? $data['emerconno'] : null;
			
			$abaUser = $data['abaUser'];
			$today = $data['today'];
			
			$sql = "INSERT INTO " . ABAPEOPLESMST . " (eeid,salutation,abaini,fname,mname,lname,cnname,email,birthdate,mobileno,joineddate,webhr_eecategory,webhr_designation,webhr_company,webhr_station,webhr_department,webhr_gender,,createdby,createddate)
					VALUES('$abaUser','$today')";

			$qry = $this->cn->query($sql);
			if(!$qry){
				echo $this->cn->error;
				exit();
			}
			$id = $this->cn->insert_id;
			$this->setInsertId($id);

			$this->cn->close();

			// AUDIT LOGS
			$adtlogs = array();
			$adtlogs['method'] = "CREATE";
			$adtlogs['pname'] = "abapeople";
			$adtlogs['dtl1'] = $sql;
			$adtlogs['dtl2'] = "";
			$adtlogs['tbl'] = ABAPEOPLESMST;
			$adtlogs['rid'] = $id;
			$adtlogs['abaUser'] = $abaUser;
			$adtlogs['today'] = $today;

			$adt = new AuditLogs;
			$adt->saveAuditLog($adtlogs);
		}

		// // UPDATE ABBREVIATION
		// public function updateAbvt($data){
		// 	$id = $data['id'];
		// 	$abvt = $data['txtAbvt'];
		// 	$word = $data['txtName'];
		// 	$cnword = $data['txtCNName'];
		// 	$desc = addslashes($data['txtDesc']);
		// 	$cat = $data['txtCat'];
		// 	$stat = $data['txtStat'];
		// 	$abaUser = $data['abaUser'];
		// 	$today = $data['today'];
			
		// 	$sql = "UPDATE " . ABBREVIATIONSMST . " SET abvt = '$abvt', word = '$word', cnword = '$cnword', description = '$desc', category = '$cat', status = '$stat', modifiedby = '$abaUser', modifieddate = '$today' WHERE id = '$id'";
			
		// 	$qry = $this->cn->query($sql);
		// 	if(!$qry){
		// 		echo $this->cn->error;
		// 		exit();
		// 	}

		// 	$this->cn->close();

		// 	// AUDIT LOGS
		// 	$adtlogs = array();
		// 	$adtlogs['method'] = "UPDATE";
		// 	$adtlogs['pname'] = "abbreviation";
		// 	$adtlogs['dtl1'] = $sql;
		// 	$adtlogs['dtl2'] = "";
		// 	$adtlogs['tbl'] = ABBREVIATIONSMST;
		// 	$adtlogs['rid'] = $id;
		// 	$adtlogs['abaUser'] = $abaUser;
		// 	$adtlogs['today'] = $today;

		// 	$adt = new AuditLogs;
		// 	$adt->saveAuditLog($adtlogs);
		// }

		// GET DATA by ALL or ID
		public function getabaPeople($id=""){
			$where = "WHERE 1 ";
			if(!empty($id)){
				$where .= " AND " . ABAPEOPLESMST . ".id = '$id'";
			}
			$sql = "SELECT z.* FROM ((SELECT " . ABAPEOPLESMST . ".*,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						," . DESIGNATIONSMST . ".description as designationname
						," . SALESOFFICESMST . ".description as salesofficename
						,a.dddescription as title
					FROM " . ABAPEOPLESMST
					. " LEFT JOIN " . DESIGNATIONSMST . " ON " . DESIGNATIONSMST . ".`id` = " . ABAPEOPLESMST . ".`designation` "
					. " LEFT JOIN " . SALESOFFICESMST . " ON " . SALESOFFICESMST . ".`id` = " . ABAPEOPLESMST . ".`salesoffice` "
					. " LEFT JOIN " . DROPDOWNSMST . " a ON a.ddid = " . ABAPEOPLESMST . ".`salutation` AND a.dddisplay = 'eesalutation' "
					. $where . " AND " . ABAPEOPLESMST . ".status = 1"
					. " ORDER BY " . ABAPEOPLESMST . ".`abaini`)";

			$sql .= " UNION ALL (SELECT " . ABAPEOPLESMST . ".*,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						," . DESIGNATIONSMST . ".description as designationname
						," . SALESOFFICESMST . ".description as salesofficename
						,a.dddescription as title
					FROM " . ABAPEOPLESMST
					. " LEFT JOIN " . DESIGNATIONSMST . " ON " . DESIGNATIONSMST . ".`id` = " . ABAPEOPLESMST . ".`designation` "
					. " LEFT JOIN " . SALESOFFICESMST . " ON " . SALESOFFICESMST . ".`id` = " . ABAPEOPLESMST . ".`salesoffice` "
					. " LEFT JOIN " . DROPDOWNSMST . " a ON a.ddid = " . ABAPEOPLESMST . ".`salutation` AND a.dddisplay = 'eesalutation' "
					. $where . " AND " . ABAPEOPLESMST . ".status = 0"
					. " ORDER BY " . ABAPEOPLESMST . ".`abaini`)) AS z ORDER BY z.fname";
			
			$rows = array();
			$qry = $this->cn->query($sql);
			if(!$qry){
				echo $this->cn->error;
				exit();
			}
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$this->cn->close();
			return $rows;
		}

		public function getActiveabaPeople($id=""){
			$where = "";
			$sql = "SELECT " . ABAPEOPLESMST . ".*
						,CONCAT(
							(CASE WHEN " . ABAPEOPLESMST . ".fname != '' THEN " . ABAPEOPLESMST . ".fname ELSE '' END),' '
							,(CASE WHEN " . ABAPEOPLESMST . ".mname != '' THEN " . ABAPEOPLESMST . ".mname ELSE '' END),' '
							,(CASE WHEN " . ABAPEOPLESMST . ".lname != '' THEN " . ABAPEOPLESMST . ".lname ELSE '' END)) as eename
						,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						," . DESIGNATIONSMST . ".description as designationname
						," . SALESOFFICESMST . ".description as salesofficename
					FROM " . ABAPEOPLESMST
					. " LEFT JOIN " . DESIGNATIONSMST . " ON " . DESIGNATIONSMST . ".`id` = " . ABAPEOPLESMST . ".`designation` "
					. " LEFT JOIN " . SALESOFFICESMST . " ON " . SALESOFFICESMST . ".`id` = " . ABAPEOPLESMST . ".`salesoffice` "
					. " WHERE " . ABAPEOPLESMST . ".status = 1 AND " . ABAPEOPLESMST . ".contactcategory = 1"
					. " ORDER BY " . ABAPEOPLESMST . ".`abaini`";
			
			$rows = array();
			$qry = $this->cn->query($sql);
			if(!$qry){
				echo $this->cn->error;
				exit();
			}
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			// $this->cn->close();
			return $rows;
		}

		public function getActiveabaPeopleWithId($id){
			// $where .= " AND " . ABAPEOPLESMST . ".userid = '$id'";
			$sql = "SELECT " . ABAPEOPLESMST . ".*
						,CONCAT(
							(CASE WHEN " . ABAPEOPLESMST . ".fname != '' THEN " . ABAPEOPLESMST . ".fname ELSE '' END),' '
							,(CASE WHEN " . ABAPEOPLESMST . ".mname != '' THEN " . ABAPEOPLESMST . ".mname ELSE '' END),' '
							,(CASE WHEN " . ABAPEOPLESMST . ".lname != '' THEN " . ABAPEOPLESMST . ".lname ELSE '' END)) as eename
						,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						," . DESIGNATIONSMST . ".description as designationname
						," . SALESOFFICESMST . ".description as salesofficename
					FROM " . ABAPEOPLESMST. 
					" LEFT JOIN " . DESIGNATIONSMST . " ON " . DESIGNATIONSMST . ".id = " . ABAPEOPLESMST . ".designation 
					  LEFT JOIN " . SALESOFFICESMST . " ON " . SALESOFFICESMST . ".id = " . ABAPEOPLESMST . ".salesoffice 
					 WHERE " . ABAPEOPLESMST . ".userid = '$id' ";
			
			$rows = array();
			$qry = $this->cn->query($sql);
			if(!$qry){
				echo $this->cn->error;
				exit();
			}
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			// $this->cn->close();
			return $rows;
		}

		// SEARCH DATA
		public function searchAbacarian($val){
			$data = strtolower($val['txtData']);

			// SQL abaini
			$sql = "SELECT " . ABAPEOPLESMST . ".*,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						," . DESIGNATIONSMST . ".description as designationname
						," . SALESOFFICESMST . ".description as salesofficename
						,CONCAT(" . ABAPEOPLESMST . ".fname,' '," . ABAPEOPLESMST . ".mname,' '," . ABAPEOPLESMST . ".lname) as eename
						,a.dddescription as title
					FROM " . ABAPEOPLESMST
					. " LEFT JOIN " . DESIGNATIONSMST . " ON " . DESIGNATIONSMST . ".`id` = " . ABAPEOPLESMST . ".`designation` "
					. " LEFT JOIN " . SALESOFFICESMST . " ON " . SALESOFFICESMST . ".`id` = " . ABAPEOPLESMST . ".`salesoffice` "
					. " LEFT JOIN " . DROPDOWNSMST . " a ON a.ddid = " . ABAPEOPLESMST . ".`salutation` AND a.dddisplay = 'eesalutation' "
					. " WHERE " . ABAPEOPLESMST . ".abaini = '$data'";
			$sql .= " UNION ";
			$sql .= "SELECT " . ABAPEOPLESMST . ".*,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						," . DESIGNATIONSMST . ".description as designationname
						," . SALESOFFICESMST . ".description as salesofficename
						,CONCAT(" . ABAPEOPLESMST . ".fname,' '," . ABAPEOPLESMST . ".mname,' '," . ABAPEOPLESMST . ".lname) as eename
						,a.dddescription as title
					FROM " . ABAPEOPLESMST
					. " LEFT JOIN " . DESIGNATIONSMST . " ON " . DESIGNATIONSMST . ".`id` = " . ABAPEOPLESMST . ".`designation` "
					. " LEFT JOIN " . SALESOFFICESMST . " ON " . SALESOFFICESMST . ".`id` = " . ABAPEOPLESMST . ".`salesoffice` "
					. " LEFT JOIN " . DROPDOWNSMST . " a ON a.ddid = " . ABAPEOPLESMST . ".`salutation` AND a.dddisplay = 'eesalutation' "
					. " WHERE " . ABAPEOPLESMST . ".abaini LIKE '$data%'";
			$sql .= " UNION ";
			$sql .= "SELECT " . ABAPEOPLESMST . ".*,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						," . DESIGNATIONSMST . ".description as designationname
						," . SALESOFFICESMST . ".description as salesofficename
						,CONCAT(" . ABAPEOPLESMST . ".fname,' '," . ABAPEOPLESMST . ".mname,' '," . ABAPEOPLESMST . ".lname) as eename
						,a.dddescription as title
					FROM " . ABAPEOPLESMST
					. " LEFT JOIN " . DESIGNATIONSMST . " ON " . DESIGNATIONSMST . ".`id` = " . ABAPEOPLESMST . ".`designation` "
					. " LEFT JOIN " . SALESOFFICESMST . " ON " . SALESOFFICESMST . ".`id` = " . ABAPEOPLESMST . ".`salesoffice` "
					. " LEFT JOIN " . DROPDOWNSMST . " a ON a.ddid = " . ABAPEOPLESMST . ".`salutation` AND a.dddisplay = 'eesalutation' "
					. " WHERE " . ABAPEOPLESMST . ".abaini LIKE '%$data%'";
			$sql .= " UNION ";

			// SQL NAME
			$sql .= "SELECT " . ABAPEOPLESMST . ".*,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						," . DESIGNATIONSMST . ".description as designationname
						," . SALESOFFICESMST . ".description as salesofficename
						,CONCAT(" . ABAPEOPLESMST . ".fname,' '," . ABAPEOPLESMST . ".mname,' '," . ABAPEOPLESMST . ".lname) as eename
						,a.dddescription as title
					FROM " . ABAPEOPLESMST
					. " LEFT JOIN " . DESIGNATIONSMST . " ON " . DESIGNATIONSMST . ".`id` = " . ABAPEOPLESMST . ".`designation` "
					. " LEFT JOIN " . SALESOFFICESMST . " ON " . SALESOFFICESMST . ".`id` = " . ABAPEOPLESMST . ".`salesoffice` "
					. " LEFT JOIN " . DROPDOWNSMST . " a ON a.ddid = " . ABAPEOPLESMST . ".`salutation` AND a.dddisplay = 'eesalutation' "
					. " WHERE (" . ABAPEOPLESMST . ".fname = '$data' OR " . ABAPEOPLESMST . ".mname = '$data' OR " . ABAPEOPLESMST . ".lname = '$data')";
			$sql .= " UNION ";
			$sql .= "SELECT " . ABAPEOPLESMST . ".*,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						," . DESIGNATIONSMST . ".description as designationname
						," . SALESOFFICESMST . ".description as salesofficename
						,CONCAT(" . ABAPEOPLESMST . ".fname,' '," . ABAPEOPLESMST . ".mname,' '," . ABAPEOPLESMST . ".lname) as eename
						,a.dddescription as title
					FROM " . ABAPEOPLESMST
					. " LEFT JOIN " . DESIGNATIONSMST . " ON " . DESIGNATIONSMST . ".`id` = " . ABAPEOPLESMST . ".`designation` "
					. " LEFT JOIN " . SALESOFFICESMST . " ON " . SALESOFFICESMST . ".`id` = " . ABAPEOPLESMST . ".`salesoffice` "
					. " LEFT JOIN " . DROPDOWNSMST . " a ON a.ddid = " . ABAPEOPLESMST . ".`salutation` AND a.dddisplay = 'eesalutation' "
					. " WHERE (" . ABAPEOPLESMST . ".fname LIKE '$data%' OR " . ABAPEOPLESMST . ".mname LIKE '$data%' OR " . ABAPEOPLESMST . ".lname LIKE '$data%')";
			$sql .= " UNION ";
			$sql .= "SELECT " . ABAPEOPLESMST . ".*,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						," . DESIGNATIONSMST . ".description as designationname
						," . SALESOFFICESMST . ".description as salesofficename
						,CONCAT(" . ABAPEOPLESMST . ".fname,' '," . ABAPEOPLESMST . ".mname,' '," . ABAPEOPLESMST . ".lname) as eename
						,a.dddescription as title
					FROM " . ABAPEOPLESMST
					. " LEFT JOIN " . DESIGNATIONSMST . " ON " . DESIGNATIONSMST . ".`id` = " . ABAPEOPLESMST . ".`designation` "
					. " LEFT JOIN " . SALESOFFICESMST . " ON " . SALESOFFICESMST . ".`id` = " . ABAPEOPLESMST . ".`salesoffice` "
					. " LEFT JOIN " . DROPDOWNSMST . " a ON a.ddid = " . ABAPEOPLESMST . ".`salutation` AND a.dddisplay = 'eesalutation' "
					. " WHERE (" . ABAPEOPLESMST . ".fname LIKE '%$data%' OR " . ABAPEOPLESMST . ".mname LIKE '%$data%' OR " . ABAPEOPLESMST . ".lname LIKE '%$data%')";

			$qry = $this->cn->multi_query($sql);
			if(!$qry){
				echo $this->cn->error;
				exit();
			}
			
			$rows = array();
			if($res = $this->cn->store_result()){
				while($row = $res->fetch_assoc()){
					$rows[] = $row;
				}
			}

			$this->cn->close();
			return $rows;
		}

		function chkDuplicateAbvt($val){

			$sql = "SELECT " . ABBREVIATIONSMST .".*," . CATEGORIESMST . ".name as categoryname FROM " . ABBREVIATIONSMST
				. " LEFT JOIN " . CATEGORIESMST . " ON " . CATEGORIESMST . ".`id` = " . ABBREVIATIONSMST . ".`category` "
				. " WHERE " . ABBREVIATIONSMST . ".abvt = '$val'";

			$qry = $this->cn->query($sql);
			if(!$qry){
				echo $this->cn->error;
				exit();
			}

			$rows = array();
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$this->cn->close();
			return $rows;
		}

		function chkDuplicateAbvtName($val){

			$sql = "SELECT " . ABBREVIATIONSMST .".*," . CATEGORIESMST . ".name as categoryname FROM " . ABBREVIATIONSMST
				. " LEFT JOIN " . CATEGORIESMST . " ON " . CATEGORIESMST . ".`id` = " . ABBREVIATIONSMST . ".`category` "
				. " WHERE " . ABBREVIATIONSMST . ".word = '$val'";

			$qry = $this->cn->query($sql);
			if(!$qry){
				echo $this->cn->error;
				exit();
			}

			$rows = array();
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$this->cn->close();
			return $rows;
		}

		function chkDuplicateAbvtName1($a,$n){
			$sql = "";
			$sql = "SELECT " . ABBREVIATIONSMST .".*," . CATEGORIESMST . ".name as categoryname FROM " . ABBREVIATIONSMST
				. " LEFT JOIN " . CATEGORIESMST . " ON " . CATEGORIESMST . ".`id` = " . ABBREVIATIONSMST . ".`category` "
				. " WHERE " . ABBREVIATIONSMST . ".abvt = '$a'";
			$sql .= " UNION ";
			$sql .= "SELECT " . ABBREVIATIONSMST .".*," . CATEGORIESMST . ".name as categoryname FROM " . ABBREVIATIONSMST
				. " LEFT JOIN " . CATEGORIESMST . " ON " . CATEGORIESMST . ".`id` = " . ABBREVIATIONSMST . ".`category` "
				. " WHERE " . ABBREVIATIONSMST . ".word = '$n'";

			$qry = $this->cn->query($sql);
			if(!$qry){
				echo $this->cn->error;
				exit();
			}

			$rows = array();
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$this->cn->close();
			return $rows;
		}

		public function saveImportedabaPeople($data){
			$sql2 = null;
			$abaini = isset($data['abaini']) ? strtolower($data['abaini']) : null;
			$eetype = isset($data['eetype']) ? strtolower($data['eetype']) : null;
			$eecat = isset($data['eecategory']) ? strtolower($data['eecategory']) : null;
			$designation = isset($data['designation']) ? strtolower($data['designation']) : null;
			$company = isset($data['company']) ? strtolower($data['company']) : null;
			$station = isset($data['station']) ? strtolower($data['station']) : null;
			$department = isset($data['department']) ? strtolower($data['department']) : null;
			$fname = isset($data['fname']) ? ucfirst($data['fname']) : null;
			$lname = isset($data['lname']) ? strtoupper($data['lname']) : null;
			$mname = isset($data['mname']) ? strtoupper($data['mname']) : null;
			$eename = $fname . " " . $lname;
			$email = isset($data['email']) ? strtolower($data['email']) : null;
			$address = isset($data['address']) ? addslashes($data['address']) : null;
			$city = isset($data['city']) ? $data['city'] : null;
			$state = isset($data['state']) ? $data['state'] : null;
			$zipcode = isset($data['zipcode']) ? $data['zipcode'] : null;
			$country = isset($data['country']) ? $data['country'] : null;
			$presentaddr = isset($data['presentaddr']) ? addslashes($data['presentaddr']) : null;
			$presentcity = isset($data['presentcity']) ? $data['presentcity'] : null;
			$presentstate = isset($data['presentstate']) ? $data['presentstate'] : null;
			$presentzipcode = isset($data['presentzipcode']) ? $data['presentzipcode'] : null;
			$presentcountry = isset($data['presentcountry']) ? $data['presentcountry'] : null;
			$homephoneno = isset($data['homephoneno']) ? $data['homephoneno'] : null;
			$officephoneno = isset($data['officephoneno']) ? $data['officephoneno'] : null;
			$telext = isset($data['telext']) ? $data['telext'] : null;
			$mobileno = isset($data['mobileno']) ? $data['mobileno'] : null;
			$gender = isset($data['gender']) ? $data['gender'] : null;
			$birthdate = isset($data['birthdate']) ? formatDate("Y-m-d",$data['birthdate']) : null;
			$joineddate = isset($data['joineddate']) ? formatDate("Y-m-d",$data['joineddate']) : null;
			$passportno = isset($data['passportno']) ? $data['passportno'] : null;
			$passportexpiry = isset($data['passportexpiry']) ? formatDate("Y-m-d",$data['passportexpiry']) : null;
			$drivinglicenseno = isset($data['drivinglicenseno']) ? $data['drivinglicenseno'] : null;
			$drivinglicenseexpiry = isset($data['drivinglicenseexpiry']) ? formatDate("Y-m-d",$data['drivinglicenseexpiry']) : null;
			$nationality = isset($data['nationality']) ? $data['nationality'] : null;
			$bloodgroup = isset($data['bloodgroup']) ? $data['bloodgroup'] : null;
			$govtidsocsec = isset($data['govtidsocsec']) ? $data['govtidsocsec'] : null;
			$reportsto = isset($data['reportsto']) ? $data['reportsto'] : null;
			$reportstoindirect = isset($data['reportstoindirect']) ? $data['reportstoindirect'] : null;
			$emerconperson = !empty($data['emerconperson']) ? $data['emerconperson'] : null;
			$emerconaddress = !empty($data['emerconaddress']) ? $data['emerconaddress'] : null;
			$emerconrelationship = !empty($data['emerconrelationship']) ? $data['emerconrelationship'] : null;
			$emerconno = !empty($data['emerconno']) ? $data['emerconno'] : null;
			$cnname = isset($data['cnname']) ? strtolower($data['cnname']) : null;
			$eestatus = isset($data['eestatus']) ? strtolower($data['eestatus']) : null;
			$eestat = strtolower($eestatus) == "active" ? 2 : 3;
			$stat = strtolower($eestatus) == "active" ? 1 : 0;
			$skype = isset($data['skype']) ? strtolower($data['skype']) : null;
			$wechat = isset($data['wechat']) ? strtolower($data['wechat']) : null;
			
			$ctccat = $data['contactcategory'];
			$abaUser = $data['abaUser'];
			$today = $data['today'];
			
			$sql = "INSERT INTO " . ABAPEOPLESMST . " (abaini,webhr_eetype,webhr_eecategory,webhr_designation,webhr_company,webhr_station,webhr_department,fname,lname,emailaddress,address,webhr_city,webhr_state,webhr_zipcode,webhr_country,webhr_status,presentaddress,presentcity,presentstate,presentzipcode,presentcountry,homephoneno,officephoneno,telext,mobileno,webhr_gender,birthdate,joineddate,passportno,passportexpiry,drivinglicenseno,drivinglicenseexpiry,webhr_nationality,webhr_bloodgroup,govtidsocsec,reportsto,reportstoindirect,emercontactperson,emercontactrelation,emercontactno,cnname,contactcategory,skype,wechat,status,createdby,createddate)
					VALUES('$abaini','$eetype','$eecat','$designation','$company','$station','$department','$fname','$lname','$email','$address','$city','$state','$zipcode','$country','$eestatus','$presentaddr','$presentcity','$presentstate','$presentzipcode','$presentcountry','$homephoneno','$officephoneno','$telext','$mobileno','$gender','$birthdate','$joineddate','$passportno','$passportexpiry','$drivinglicenseno','$drivinglicenseexpiry','$nationality','$bloodgroup','$govtidsocsec','$reportsto','$reportstoindirect','$emerconperson','$emerconrelationship','$emerconno','$cnname','$ctccat','$skype','$wechat','$stat','$abaUser','$today')";
			// echo $sql . '<br />';
			$qry = $this->cn->query($sql);
			if(!$qry){
				echo 'error saving abacarian $abaini. ' . $this->cn->error;
				exit();
			}
			$id = $this->cn->insert_id;
			$this->setInsertId($id);

			if(!empty($abaini) || $abaini != ""){
				$sql2 = "INSERT INTO " . ABBREVIATIONSMST . " (type,abvt,word,cnword,description,refid,category,createdby,createddate) 
						VALUES('1','$abaini','$eename','$cnname','$designation','$id','$eestat','$abaUser','$today')";
				// echo $sql2 . '<br />';
				$qry2 = $this->cn->query($sql2);
				if(!$qry2){
					echo 'error saving abvt. ' . $this->cn->error;
					// exit();
				}
				
				$pass = generatePassword("1234");
				$sql3 = "INSERT INTO " . USERSMST . " (username,password,abaini,fname,lname,mname,accesslevel,createdby,createddate) 
						VALUES('$abaini','$pass','$abaini','$fname','$lname','$mname','3','$abaUser','$today')";
				// echo $sql2 . '<br />';
				$qry3 = $this->cn->query($sql3);
				if(!$qry3){
					echo 'error saving user. ' . $this->cn->error;
					// exit();
				}
			}

			$this->cn->close();

			// AUDIT LOGS
			$adtlogs = array();
			$adtlogs['method'] = "CREATE";
			$adtlogs['pname'] = "abapeople";
			$adtlogs['dtl1'] = $sql;
			$adtlogs['dtl2'] = $sql2;
			$adtlogs['tbl'] = ABAPEOPLESMST;
			$adtlogs['rid'] = $id;
			$adtlogs['abaUser'] = $abaUser;
			$adtlogs['today'] = $today;

			$adt = new AuditLogs;
			$adt->saveAuditLog($adtlogs);
		}

		public function abacarianExist($data){
			$abaini = $data['abaini'];
			$fname = $data['fname'];
			$lname = $data['lname'];

			$sql = "SELECT * FROM " . ABAPEOPLESMST
					. " WHERE " . ABAPEOPLESMST . ".abaini = '$abaini'
						AND " . ABAPEOPLESMST . ".fname = '$fname'
						AND " . ABAPEOPLESMST . ".lname = '$lname'";
			// echo $sql . '<br />';
			$rows = array();
			$qry = $this->cn->query($sql);
			$row = $qry->fetch_array(MYSQLI_ASSOC);
			$result['cnt'] = $qry->num_rows;
			$result['id'] = $row['id'];
			if(!$qry){
				echo 'error function abacarianExist(). ' . $this->cn->error;
				exit();
			}
			// echo $result['cnt']  . ' ' . $abaini . '<br />';
			$this->cn->close();
			return $result;
		}

		public function updateImportedabaPeople($data){
			$sql2 = null;
			$id  = isset($data['id']) ? $data['id'] : null;
			$abaini = isset($data['abaini']) ? strtolower($data['abaini']) : null;
			$eetype = isset($data['eetype']) ? strtolower($data['eetype']) : null;
			$eecat = isset($data['eecategory']) ? strtolower($data['eecategory']) : null;
			$designation = isset($data['designation']) ? strtolower($data['designation']) : null;
			$company = isset($data['company']) ? strtolower($data['company']) : null;
			$station = isset($data['station']) ? strtolower($data['station']) : null;
			$department = isset($data['department']) ? strtolower($data['department']) : null;
			$fname = isset($data['fname']) ? ucfirst($data['fname']) : null;
			$lname = isset($data['lname']) ? strtoupper($data['lname']) : null;
			$eename = $fname . " " . $lname;
			$email = isset($data['email']) ? strtolower($data['email']) : null;
			$address = isset($data['address']) ? addslashes($data['address']) : null;
			$city = isset($data['city']) ? $data['city'] : null;
			$state = isset($data['state']) ? $data['state'] : null;
			$zipcode = isset($data['zipcode']) ? $data['zipcode'] : null;
			$country = isset($data['country']) ? $data['country'] : null;
			$presentaddr = isset($data['presentaddr']) ? addslashes($data['presentaddr']) : null;
			$presentcity = isset($data['presentcity']) ? $data['presentcity'] : null;
			$presentstate = isset($data['presentstate']) ? $data['presentstate'] : null;
			$presentzipcode = isset($data['presentzipcode']) ? $data['presentzipcode'] : null;
			$presentcountry = isset($data['presentcountry']) ? $data['presentcountry'] : null;
			$homephoneno = isset($data['homephoneno']) ? $data['homephoneno'] : null;
			$officephoneno = isset($data['officephoneno']) ? $data['officephoneno'] : null;
			$telext = isset($data['telext']) ? $data['telext'] : null;
			$mobileno = isset($data['mobileno']) ? $data['mobileno'] : null;
			$gender = isset($data['gender']) ? $data['gender'] : null;
			$birthdate = isset($data['birthdate']) ? formatDate("Y-m-d",$data['birthdate']) : null;
			$joineddate = isset($data['joineddate']) ? formatDate("Y-m-d",$data['joineddate']) : null;
			$passportno = isset($data['passportno']) ? $data['passportno'] : null;
			$passportexpiry = isset($data['passportexpiry']) ? formatDate("Y-m-d",$data['passportexpiry']) : null;
			$drivinglicenseno = isset($data['drivinglicenseno']) ? $data['drivinglicenseno'] : null;
			$drivinglicenseexpiry = isset($data['drivinglicenseexpiry']) ? formatDate("Y-m-d",$data['drivinglicenseexpiry']) : null;
			$nationality = isset($data['nationality']) ? $data['nationality'] : null;
			$bloodgroup = isset($data['bloodgroup']) ? $data['bloodgroup'] : null;
			$govtidsocsec = isset($data['govtidsocsec']) ? $data['govtidsocsec'] : null;
			$reportsto = isset($data['reportsto']) ? $data['reportsto'] : null;
			$reportstoindirect = isset($data['reportstoindirect']) ? $data['reportstoindirect'] : null;
			$emerconperson = !empty($data['emerconperson']) ? addslashes($data['emerconperson']) : null;
			$emerconaddress = !empty($data['emerconaddress']) ? addslashes($data['emerconaddress']) : null;
			$emerconrelationship = !empty($data['emerconrelationship']) ? $data['emerconrelationship'] : null;
			$emerconno = !empty($data['emerconno']) ? $data['emerconno'] : null;
			$cnname = isset($data['cnname']) ? strtolower($data['cnname']) : null;
			$eestatus = isset($data['eestatus']) ? strtolower($data['eestatus']) : null;
			$eestat = strtolower($eestatus) == "active" ? 2 : 3;
			$stat = strtolower($eestatus) == "active" ? 1 : 0;
			$skype = isset($data['skype']) ? strtolower($data['skype']) : null;
			$wechat = isset($data['wechat']) ? strtolower($data['wechat']) : null;
			
			$abaUser = $data['abaUser'];
			$today = $data['today'];

			$sql = "UPDATE " . ABAPEOPLESMST . " SET webhr_eetype ='$eetype', webhr_eecategory = '$eecat', webhr_designation = '$designation'
					, webhr_company = '$company', webhr_station = '$station', webhr_department = '$department', emailaddress = '$email', address = '$address'
					, webhr_city = '$city', webhr_state = '$state', webhr_zipcode = '$zipcode', webhr_country = '$country', webhr_status = '$eestatus'
					, presentaddress = '$presentaddr', presentcity = '$presentcity', presentstate = '$presentstate', presentzipcode = '$presentzipcode'
					, presentcountry = '$presentcountry', homephoneno = '$homephoneno', officephoneno = '$officephoneno', telext = '$telext'
					, mobileno = '$mobileno', webhr_gender = '$gender', birthdate = '$birthdate', joineddate = '$joineddate', passportno = '$passportno'
					, passportexpiry = '$passportexpiry', drivinglicenseno = '$drivinglicenseno', drivinglicenseexpiry = '$drivinglicenseexpiry'
					, webhr_nationality = '$nationality' , webhr_bloodgroup = '$bloodgroup', govtidsocsec = '$govtidsocsec', reportsto = '$reportsto'
					, reportstoindirect = '$reportstoindirect', emercontactperson = '$emerconperson', emercontactrelation = '$emerconrelationship'
					, emercontactno = '$emerconno', cnname = '$cnname', skype = '$skype', wechat = '$wechat', modifiedby = '$abaUser', modifieddate = '$today' 
					, status = '$stat' 
				WHERE " . ABAPEOPLESMST . ".id = '$id'";
			// echo $sql . '<br />';
			$qry = $this->cn->query($sql);
			if(!$qry){
				echo 'error updating abacarian $abaini. ' . $this->cn->error;
				// exit();
			}

			if(!empty($abaini) || $abaini != ""){
				$sql2 = "UPDATE " . ABBREVIATIONSMST
					. " SET abvt = '$abaini', word = '$eename', cnword = '$cnname', description = '$designation', category = '$eestat', modifiedby = '$abaUser'
						, modifieddate = '$today'
					WHERE " . ABBREVIATIONSMST . ".refid = '$id'
						AND " . ABBREVIATIONSMST . ".type = 1";

				$qry2 = $this->cn->query($sql2);
				if(!$qry2){
					echo 'error updating abvt $abaini. ' . $this->cn->error;
					exit();
				}
			}

			$this->cn->close();

			// AUDIT LOGS
			$adtlogs = array();
			$adtlogs['method'] = "UPDATE";
			$adtlogs['pname'] = "abapeople";
			$adtlogs['dtl1'] = $sql;
			$adtlogs['dtl2'] = $sql2;
			$adtlogs['tbl'] = ABAPEOPLESMST;
			$adtlogs['rid'] = $id;
			$adtlogs['abaUser'] = $abaUser;
			$adtlogs['today'] = $today;

			$adt = new AuditLogs;
			$adt->saveAuditLog($adtlogs);
		}
		public function getabaPeopleSorted($ofc){
			$where = "WHERE 1 ";
			if(strtoupper($ofc) != "ALL"){
				$where .= " AND " . ABAPEOPLESMST . ".webhr_station = '$ofc'";
			}
			
			$sql = "SELECT z.* FROM (";
			$sql .= "(SELECT " . ABAPEOPLESMST . ".*,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						," . DESIGNATIONSMST . ".description as designationname
						," . SALESOFFICESMST . ".description as salesofficename
						,a.dddescription as title
					FROM " . ABAPEOPLESMST
					. " LEFT JOIN " . DESIGNATIONSMST . " ON " . DESIGNATIONSMST . ".`id` = " . ABAPEOPLESMST . ".`designation` "
					. " LEFT JOIN " . SALESOFFICESMST . " ON " . SALESOFFICESMST . ".`id` = " . ABAPEOPLESMST . ".`salesoffice` "
					. " LEFT JOIN " . DROPDOWNSMST . " a ON a.ddid = " . ABAPEOPLESMST . ".`salutation` AND a.dddisplay = 'eesalutation' "
					. $where . " AND " . ABAPEOPLESMST . ".status = 1"
					. " ORDER BY " . ABAPEOPLESMST . ".`abaini`)";

			$sql .= " UNION ALL (SELECT " . ABAPEOPLESMST . ".*,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						," . DESIGNATIONSMST . ".description as designationname
						," . SALESOFFICESMST . ".description as salesofficename
						,a.dddescription as title
					FROM " . ABAPEOPLESMST
					. " LEFT JOIN " . DESIGNATIONSMST . " ON " . DESIGNATIONSMST . ".`id` = " . ABAPEOPLESMST . ".`designation` "
					. " LEFT JOIN " . SALESOFFICESMST . " ON " . SALESOFFICESMST . ".`id` = " . ABAPEOPLESMST . ".`salesoffice` "
					. " LEFT JOIN " . DROPDOWNSMST . " a ON a.ddid = " . ABAPEOPLESMST . ".`salutation` AND a.dddisplay = 'eesalutation' "
					. $where . " AND " . ABAPEOPLESMST . ".status = 0"
					. " ORDER BY " . ABAPEOPLESMST . ".`abaini`)) AS z ORDER BY z.fname";
			
			$rows = array();
			$qry = $this->cn->query($sql);
			if(!$qry){
				echo $this->cn->error;
				exit();
			}
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$this->cn->close();
			return $rows;
		}

		public function getabaPeopleByIni($ini){
			$where = "";
			$where .= " WHERE " . ABAPEOPLESMST . ".abaini = '$ini'";
			$sql = "SELECT " . ABAPEOPLESMST . ".*,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						," . DESIGNATIONSMST . ".description as designationname
						," . SALESOFFICESMST . ".description as salesofficename
						,a.dddescription as title
					FROM " . ABAPEOPLESMST
					. " LEFT JOIN " . DESIGNATIONSMST . " ON " . DESIGNATIONSMST . ".`id` = " . ABAPEOPLESMST . ".`designation` "
					. " LEFT JOIN " . SALESOFFICESMST . " ON " . SALESOFFICESMST . ".`salesofficeid` = " . ABAPEOPLESMST . ".`salesoffice` "
					. " LEFT JOIN " . DROPDOWNSMST . " a ON a.ddid = " . ABAPEOPLESMST . ".`salutation` AND a.dddisplay = 'eesalutation' "
					. $where . " AND " . ABAPEOPLESMST . ".status = 1"
					. " ORDER BY " . ABAPEOPLESMST . ".`abaini`";
					
			$rows = array();
			$qry = $this->cn->query($sql);
			if(!$qry){
				echo $this->cn->error;
				exit();
			}
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$this->cn->close();
			return $rows;
		}

		public function getReqby($id=""){	
			$where = "";
			if(!empty($id)){
				$where = " AND " . ABAPEOPLESMST . ".id = '$id'";	
			}

			$sql = "SELECT *, (CASE WHEN " . ABAPEOPLESMST . " . `status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname FROM " . ABAPEOPLESMST . " WHERE " . ABAPEOPLESMST . ".contactcategory = 1 " . $where . " ORDER BY " . ABAPEOPLESMST . " . `abaini`";

			$rows = array();
			$qry = $this->cn->query($sql);
			if(!$qry){
				echo $this->cn->error;
				exit();
			}

			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$this->cn->close();
			return $rows;
		}

		public function saveImportedContact($data){
			$sql2 = null;
			$abaini = isset($data['abaini']) ? strtolower($data['abaini']) : null;
			// $eetype = isset($data['eetype']) ? strtolower($data['eetype']) : null;
			// $eecat = isset($data['eecategory']) ? strtolower($data['eecategory']) : null;
			$designation = isset($data['designation']) ? strtolower($data['designation']) : null;
			// $company = isset($data['company']) ? strtolower($data['company']) : null;
			$station = isset($data['station']) ? strtolower($data['station']) : null;
			// $department = isset($data['department']) ? strtolower($data['department']) : null;
			$fname = isset($data['fname']) ? ucfirst($data['fname']) : null;
			$lname = isset($data['lname']) ? strtoupper($data['lname']) : null;
			$mname = isset($data['mname']) ? strtoupper($data['mname']) : null;
			// $eename = $fname . " " . $lname;
			$email = isset($data['email']) ? strtolower($data['email']) : null;
			// $address = isset($data['address']) ? addslashes($data['address']) : null;
			// $city = isset($data['city']) ? $data['city'] : null;
			// $state = isset($data['state']) ? $data['state'] : null;
			// $zipcode = isset($data['zipcode']) ? $data['zipcode'] : null;
			// $country = isset($data['country']) ? $data['country'] : null;
			// $presentaddr = isset($data['presentaddr']) ? addslashes($data['presentaddr']) : null;
			// $presentcity = isset($data['presentcity']) ? $data['presentcity'] : null;
			// $presentstate = isset($data['presentstate']) ? $data['presentstate'] : null;
			// $presentzipcode = isset($data['presentzipcode']) ? $data['presentzipcode'] : null;
			// $presentcountry = isset($data['presentcountry']) ? $data['presentcountry'] : null;
			// $homephoneno = isset($data['homephoneno']) ? $data['homephoneno'] : null;
			$officephoneno = isset($data['officephoneno']) ? $data['officephoneno'] : null;
			// $mobileno = isset($data['mobileno']) ? $data['mobileno'] : null;
			// $gender = isset($data['gender']) ? $data['gender'] : null;
			// $birthdate = isset($data['birthdate']) ? formatDate("Y-m-d",$data['birthdate']) : null;
			// $joineddate = isset($data['joineddate']) ? formatDate("Y-m-d",$data['joineddate']) : null;
			// $passportno = isset($data['passportno']) ? $data['passportno'] : null;
			// $passportexpiry = isset($data['passportexpiry']) ? formatDate("Y-m-d",$data['passportexpiry']) : null;
			// $drivinglicenseno = isset($data['drivinglicenseno']) ? $data['drivinglicenseno'] : null;
			// $drivinglicenseexpiry = isset($data['drivinglicenseexpiry']) ? formatDate("Y-m-d",$data['drivinglicenseexpiry']) : null;
			// $nationality = isset($data['nationality']) ? $data['nationality'] : null;
			// $bloodgroup = isset($data['bloodgroup']) ? $data['bloodgroup'] : null;
			// $govtidsocsec = isset($data['govtidsocsec']) ? $data['govtidsocsec'] : null;
			// $reportsto = isset($data['reportsto']) ? $data['reportsto'] : null;
			// $reportstoindirect = isset($data['reportstoindirect']) ? $data['reportstoindirect'] : null;
			// $emerconperson = !empty($data['emerconperson']) ? $data['emerconperson'] : null;
			// $emerconaddress = !empty($data['emerconaddress']) ? $data['emerconaddress'] : null;
			// $emerconrelationship = !empty($data['emerconrelationship']) ? $data['emerconrelationship'] : null;
			// $emerconno = !empty($data['emerconno']) ? $data['emerconno'] : null;
			$cnname = isset($data['cnname']) ? strtolower($data['cnname']) : null;
			// $eestatus = isset($data['eestatus']) ? strtolower($data['eestatus']) : null;
			// $eestat = $eestatus == "active" ? 2 : 3;
			// $stat = $eestatus != "active" ? 0 : 1;
			// $skype = isset($data['skype']) ? strtolower($data['skype']) : null;
			// $wechat = isset($data['wechat']) ? strtolower($data['wechat']) : null;
			
			$ctccat = $data['contactcategory'];
			$abaUser = $data['abaUser'];
			$today = $data['today'];
			
			$sql = "INSERT INTO " . ABAPEOPLESMST . " (abaini,webhr_eetype,webhr_eecategory,webhr_designation,webhr_company,webhr_station,webhr_department,fname,lname,emailaddress,address,webhr_city,webhr_state,webhr_zipcode,webhr_country,webhr_status,presentaddress,presentcity,presentstate,presentzipcode,presentcountry,homephoneno,officephoneno,mobileno,webhr_gender,birthdate,joineddate,passportno,passportexpiry,drivinglicenseno,drivinglicenseexpiry,webhr_nationality,webhr_bloodgroup,govtidsocsec,reportsto,reportstoindirect,emercontactperson,emercontactrelation,emercontactno,cnname,contactcategory,skype,wechat,status,createdby,createddate)
					VALUES('$abaini','$eetype','$eecat','$designation','$company','$station','$department','$fname','$lname','$email','$address','$city','$state','$zipcode','$country','$eestatus','$presentaddr','$presentcity','$presentstate','$presentzipcode','$presentcountry','$homephoneno','$officephoneno','$mobileno','$gender','$birthdate','$joineddate','$passportno','$passportexpiry','$drivinglicenseno','$drivinglicenseexpiry','$nationality','$bloodgroup','$govtidsocsec','$reportsto','$reportstoindirect','$emerconperson','$emerconrelationship','$emerconno','$cnname','$ctccat','$skype','$wechat','$stat','$abaUser','$today')";
			// echo $sql . '<br />';
			$qry = $this->cn->query($sql);
			if(!$qry){
				echo 'error saving abacarian $abaini. ' . $this->cn->error;
				exit();
			}
			$id = $this->cn->insert_id;
			$this->setInsertId($id);

			if(!empty($abaini) || $abaini != ""){
				$sql2 = "INSERT INTO " . ABBREVIATIONSMST . " (type,abvt,word,cnword,description,refid,category,createdby,createddate) 
						VALUES('1','$abaini','$eename','$cnname','$designation','$id','$eestat','$abaUser','$today')";
				// echo $sql2 . '<br />';
				$qry2 = $this->cn->query($sql2);
				if(!$qry2){
					echo 'error saving abvt. ' . $this->cn->error;
					// exit();
				}
				
				$pass = generatePassword("1234");
				$sql3 = "INSERT INTO " . USERSMST . " (username,password,abaini,fname,lname,mname,accesslevel,createdby,createddate) 
						VALUES('$abaini','$pass','$abaini','$fname','$lname','$mname','3','$abaUser','$today')";
				// echo $sql2 . '<br />';
				$qry3 = $this->cn->query($sql3);
				if(!$qry3){
					echo 'error saving user. ' . $this->cn->error;
					// exit();
				}
			}

			$this->cn->close();

			// AUDIT LOGS
			$adtlogs = array();
			$adtlogs['method'] = "CREATE";
			$adtlogs['pname'] = "abapeople";
			$adtlogs['dtl1'] = $sql;
			$adtlogs['dtl2'] = $sql2;
			$adtlogs['tbl'] = ABAPEOPLESMST;
			$adtlogs['rid'] = $id;
			$adtlogs['abaUser'] = $abaUser;
			$adtlogs['today'] = $today;

			$adt = new AuditLogs;
			$adt->saveAuditLog($adtlogs);
		}

		// SEARCH USER FOR CLIENT ACCESS
		public function searchUserClientAccess($data){
			$res = array();
			$sql = "";

			// SQL abaini
			$sql = "SELECT " . ABAPEOPLESMST . ".*,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						," . DESIGNATIONSMST . ".description as designationname
						," . SALESOFFICESMST . ".description as salesofficename
						,CONCAT(" . ABAPEOPLESMST . ".fname,' '," . ABAPEOPLESMST . ".mname,' '," . ABAPEOPLESMST . ".lname) as eename
						,a.dddescription as title
					FROM " . ABAPEOPLESMST
					. " LEFT JOIN " . DESIGNATIONSMST . " ON " . DESIGNATIONSMST . ".`id` = " . ABAPEOPLESMST . ".`designation` "
					. " LEFT JOIN " . SALESOFFICESMST . " ON " . SALESOFFICESMST . ".`id` = " . ABAPEOPLESMST . ".`salesoffice` "
					. " LEFT JOIN " . DROPDOWNSMST . " a ON a.ddid = " . ABAPEOPLESMST . ".`salutation` AND a.dddisplay = 'eesalutation' "
					. " WHERE " . ABAPEOPLESMST . ".abaini = '$data'
						AND " . ABAPEOPLESMST . ".status = 1";
			$sql .= " UNION ";
			$sql .= "SELECT " . ABAPEOPLESMST . ".*,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						," . DESIGNATIONSMST . ".description as designationname
						," . SALESOFFICESMST . ".description as salesofficename
						,CONCAT(" . ABAPEOPLESMST . ".fname,' '," . ABAPEOPLESMST . ".mname,' '," . ABAPEOPLESMST . ".lname) as eename
						,a.dddescription as title
					FROM " . ABAPEOPLESMST
					. " LEFT JOIN " . DESIGNATIONSMST . " ON " . DESIGNATIONSMST . ".`id` = " . ABAPEOPLESMST . ".`designation` "
					. " LEFT JOIN " . SALESOFFICESMST . " ON " . SALESOFFICESMST . ".`id` = " . ABAPEOPLESMST . ".`salesoffice` "
					. " LEFT JOIN " . DROPDOWNSMST . " a ON a.ddid = " . ABAPEOPLESMST . ".`salutation` AND a.dddisplay = 'eesalutation' "
					. " WHERE " . ABAPEOPLESMST . ".abaini LIKE '$data%' 
						AND " . ABAPEOPLESMST . ".status = 1";
			$sql .= " UNION ";
			$sql .= "SELECT " . ABAPEOPLESMST . ".*,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						," . DESIGNATIONSMST . ".description as designationname
						," . SALESOFFICESMST . ".description as salesofficename
						,CONCAT(" . ABAPEOPLESMST . ".fname,' '," . ABAPEOPLESMST . ".mname,' '," . ABAPEOPLESMST . ".lname) as eename
						,a.dddescription as title
					FROM " . ABAPEOPLESMST
					. " LEFT JOIN " . DESIGNATIONSMST . " ON " . DESIGNATIONSMST . ".`id` = " . ABAPEOPLESMST . ".`designation` "
					. " LEFT JOIN " . SALESOFFICESMST . " ON " . SALESOFFICESMST . ".`id` = " . ABAPEOPLESMST . ".`salesoffice` "
					. " LEFT JOIN " . DROPDOWNSMST . " a ON a.ddid = " . ABAPEOPLESMST . ".`salutation` AND a.dddisplay = 'eesalutation' "
					. " WHERE " . ABAPEOPLESMST . ".abaini LIKE '%$data%' 
						AND " . ABAPEOPLESMST . ".status = 1";
			$sql .= " UNION ";

			// SQL NAME
			$sql .= "SELECT " . ABAPEOPLESMST . ".*,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						," . DESIGNATIONSMST . ".description as designationname
						," . SALESOFFICESMST . ".description as salesofficename
						,CONCAT(" . ABAPEOPLESMST . ".fname,' '," . ABAPEOPLESMST . ".mname,' '," . ABAPEOPLESMST . ".lname) as eename
						,a.dddescription as title
					FROM " . ABAPEOPLESMST
					. " LEFT JOIN " . DESIGNATIONSMST . " ON " . DESIGNATIONSMST . ".`id` = " . ABAPEOPLESMST . ".`designation` "
					. " LEFT JOIN " . SALESOFFICESMST . " ON " . SALESOFFICESMST . ".`id` = " . ABAPEOPLESMST . ".`salesoffice` "
					. " LEFT JOIN " . DROPDOWNSMST . " a ON a.ddid = " . ABAPEOPLESMST . ".`salutation` AND a.dddisplay = 'eesalutation' "
					. " WHERE (" . ABAPEOPLESMST . ".fname = '$data' OR " . ABAPEOPLESMST . ".mname = '$data' OR " . ABAPEOPLESMST . ".lname = '$data') 
						AND " . ABAPEOPLESMST . ".status = 1";
			$sql .= " UNION ";
			$sql .= "SELECT " . ABAPEOPLESMST . ".*,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						," . DESIGNATIONSMST . ".description as designationname
						," . SALESOFFICESMST . ".description as salesofficename
						,CONCAT(" . ABAPEOPLESMST . ".fname,' '," . ABAPEOPLESMST . ".mname,' '," . ABAPEOPLESMST . ".lname) as eename
						,a.dddescription as title
					FROM " . ABAPEOPLESMST
					. " LEFT JOIN " . DESIGNATIONSMST . " ON " . DESIGNATIONSMST . ".`id` = " . ABAPEOPLESMST . ".`designation` "
					. " LEFT JOIN " . SALESOFFICESMST . " ON " . SALESOFFICESMST . ".`id` = " . ABAPEOPLESMST . ".`salesoffice` "
					. " LEFT JOIN " . DROPDOWNSMST . " a ON a.ddid = " . ABAPEOPLESMST . ".`salutation` AND a.dddisplay = 'eesalutation' "
					. " WHERE (" . ABAPEOPLESMST . ".fname LIKE '$data%' OR " . ABAPEOPLESMST . ".mname LIKE '$data%' OR " . ABAPEOPLESMST . ".lname LIKE '$data%') 
						AND " . ABAPEOPLESMST . ".status = 1";
			$sql .= " UNION ";
			$sql .= "SELECT " . ABAPEOPLESMST . ".*,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						," . DESIGNATIONSMST . ".description as designationname
						," . SALESOFFICESMST . ".description as salesofficename
						,CONCAT(" . ABAPEOPLESMST . ".fname,' '," . ABAPEOPLESMST . ".mname,' '," . ABAPEOPLESMST . ".lname) as eename
						,a.dddescription as title
					FROM " . ABAPEOPLESMST
					. " LEFT JOIN " . DESIGNATIONSMST . " ON " . DESIGNATIONSMST . ".`id` = " . ABAPEOPLESMST . ".`designation` "
					. " LEFT JOIN " . SALESOFFICESMST . " ON " . SALESOFFICESMST . ".`id` = " . ABAPEOPLESMST . ".`salesoffice` "
					. " LEFT JOIN " . DROPDOWNSMST . " a ON a.ddid = " . ABAPEOPLESMST . ".`salutation` AND a.dddisplay = 'eesalutation' "
					. " WHERE (" . ABAPEOPLESMST . ".fname LIKE '%$data%' OR " . ABAPEOPLESMST . ".mname LIKE '%$data%' OR " . ABAPEOPLESMST . ".lname LIKE '%$data%') 
						AND " . ABAPEOPLESMST . ".status = 1";

			$qry = $this->cn->query($sql);
			if(!$qry){
				echo $this->cn->error;
				exit();
			}
			
			$cnt = 0;
			$rows = array();
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$eeid = $row['id'];
				$abaini = $row['abaini'];
				$rows[$cnt] = $row;

				$sql1 = "SELECT a.*
							,b.`name` as salesofficename 
						FROM " . CLIENTUSERACCESS . " a
						LEFT JOIN " . SALESOFFICESMST . " b
							ON b.salesofficeid = a.salesofficeno
						WHERE a.eeid = '$eeid' 
							AND a.abaini = '$abaini' ";
				$qry1 = $this->cn->query($sql1);
				$cnt1 = $qry1->num_rows;
				$cnt2 = 0;
				$offices = "";

				while($row1 = $qry1->fetch_array(MYSQLI_ASSOC)){
					// $office[] = $row1;
					$cnt2++;
					$offices .= $row1['salesofficename'];
					if($cnt2 <> $cnt1){
						$offices .= ",";
					}
				}

				$rows[$cnt]['offices'] = $offices;
				$cnt++;
			}

			$res['rows'] = $rows;
			$res['cnt'] = $cnt;
			$this->cn->close();
			return $res;
		}

		public function getClientUserOfficeAccess($abaini){
			$res = array();
			$sql = "SELECT a.*
						,b.name as salesofficename 
					FROM " . CLIENTUSERACCESS . " a
					LEFT JOIN " . SALESOFFICESMST . " b
						ON b.salesofficeid = a.salesofficeno
					WHERE a.abaini = '$abaini' ";
			$qry = $this->cn->query($sql);
			$res['cnt'] = $qry->num_rows;

			$rows = array();
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$res['rows'] = $rows;
			$this->cn->close();
			return $res;
		}

		public function updateClientUserAccess($data){
			$ofcs = $data['ofcs'];
			$ofc = explode(",",$ofcs);
			$eeid = $data['eeid'];
			$abaini = $data['abaini'];
			$strOfc = "";

			if(!empty($ofcs)){
				for($i=0;$i<count($ofc);$i++){
					$ofcno = $ofc[$i];
					if(!empty($ofcno)){
						$sql = "SELECT a.* FROM " . CLIENTUSERACCESS . " a 
								WHERE a.eeid = '$eeid'
									AND a.abaini = '$abaini'
									AND a.salesofficeno = '$ofcno'";
						$qry = $this->cn->query($sql);
						$num = $qry->num_rows;
						$strOfc .= "'" . $ofcno . "',";

						if($num == 0){
							$ins = "INSERT INTO " . CLIENTUSERACCESS . "(eeid,abaini,salesofficeno) VALUES('$eeid','$abaini','$ofcno')";
							$qry = $this->cn->query($ins);
						}
					}
				}

				$strOfc = rtrim($strOfc,",");

				$del = "DELETE FROM " . CLIENTUSERACCESS . "
						WHERE " . CLIENTUSERACCESS . ".eeid = '$eeid'
							AND " . CLIENTUSERACCESS . ".abaini = '$abaini'
							AND " . CLIENTUSERACCESS . ".salesofficeno NOT IN($strOfc)";
				$qry = $this->cn->query($del);
			}else{
				$del = "DELETE FROM " . CLIENTUSERACCESS . "
						WHERE " . CLIENTUSERACCESS . ".eeid = '$eeid'
							AND " . CLIENTUSERACCESS . ".abaini = '$abaini'";
				$qry = $this->cn->query($del);
			}

			$this->cn->close();
			return $ofcs;
		}

		public function getNotBingoPlayers($id=""){
			$where = "";
			$sql = "SELECT " . ABAPEOPLESMST . ".*
						,CONCAT(
							(CASE WHEN " . ABAPEOPLESMST . ".fname != '' THEN " . ABAPEOPLESMST . ".fname ELSE '' END),' '
							,(CASE WHEN " . ABAPEOPLESMST . ".mname != '' THEN " . ABAPEOPLESMST . ".mname ELSE '' END),' '
							,(CASE WHEN " . ABAPEOPLESMST . ".lname != '' THEN " . ABAPEOPLESMST . ".lname ELSE '' END)) as eename
						,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						," . DESIGNATIONSMST . ".description as designationname
						," . SALESOFFICESMST . ".description as salesofficename
					FROM " . ABAPEOPLESMST
					. " LEFT JOIN " . DESIGNATIONSMST . " ON " . DESIGNATIONSMST . ".`id` = " . ABAPEOPLESMST . ".`designation` "
					. " LEFT JOIN " . SALESOFFICESMST . " ON " . SALESOFFICESMST . ".`id` = " . ABAPEOPLESMST . ".`salesoffice` "
					. " WHERE " . ABAPEOPLESMST . ".status = 1 AND " . ABAPEOPLESMST . ".contactcategory = 1 AND " . ABAPEOPLESMST . ".webhr_station IN('sscceb','opsceb')
					AND " . ABAPEOPLESMST . ".abaini NOT IN (SELECT " . BINGOPLAYERS . ".abaini FROM " . BINGOPLAYERS . ")"
					. " ORDER BY " . ABAPEOPLESMST . ".`abaini`";;
			
			$rows = array();
			$qry = $this->cn->query($sql);
			if(!$qry){
				echo $this->cn->error;
				exit();
			}
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$this->cn->close();
			return $rows;
		}

		public function getBDees($abaini=""){
			$where = "";
			if(!empty($abaini)){
				$where = "AND " . ABAPEOPLESMST . ".abaini = '$abaini' ";
			}
			$sql = "SELECT " . ABAPEOPLESMST . ".*
						,CONCAT(
							(CASE WHEN " . ABAPEOPLESMST . ".fname != '' THEN " . ABAPEOPLESMST . ".fname ELSE '' END),' '
							,(CASE WHEN " . ABAPEOPLESMST . ".mname != '' THEN " . ABAPEOPLESMST . ".mname ELSE '' END),' '
							,(CASE WHEN " . ABAPEOPLESMST . ".lname != '' THEN " . ABAPEOPLESMST . ".lname ELSE '' END)) as eename
						,(CASE WHEN " . ABAPEOPLESMST . ".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						," . DESIGNATIONSMST . ".description as designationname
						," . SALESOFFICESMST . ".description as salesofficename
						," . CMFBDREPORTSMST . ".iframe
					FROM " . ABAPEOPLESMST
					. " LEFT JOIN " . DESIGNATIONSMST . " ON " . DESIGNATIONSMST . ".`id` = " . ABAPEOPLESMST . ".`designation` "
					. " LEFT JOIN " . SALESOFFICESMST . " ON " . SALESOFFICESMST . ".`id` = " . ABAPEOPLESMST . ".`salesoffice` "
					. " LEFT JOIN " . CMFBDREPORTSMST . " ON " . CMFBDREPORTSMST . ".`abaini` = " . ABAPEOPLESMST . ".`abaini` "
					. " WHERE " . ABAPEOPLESMST . ".status = 1 
							AND " . ABAPEOPLESMST . ".contactcategory = 1 
							AND " . ABAPEOPLESMST . ".webhr_designation IN('business development manager','business development executive') $where"
					. " ORDER BY " . ABAPEOPLESMST . ".`webhr_station`," . ABAPEOPLESMST . ".`abaini`";
			
			$rows = array();
			$qry = $this->cn->query($sql);
			if(!$qry){
				echo $this->cn->error;
				exit();
			}
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$this->cn->close();
			return $rows;
		}

		public function getCSees($abaini=""){
			$where = "";
			if(!empty($abaini)){
				$where = "AND " . ABAPEOPLESMST . ".abaini = '$abaini' ";
			}
			$sql = "SELECT ". ABAPEOPLESMST .".*
						,CONCAT(
							(CASE WHEN ". ABAPEOPLESMST .".fname != '' THEN ". ABAPEOPLESMST .".fname ELSE '' END),' '
							,(CASE WHEN ". ABAPEOPLESMST .".mname != '' THEN ". ABAPEOPLESMST .".mname ELSE '' END),' '
							,(CASE WHEN ". ABAPEOPLESMST .".lname != '' THEN ". ABAPEOPLESMST .".lname ELSE '' END)) AS eename
						,(CASE WHEN ". ABAPEOPLESMST .".`status` = 1 THEN 'active' ELSE 'inactive' END) AS statusname
						,". SALESOFFICESMST .".description AS salesofficename
						,". CMFCSREPORTSMST .".iframe 
					FROM ". ABAPEOPLESMST ." LEFT JOIN ". SALESOFFICESMST ." ON ". SALESOFFICESMST .".`id` = ". ABAPEOPLESMST .".`salesoffice` 
					LEFT JOIN ". CMFCSREPORTSMST ." ON ". CMFCSREPORTSMST .".`abaini` = ". ABAPEOPLESMST .".`abaini` 
					WHERE ". ABAPEOPLESMST .".status = 1 
							AND ". ABAPEOPLESMST .".contactcategory = 1 
							AND ". ABAPEOPLESMST .".webhr_designation 
								IN('client service director','client servicing manager'
									,'account executive - corporate','account executive - individual'
									,'account supervisor - corporate','account supervisor - individual'
									,'client servicing manager - corporate','client servicing manager - individual'
									,'client servicing assistant manager - corporate','client servicing assistant manager - individual') 
					ORDER BY ". ABAPEOPLESMST .".`webhr_station`,". ABAPEOPLESMST .".`abaini`";
			
			$rows = array();
			$qry = $this->cn->query($sql);
			if(!$qry){
				echo $this->cn->error;
				exit();
			}
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$this->cn->close();
			return $rows;
		}

		public function getabacSnrMgt(){
			$sql = "SELECT ". ABAPEOPLESMST .".* 
					FROM ". ABAPEOPLESMST ." 
					WHERE ". ABAPEOPLESMST .".`webhr_designation` IN('general manager beijing'
										,'general manager hong kong'
										,'general manager singapore'
										,'general manager for china'
										,'general manager sscceb'
										,'chief operating officer'
										,'chairman'
										,'ceo') 
						AND ". ABAPEOPLESMST .".`status` = 1 
						AND ". ABAPEOPLESMST .".`emailaddress` != '' 		
						AND ". ABAPEOPLESMST .".`abaini` NOT IN(SELECT ". MKGREQUESTSNRMGT .".`abaini` FROM ". MKGREQUESTSNRMGT .")";
			
			$rows = array();
			$qry = $this->cn->query($sql);
			if(!$qry){
				echo $this->cn->error;
				exit();
			}
			while($row = $qry->fetch_array(MYSQLI_ASSOC)){
				$rows[] = $row;
			}

			$this->cn->close();
			return $rows;
			
		}

		public function closeDB(){
			$this->cn->close();
		}
	}
?>