<?php
    // include database and object files
    include_once('../../inc/global.php');
    // include_once('../../inc/functions.php');
    // include_once('../models/clientprospect_model.php');

    $result = array();
    $json = json_decode(file_get_contents("php://input"))->data;

    if(!empty($json)){
      $f = $json->f;
      // $result = $f($json);
      $result = $json;
    }

    function loadDefault($data){
      
    }
      

    function saveCltProst($data){
      $res = array();

      return $data;
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