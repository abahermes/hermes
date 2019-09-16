<?php
    // include database and object files
    require_once('../inc/global.php');
    require_once('models/database.php');
    require_once('../inc/functions.php');
    require_once('models/tasks_model.php');

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

      $tasks = new TasksModel;
      $res['tasks'] = $tasks->getAllTasks($userid);

      $tasks->closeDB();

      return $res;
    }

    function sortingTask($data){
      $res = array();
      $val = array();

      $val['userid']=$data->userid;
      $val['sortby']=$data->sortby;
      $val['sortin']=$data->sortin;

      $tasks = new TasksModel;
      $res['tasks'] = $tasks->sortingTask($val);

      return $res;
    }

    function searchTask($data){
      $res = array();
      $val = array();

      $val['searchtext']=$data->searchtext;
      $val['searchby'] = $data->searchby;
      $val['userid']=$data->userid;

      $search = new TasksModel;
      $res['search'] = $search->searchTask($val);

      return $res;
    }

    function filterHeaderSearch($data){
      $res = array();
      $val = array();

      $val['userid']=$data->userid;
      $val['headerval']=$data->headerval;

      $search = new TasksModel;
      $res['search'] = $search->filterHeaderTask($val);

      return $res;
    }
    function BulkUpdateTaskDates($data){
        $res = array();
        $val=array();
        $val['selecteddata']['selected']=$data->selecteddata;
        $val['fieldname']=$data->fieldname;
        $val['datereplace']=$data->datereplace;

        $selected = new TasksModel;
        $res['selected'] = $selected->BulkUpdateTaskDates($val);

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