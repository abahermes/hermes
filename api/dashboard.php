<?php
	require_once('../inc/global.php');
	require_once('models/database.php');
	require_once('../inc/functions.php');
	require_once('models/tasks_model.php');
	require_once('models/todolist_model.php');
	require_once('models/opportunities_model.php');
	require_once('models/activities_model.php');
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
      $val=array();
      $userid = $data->userid;
      $val['userid'] = $userid;
      $val['searchtask'] ="";

      $tasks = new TasksModel;
      $res['tasks'] = $tasks->getAllTasks($userid);

      $tdl= new TodoListModel;
      $res['tdl'] = $tdl->getPendingTodoList($val);

      $opps = new OpportunitiesModel;
      $res['opps'] = $opps->getAllOpportunities($userid);

      $acts = new ActivitiesModel;
      $res['act'] = $acts->getActivitiesDashBoard($userid);

      $ppl = new EmployeesModel;
      $res['ppl'] = $ppl->getActiveabaPeopleWithId($userid);
      // $tasks->closeDB();

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