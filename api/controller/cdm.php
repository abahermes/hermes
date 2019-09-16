<?php
    // include database and object files
    include_once('../../inc/global.php');
    include_once('../../inc/functions.php');
    include_once('../models/fxrates.php');

    $result = array();
    $json = json_decode(file_get_contents("php://input"))->data;

    if(!empty($json)){
      $f = $json->f;
      $result = $f($json);
      // $result = $json;
    }

    function loadDefault($data){
      $res = array();
      $val['fisyr'] = date("Y");
      $val['month'] = "";
      $abauser = $data->abauser;

      $mnuaccess = new MenuUsersAccess;
      $res['hasAccess'] = $mnuaccess->hasAccess("FXRATES",$abauser);

      $mnuaccess = new MenuUsersAccess;
      $res['access'] = $mnuaccess->getMenuUsersAccesses("FXRATES",$abauser);

      $abappl = new abaPeople;
      $res['abac'] = $abappl->getActiveabaPeople();

      $rates = new FXRates;
      $res['rates'] = $rates->getFXRates($val);

      return $res;
    }

    function loadUserAccess($data){
      $res = array();
      $abauser = $data->abauser;

      $mnuaccess = new MenuUsersAccess;
      $res['hasAccess'] = $mnuaccess->hasAccess("FXRATES",$abauser);

      $mnuaccess = new MenuUsersAccess;
      $res['useraccesses'] = $mnuaccess->getMenuUsersAccesses("FXRATES",$abauser);

      $mnuaccess = new MenuUsersAccess;
      $res['menuaccesses'] = $mnuaccess->getMenuAccesses("FXRATES");

      return $res;
    }

    function updateUserAccess($data){
      $res = array();
      $val['abauser'] = $data->abauser;
      $val['ee'] = $data->ee;
      $val['mod'] = $data->mod;
      $val['lvl1'] = $data->lvl1;
      $val['lvl2'] = $data->lvl2;

      $mnuaccess = new MenuUsersAccess;
      $res['accesses'] = $mnuaccess->updateUserAccess($val);

      return $res;
    }

    function removeUserAccess($data){
      $res = array();
      $val['ee'] = $data->ee;
      $val['mod'] = $data->mod;
      $muid = $data->mod . $data->ee;

      $mnuaccess = new MenuUsersAccess;
      $res['accesses'] = $mnuaccess->removeUserAccess($muid);

      return $res;
    }

    function getFXRates($data){
      $res = array();
      $val['fisyr'] = $data->fiscalyear;
      $val['month'] = $data->month <= 9 ? '0'.$data->month : $data->month;

      $rates = new FXRates;
      $res['rates'] = $rates->getFXRates($val);

      return $res;
    }

    function setRatesActiveInactive($data){
      $res = array();
      $val['abauser'] = $data->abauser;
      $fisyr = $data->fiscalyear;
      $val['fiscalyear'] = $fisyr;
      $val['fxcode'] = $data->fxcode;
      $val['status'] = $data->status;

      $rates = new FXRates;
      $rates->setRatesActiveInactive($val);

      $rates = new FXRates;
      $res['rates'] = $rates->getFXRates($fisyr);

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