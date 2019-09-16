<?php
    // include database and object files
    require_once('../inc/global.php');
    require_once('models/database.php');
    require_once('../inc/functions.php');
    require_once('models/opportunities_model.php');
    require_once('models/fxrates_model.php');
    require_once('models/employees_model.php');

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

      $opps = new OpportunitiesModel;
      $res['opps'] = $opps->getAllOpportunities($userid);
      $opps->closeDB();

      $ppl = new EmployeesModel;
      $res['ppl'] = $ppl->getActiveabaPeopleWithId($userid);      

      return $res;
    }

    function SortingOpps($data){
      $res=array();
      $val=array();
      $val['userid']=$data->userid;
      $val['sortby']=$data->sortby;
      $val['sortin']=$data->sortin;

      $opps = new OpportunitiesModel;
      $res['opps'] = $opps->getSortedOpps($val);

      $opps->closeDB();

      return $res;
    }

    function SearchCltPros($data){
      $res=array();
      $val=array();

      $val['searchtext']=$data->searchtext;
      $val['userid']=$data->userid;

      $search = new OpportunitiesModel;
      $res['search'] = $search->searchCltPros($val);

      return $res;
    }

    function filterHeaderSearch($data){
      $res = array();
      $val = array();

      $val['userid']=$data->userid;
      $val['headerval']=$data->headerval;

      $search = new OpportunitiesModel;
      $res['search'] = $search->filterHeaderTask($val);

      return $res;
    }

    function computePremiumHKD($data){
      $res = array();
      $val['ccy'] = $data->ccy == "" ? 'HKD' : $data->ccy;
      $val['period'] = $data->targetdate == "" ? '' : formatDate("Ym",$data->targetdate);

      $fxrates = new FXRatesModel;
      $res['fxrates'] = $fxrates->computePremiumHKD($val)['rows'][0];

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