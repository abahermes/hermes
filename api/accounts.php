<?php
    // include database and object files
    require_once('../inc/global.php');
    require_once('models/database.php');
    require_once('../inc/functions.php');
    require_once('models/accounts_model.php');
    require_once('models/dropdowns_model.php');
    require_once('models/employees_model.php');
	require_once('models/salesoffices_model.php');

    $result = array();
    $json = json_decode(file_get_contents("php://input"))->data;

    if(!empty($json)){
      $f = $json->f;
      $result = $f($json);
      // $result = $json;
    }

    function loadDefault($data){
      $res = array();
      $userid = $data->userid;
      $salesofcdesc = $data->salesofc;
		
      $accts = new AccountsModel;
      $res['accts'] = $accts->getAllAccounts($userid);

      $dd = new DropdownsModel;
      $res['titles'] = $dd->getCltProstTitles();
      $res['nats'] = $dd->getNationalitiesList();
      $res['eths'] = $dd->getEthnicitiesList();
      $res['cdmaffinity'] = $dd->getAffinities();

      $ees = new EmployeesModel;
      $res['ees'] = $ees->getActiveabaPeople();
		
      //sales office
      $salesofc = new SalesOfficesModel;
      $res['salesofc'] = $salesofc->getSalesOfficesOnly();
      $res['salesofcid']= $salesofc->getSalesOfficeByDesc($salesofcdesc);
      $accts->closeDB();

      return $res;
    }

    function sortingCltPros($data){
      $res = array();
      $val=array();

      $val['userid']=$data->userid;
      $val['sortby']=$data->sortby;
      $val['sortin']=$data->sortin;

      $cltpros = new AccountsModel;
      $res['cltpros'] = $cltpros->getSortedCltPros($val);

      return $res;
    }

    function searchCltPros($data){
      $res=array();
      $val=array();

      $val['searchtext']=$data->searchtext;
      $val['userid']=$data->userid;

      $search = new AccountsModel;
      $res['search'] = $search->searchCltPros($val);

      return $res;
    }

    function filterHeaderSearch($data){
      $res = array();
      $val = array();

      $val['userid']=$data->userid;
      $val['headerval']=$data->headerval;

      $search = new AccountsModel;
      $res['search'] = $search->filterHeaderTask($val);

      return $res;
    }

    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Expires: 0");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    echo json_encode($result);
?>